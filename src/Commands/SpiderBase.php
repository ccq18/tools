<?php

namespace Commands;


use App\Model\Task;
use App\Model\TaskDocument;
use function GuzzleHttp\Psr7\str;
use Illuminate\Console\Command;

/**
 * Trait SpiderTrait
 * @package Commands
 *  static $baseUrl
 * static $domain
 */
abstract class SpiderBase extends Command
{
    // protected $signature = 'github_spider {runner}';

    protected $description = 'runner:task or parser';

    protected $baseUrl = null;
    protected $domain = null;

    public function handle()
    {
        $runner = $this->argument('runner');
        if ($runner == 'parse') {
            $this->runnerParser();
        } else {
            if ($runner == 'task') {
                $this->runnerTask();
            }
        }
        sleep(60);
    }

    public function runnerParser()
    {
        while (true) {
            $task = Task::whereStatus(Task::STATUS_SUCCESS)->where('parse_status', Task::PARSE_STATUS_SUCCESS)->first();
            if (empty($task)) {
                echo 'END' . PHP_EOL;
                break;
            }
            $task->parse_status = Task::PARSE_STATUS_RUNNING;
            $task->save();
            $rs = false;
            //根据页面类型解析
            try {
                $rs = $this->parse($task);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                echo $e->getMessage() . PHP_EOL;
            }
            if ($rs) {
                $task->status = Task::PARSE_STATUS_SUCCESS;
            } else {
                $task->status = Task::PARSE_STATUS_NONE;
            }
            $task->save();
        }
    }


    /**
     * @param Task $task
     * @return boolean
     */
    public abstract function parse(Task $task);

    public function runnerTask()
    {

        $http = new \Util\SpiderHttp();

        while (true) {
            $task = Task::whereStatus(Task::STATUS_INIT)->where('domain', $this->domain)->first();
            if (empty($task)) {
                $this->info('END');
                break;
            }
            $task->status = Task::STATUS_RUNNING;
            $task->save();
            $this->info($task->type . ' ' . $task->task_url);
            //根据页面类型解析
            try {
                $pageContent = $http->get($task->task_url);
                dump(strlen($pageContent));
                $this->setPageContent($task,$pageContent);
                $this->info(strlen($pageContent)>5?"success":"fail");
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                echo $e->getMessage() . PHP_EOL;
            }
        }

    }


    public function setPageContent(Task $task, $content)
    {
        if (strlen($content)>0) {
            $task->status = Task::PARSE_STATUS_SUCCESS;
            $doc = new TaskDocument();
            $doc->task_id = $task->id;
            $doc->page_content = $content;
            $doc->save();

        } else {
            $task->status = Task::PARSE_STATUS_NONE;
        }
        $task->save();


    }


    public function getUrl($url)
    {
        if (substr($url, 0, 4) == 'http') {
            return $url;
        }

        return rtrim($this->baseUrl, "/") . "/" . ltrim($url, "/");

    }

    public function addTask($taskUrl, $type, $domain = null)
    {
        $domain = $domain ?: $this->domain ?: "";
        Task::add([
            'domain'   => $domain,
            'task_url' => static::getUrl($taskUrl),
            'type'     => $type
        ]);
    }
}