<?php

namespace PnctlProcess;

//t.start();
// 　　sleep(): 强迫一个线程睡眠Ｎ毫秒。
// 　　isAlive(): 判断一个线程是否存活。
// 　　join(): 等待线程终止。
// 　　activeCount(): 程序中活跃的线程数。
// 　　enumerate(): 枚举程序中的线程。
//     currentThread(): 得到当前线程。
// 　　isDaemon(): 一个线程是否为守护线程。
// 　　setDaemon(): 设置一个线程为守护线程。(用户线程和守护线程的区别在于，是否等待主线程依赖于主线程结束而结束)
// 　　setName(): 为线程设置一个名称。
// 　　wait(): 强迫一个线程等待。
// 　　notify(): 通知一个线程继续运行。
// 　　setPriority(): 设置一个线程的优先级。
//synchronized 线程同步

abstract class Process
{
    /**
     * Status starting.
     *
     * @var int
     */
    const STATUS_STARTING = 1;

    /**
     * Status running.
     *
     * @var int
     */
    const STATUS_RUNNING = 2;

    /**
     * Status shutdown.
     *
     * @var int
     */
    const STATUS_SHUTDOWN = 4;

    /**
     * Status reloading.
     *
     * @var int
     */
    const STATUS_RELOADING = 8;

    static $activeCount = 1;
    static $pids = [];


    public function start()
    {
        static::$activeCount += 1;
        $id = pcntl_fork();
        if ($id <= 0) {
            self::setProcessTitle('php: worker process  ' . get_class($this));
            $this->run();
            exit;
        }
        static::$pids[] = $id;

        return $id;
    }

    public function startLoop()
    {
        static::$activeCount += 1;
        $id = pcntl_fork();
        if ($id <= 0) {
            self::setProcessTitle('php: worker process  ' . get_class($this));
            while (true) {
                static::signalDispatch();
                $this->run();
            }

            exit;
        }
        static::$pids[] = $id;

    }

    protected function run()
    {

    }

//强迫一个线程睡眠Ｎ毫秒
    public static function usleep($i)
    {
        usleep($i);
    }

    public static function msleep($i)
    {
        usleep($i * 1000);
    }

    public static function sleep($i)
    {
        sleep($i);
    }

    public static function stop($pid)
    {
        posix_kill($pid, SIGINT);

    }

    /**
     * Set process name.
     *
     * @param string $title
     * @return void
     */
    protected static function setProcessTitle($title)
    {
        // >=php 5.5
        if (function_exists('cli_set_process_title')) {
            @cli_set_process_title($title);
        } // Need proctitle when php<=5.5 .
        elseif (extension_loaded('proctitle') && function_exists('setproctitle')) {
            @setproctitle($title);
        }
    }

    public function setSignal($signo, $callback, $restartSysCalls = false)
    {
       return pcntl_signal($signo, $callback, $restartSysCalls);
    }

    public static function signalDispatch()
    {
       return pcntl_signal_dispatch();
    }

    public static function kill($pid, $sig)
    {
        return posix_kill($pid, $sig);
    }

    public function getPid()
    {
        return posix_getpid();
    }
    //todo
//判断一个线程是否存活
    public static function isAlive($pid)
    {

    }


    //程序中活跃的线程数。
    public function activeCount()
    {
        static::$activeCount;
    }

    //枚举程序中的线程
    public function enumerate()
    {

    }

    //得到当前线程。
    public function currentThread()
    {

    }

//一个线程是否为守护线程。
    public function isDaemon()
    {

    }

// 设置一个线程为守护线程。(用户线程和守护线程的区别在于，是否等待主线程依赖于主线程结束而结束)
    public function setDaemon()
    {

    }

    public function setName()
    {

    }

//强迫一个线程等待
    public function wait()
    {

    }

//通知一个线程继续运行
    public function notify()
    {

    }

    //设置一个线程的优先级
    public function setPriority()
    {

    }
}