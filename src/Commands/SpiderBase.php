<?php

namespace Commands;


use App\Model\Task;
use Illuminate\Console\Command;

/**
 * Trait SpiderTrait
 * @package Commands
 *  static $baseUrl
 * static $domain
 */
abstract class SpiderBase extends Command
{
    use SpiderHelper;

    protected $description = 'run spider';

    protected $baseUrl = '';
    protected $domain = '';


    public function handle()
    {
        if (Task::whereDomain($this->domain)->count() <= 0) {
            $this->initTask();
        }
        while (true) {
            $task = $this->upOneTask($this->domain);
            if (empty($task)) {
                $this->info('END');
                break;
            }
            $task->status = Task::STATUS_RUNNING;
            $task->save();
            $this->info($task->type . ' ' . $task->task_url ."\n". var_export($task->extra, true));
            //根据页面类型解析
            try {
                $pageContent = $this->runTask($task);
                $this->complateTask($task, $pageContent);
            } catch (\Exception $e) {
                //todo retry
                \Log::error($e->getMessage(), $e->getTrace());
                echo $e->getMessage() . PHP_EOL;
            }
            // sleep(60);
        }
    }

    public abstract function initTask();


    public abstract function runTask(Task $task);


    public function getUrl($url)
    {
        if (substr($url, 0, 4) == 'http') {
            return $url;
        }

        return rtrim($this->baseUrl, "/") . "/" . ltrim($url, "/");

    }

    protected function getHash($type, $taskUrl, $extra, $domain)
    {

        return md5(json_encode([$type, $taskUrl, $domain, $extra]));
    }

    /** 添加任务 带去重
     * @param $taskUrl
     * @param $type
     * @param array $extra
     * @param null $domain
     */
    public function addTask($type, $taskUrl, $extra = [], $domain = null)
    {
        $domain = $domain ?: $this->domain;
        Task::add($domain, static::getUrl($taskUrl), $type, $this->getHash($type, $taskUrl, $extra, $domain), $extra);
    }



    protected $cases = [];
    protected function addCase($type,$call){
        $this->cases[$type] = $call;
        return $this;
    }
    protected function doCase(Task $task){
        if(!empty($this->cases[$task->type])){
            return call_user_func($this->cases[$task->type]);
        }
        return '';
    }
}