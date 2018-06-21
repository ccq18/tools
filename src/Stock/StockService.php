<?php

namespace Stock;


use Apis\Api;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class StockService
{

    protected $stockCode;
    protected $msgs = [];
    protected $mails = [];

    protected $limit = 0.1;
    protected $linePrice = null;
    protected $max = null;
    protected $min = null;

    protected $showMin;
    protected $showMax;

    public function __construct($mails = [], $stockCode, $limit = 0.1, $showMin=true, $showMax=true)
    {
        $this->stockCode = $stockCode;
        $this->mails = $mails;
        $this->limit = $limit;
        $this->showMax = $showMax;
        $this->showMin = $showMin;

        //init
        $cache = \Illuminate\Support\Facades\Cache::get('stock' . $this->stockCode, []);
        if (!isset($cache['date']) || $cache['date'] != date('Y-m-d')) {
            $cache = [];
        }
        $this->linePrice = $cache['linePrice'] ?? null;
        $this->min = $cache['min'] ?? null;
        $this->max = $cache['max'] ?? null;

    }

    public function fetch()
    {
        $api = new Api();
        $stock = $api->getPrice($this->stockCode);
        $this->record($stock);
        $this->showMsg("股票:{$stock['name']} 价格{$stock['price']}");
        if (empty($this->linePrice)) {
            $this->linePrice = $stock['price'];
        }
        if (empty($this->max)) {
            $this->max = $stock['price'];
        }
        if (empty($this->min)) {
            $this->min = $stock['price'];
        }
        if ($this->min > $stock['price'] && $this->showMin) {
            $this->min = $stock['price'];
            $this->sendMail('新最低价', $stock, $this->mails);
        }
        if ($this->max < $stock['price'] && $this->showMax) {
            $this->max = $stock['price'];
            $this->sendMail('新最高价', $stock, $this->mails);
        }
        if (abs($this->linePrice - $stock['price']) > $this->limit) {
            $this->linePrice = $stock['price'];
            $this->sendMail('价格变动', $stock, $this->mails);
        }
        \Illuminate\Support\Facades\Cache::forever('stock' . $this->stockCode, [
            'linePrice' => $this->linePrice,
            'max'       => $this->max,
            'min'       => $this->min,
            'date'      => date('Y-m-d')
        ]);

    }

    /**
     * @param $msg
     * @param $stock
     * @param array $mails
     */
    protected function sendMail($msg, $stock, $mails = [])
    {
        $title =  $msg . "-股票:{$stock['name']} 价格{$stock['price']}";
        $this->showMsg($title, true);
        if (!empty($mails)) {
            Mail::raw(var_export($stock, true), function ($msg) use ($title, $mails) {
                /**
                 * @var Message $msg
                 */
                $msg->to($mails);
                $msg->from([env('MAIL_USERNAME')]);
                $msg->subject($title);
            });
        }
    }

    protected function showMsg($msg, $isRed = false)
    {
        $this->msgs[] = ['msg' => date('H:i:s') . ' ' . $msg, 'isRed' => $isRed];
    }

    public function getMsgs()
    {
        return $this->msgs;
    }

    protected function record($stock)
    {
        file_put_contents(storage_path('logs/stock' . $this->stockCode . date('Y-m-d')),
            json_encode(['time' => date('Y-m-d H:i:s'), 'stock' => $stock]) . PHP_EOL, FILE_APPEND);
    }
}