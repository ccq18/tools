<?php

namespace Commands;


use App\Model\Task;
use App\Model\TaskDocument;
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

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $str
     * @return \PHPHtmlParser\Dom
     */
    public function dom($str)
    {
        $dom = new \PHPHtmlParser\Dom();
        $dom->setOptions(['enforceEncoding' => 'utf-8']);
        $dom->load($str);

        return $dom;
    }

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

    public function upOneTask($domain)
    {
        $num = \DB::update("UPDATE tasks set status=:to_status,id=(select @running_task_id:=id) WHERE status=:from_status  and domain=:domain  LIMIT 1",
            [
                ':domain'      => $domain,
                ':from_status' => Task::STATUS_INIT,
                ':to_status'   => Task::STATUS_RUNNING
            ]);
        if ($num <= 0) {
            return null;
        }
        $nowData = \DB::selectOne("select @running_task_id");

        return Task::find(object_get($nowData, '@running_task_id'));
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

    public function runnerTask()
    {
        if (Task::whereDomain($this->domain)->count() <= 0) {
            $this->runnerTaskInit();
        }

        $http = new \Util\Http();

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
                $pageContent = $http->get($task->task_url);
                preg_match('/\<meta.*?charset\=(.*?)\'.*?\>/is', $pageContent, $match);
                if (isset($match[1]) && strtolower($match[1]) != 'utf-8') {
                    $pageContent = iconv(strtolower($match[1]), "utf-8//IGNORE", $pageContent);
                }

                $this->setPageContent($task, $pageContent);
                $this->info(strlen($pageContent) > 5 ? "success" : "fail");
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                echo $e->getMessage() . PHP_EOL;
            }
        }

    }


    public function runnerParser()
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


    public function runnerTaskInit()
    {
    }

    /**
     * @param Task $task
     * @return boolean
     */
    public function parse(Task $task)
    {
    }


    public function setPageContent(Task $task, $content)
    {
        if (strlen($content) > 0) {
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

    /**
     * 把从HTML源码中获取的相对路径转换成绝对路径
     * @param string $url HTML中获取的网址
     * @param string $baseUrl 用来参考判断的原始地址
     * @return bool|string 返回修改过的网址，如果网址有误则返回FALSE
     */
    public function filterRelativeUrl($url, $baseUrl)
    {
        //STEP1: 先去判断URL中是否包含协议，如果包含说明是绝对地址则可以原样返回
        if (strpos($url, '://') !== false) {
            return $url;
        }
        //STEP2: 解析传入的URI

        if (strpos($baseUrl, '://') !== false) {
            $uriPart = parse_url($baseUrl);
            if ($uriPart == false) {
                return false;
            }
            $uriRoot = $uriPart['scheme'] . '://' . $uriPart['host'] . (isset($uriPart['port']) ? ':' . $uriPart['port'] : '');
            $uriDir = (isset($uriPart['path']) && $uriPart['path']) ? '/' . ltrim(dirname($uriPart['path']), '/') : '';
        } elseif (!empty($baseUrl) && $baseUrl{0} == '/') {
            $uriDir = '/' . ltrim(dirname($baseUrl), '/');
            $uriRoot = '';
        } else {
            return false;
        }

        //STEP3: 如果URL以左斜线开头，表示位于根目录
        if (strpos($url, '/') === 0) {
            return $uriRoot . $url;
        }
        //STEP4: 不位于根目录，也不是绝对路径，考虑如果不包含'./'的话，需要把相对地址接在原URL的目录名上

        if (strpos($url, './') === false) {
            return rtrim($uriRoot . '/' . trim($uriDir, '/'), '/') . '/' . $url;
        }
        //STEP5: 如果相对路径中包含'../'或'./'表示的目录，需要对路径进行解析并递归
        //STEP5.1: 把路径中所有的'./'改为'/'，'//'改为'/'
        $url = preg_replace('/[^\.]\.\/|\/\//', '/', $url);
        if (strpos($url, './') === 0) {
            $url = substr($url, 2);
        }
        //STEP5.2: 使用'/'分割URL字符串以获取目录的每一部分进行判断
        $uriFullDir = ltrim($uriDir . '/' . $url, '/');
        $urlArr = explode('/', $uriFullDir);
        if ($urlArr[0] == '..') {
            return false;
        }
        //因为数组的第一个元素不可能为'..'，所以这里从第二个元素开始循环
        $dstArr = $urlArr;  //拷贝一个副本，用于最后组合URL
        for ($i = 1; $i < count($urlArr); $i++) {
            if ($urlArr[$i] == '..') {
                $j = 1;
                while (true) {
                    if ($i - $j < 0) {
                        return false;
                    }
                    if (isset($dstArr[$i - $j]) && $dstArr[$i - $j] != false) {
                        $dstArr[$i - $j] = false;
                        $dstArr[$i] = false;
                        break;
                    } else {
                        $j++;
                    }

                }
            }
        }
        // 组合最后的URL并返回
        $dstStr = $uriRoot;
        foreach ($dstArr as $val) {
            if ($val != false) {
                $dstStr .= '/' . $val;
            }
        }

        return $dstStr;
    }

}