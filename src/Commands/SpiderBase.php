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
    protected $dom = null;
    public function __construct()
    {
        parent::__construct();
        $this->dom = new \PHPHtmlParser\Dom();
        $this->dom->setOptions(['enforceEncoding'=>'utf-8']);
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

    public function runnerTask()
    {
        if (Task::whereDomain($this->domain)->count() <= 0) {
            $this->runnerTaskInit();
        }

        $http = new \Util\SpiderHttp();

        while (true) {
            $task = Task::whereStatus(Task::STATUS_INIT)
                        ->whereDomain($this->domain)
                        ->first();
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
                preg_match('/\<meta.*?charset\=(.*?)\'.*?\>/is',$pageContent,$match);
                if(isset($match[1]) && strtolower($match[1]) != 'utf-8'){
                    $pageContent = iconv(strtolower($match[1]),"utf-8//IGNORE",$pageContent);
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
            $task = Task::whereDomain($this->domain)
                        ->whereStatus(Task::STATUS_SUCCESS)
                        ->where('parse_status', Task::PARSE_STATUS_INIT)
                        ->first();
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
}