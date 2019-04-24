<?php

namespace Commands;

use App\Model\Task;
use Illuminate\Console\Command;

//附加状态 pase_status
abstract class AutoSpider extends Command
{

    use SpiderHelper;
    protected $baseUrl = null;
    protected $domain = null;
    protected $description = 'runner:task or parser';


    public function handle()
    {
        $runner = $this->argument('runner');
        $this->http = new \Util\Http();
        if ($runner == 'parse') {
            $this->runParse();
        } else {
            if ($runner == 'task') {
                if (Task::whereDomain($this->domain)->count() <= 0) {
                    $this->initTask();
                }
                $this->runGet();
            }
        }
        sleep(60);
    }

    /**
     * @param Task $task
     * @return boolean
     */
    public abstract function parse(Task $task);

    public function initTask()
    {
        // TODO: Implement initTask() method.
    }

    public function fetchUrl($url)
    {
        $pageContent = $this->http->get($url);
        preg_match('/\<meta.*?charset\=(.*?)\'.*?\>/is', $pageContent, $match);
        if (isset($match[1]) && strtolower($match[1]) != 'utf-8') {
            $pageContent = iconv(strtolower($match[1]), "utf-8//IGNORE", $pageContent);
        }

        return $pageContent;
    }


    public function runGet()
    {

        while (true) {
            $task = $this->upOneTask($this->domain);
            if (empty($task)) {
                $this->info('END');
                break;
            }
            $task->status = Task::STATUS_RUNNING;
            $task->save();
            $this->info($task->type . ' ' . $task->task_url);
            //根据页面类型解析
            try {
                $pageContent = $this->fetchUrl($task->task_url);
                $this->complateTask($task, $pageContent);
                $this->info(strlen($pageContent) > 5 ? "success" : "fail");
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                echo $e->getMessage() . PHP_EOL;
            }
        }

    }



    public function runParse()
    {
        while (true) {
            /**
             * @var Task $task
             */
            $task = $this->upOneTaskByParseStatus($this->domain);
            if (empty($task)) {
                echo 'END' . PHP_EOL;
                break;
            }
            $this->info("parse:{$task->id},{$task->task_url}");
            $task->parse_status = Task::PARSE_STATUS_RUNNING;
            $task->save();
            $rs = false;
            //根据页面类型解析
            try {
                if (empty($task->taskDocument)) {
                    $rs = false;
                } else {
                    $rs = $this->parse($task);
                }
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                echo $e->getMessage() . PHP_EOL;
            }
            if ($rs) {
                $this->info("parse:success");
                $task->parse_status = Task::PARSE_STATUS_SUCCESS;
            } else {
                $this->info("parse:error");
                $task->parse_status = Task::PARSE_STATUS_NONE;
            }
            $task->save();
        }
    }

    public function upOneTaskByParseStatus($domain)
    {
        $num = \DB::update("UPDATE tasks set parse_status=:to_parse_status,id=(select @running_parse_task_id:=id) WHERE parse_status=:from_parse_status  and domain=:domain  LIMIT 1",
            [
                ':domain'            => $domain,
                ':status'            => Task::STATUS_SUCCESS,
                ':from_parse_status' => Task::PARSE_STATUS_INIT,
                ':to_parse_status'   => Task::PARSE_STATUS_RUNNING
            ]
        );
        if ($num <= 0) {
            return null;
        }
        $nowData = \DB::selectOne("select @running_parse_task_id");

        return Task::find(object_get($nowData, '@running_parse_task_id'));
    }

    public function getUrl($url)
    {
        if (substr($url, 0, 4) == 'http') {
            return $url;
        }

        return rtrim($this->baseUrl, "/") . "/" . ltrim($url, "/");

    }
    protected function getHash($taskUrl, $type, $domain , $extra = [])
    {
        return md5(json_encode([$taskUrl,$type,$domain,$extra]));
    }

    public function addTask($taskUrl, $type, $extra=[], $domain = null)
    {
        $domain = $domain ?: $this->domain ?: "";
        Task::add($domain, static::getUrl($taskUrl), $type, $this->getHash($taskUrl, $type, $domain, $extra),$extra);
    }


}