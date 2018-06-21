<?php

namespace App\Console\Commands;


use Apis\Api;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class StockListener extends Command
{
    protected $signature = 'stock:listener {code=sh600036} {--show=true}';

    protected $stockCode;
    protected $title = null;
    protected $show = false;
    protected $limit = 0.1;
    protected $linePrice = null;
    protected $max = null;
    protected $min = null;

    public function handle()
    {
        $this->stockCode = $this->argument('code');
        $this->show = $this->option('show')=='true'?true:false;
        //init
        $cache = \Illuminate\Support\Facades\Cache::get('stock' . $this->stockCode, []);
        if (!isset($cache['date']) || $cache['date'] != date('Y-m-d')) {
            $cache = [];
        }
        $this->linePrice = $cache['linePrice'] ?? null;
        $this->min = $cache['min'] ?? null;
        $this->max = $cache['max'] ?? null;
        while (true) {
            try {

                if (!(
                    Carbon::now()->between(Carbon::parse('9:30'), Carbon::parse('11:30')) ||
                    Carbon::now()->between(Carbon::parse('13:00'), Carbon::parse('15:00'))
                )) {
                    $this->info('sleep');
                    sleep(5);
                    continue;
                }

                $api = new Api();
                $stock = $api->getPrice($this->stockCode);
                $this->record($stock);
                $this->show("股票:{$stock['name']} 价格{$stock['price']}");
                if (empty($this->linePrice)) {
                    $this->linePrice = $stock['price'];
                }
//                if(empty($this->title)){
//                    $this->title = $stock['name'];
//                    if (function_exists('setproctitle')) {
//                        setproctitle($this->title);
//                    }
//                }
                if (empty($this->max)) {
                    $this->max = $stock['price'];
                }
                if (empty($this->min)) {
                    $this->min = $stock['price'];
                }
                if ($this->min > $stock['price']) {
                    $this->min = $stock['price'];
                    $this->sendMail('新最低价', $stock);
                }
                if ($this->max < $stock['price']) {
                    $this->max = $stock['price'];
                    $this->sendMail('新最高价', $stock);
                }
                if (abs($this->linePrice - $stock['price']) > $this->limit) {
                    $this->linePrice = $stock['price'];
                    $this->sendMail('价格变动', $stock);
                }
                \Illuminate\Support\Facades\Cache::forever('stock' . $this->stockCode, [
                    'linePrice' => $this->linePrice,
                    'max' => $this->max,
                    'min' => $this->min,
                    'date' => date('Y-m-d')
                ]);
            } catch (\Exception $e) {
                $this->info(date('Y-m-d H:i:s ') . $e->getMessage());
            }
            sleep(rand(1, 5));

        }
    }

    protected function sendMail($msg, $stock)
    {
        $title = $msg . "-股票:{$stock['name']} 价格{$stock['price']}";
        $this->show($title, true);
        if(!$this->show) {
            Mail::raw(var_export($stock, true), function ($msg) use ($title) {
                /**
                 * @var Message $msg
                 */
                $msg->to(['348578429@qq.com']);
                $msg->from(['1677937163@qq.com']);
                $msg->subject($title);
            });
        }
    }

    protected function show($msg, $isRed = false)
    {
        if($this->show ){
            if ($isRed) {
                $this->error(date('H:i:s') . ' ' . $msg);
            } else {
                $this->info(date('H:i:s') . ' ' . $msg);
            }
        }


    }

    protected function record($stock)
    {
        file_put_contents(storage_path('logs/stock' .$this->stockCode. date('Y-m-d')), json_encode(['time' => date('Y-m-d H:i:s'), 'stock' => $stock]) . PHP_EOL, FILE_APPEND);
    }
}