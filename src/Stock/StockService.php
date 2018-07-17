<?php

namespace Stock;


use Apis\SinaStockApi;
use App\Model\Finance\Stock;
use App\Model\Finance\StockSecLog;
use Carbon\Carbon;
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

    public function run($stock)
    {
        // $api = new StockApi();
        // $stock = $api->getPrice($this->stockCode);
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
        /**
         *@var Stock $s
         */
        $code = Stock::getCode($this->stockCode);

        $s =  \Cache::remember('stock_cache_'.$this->stockCode,20,function ()use($code){
            return  Stock::whereCode($code['code'])->whereType($code['type'])->first();
        });
        $secLog = new StockSecLog();
        $secLog->stock_id = $s->id??0;
        $secLog->stock_code = $code['code'];
        $secLog->name = $stock['name'];
        $secLog->price = $stock['price'];
        $secLog->date = $stock['date'];
        $secLog->time = $stock['time'];
        $secLog->datetime = Carbon::parse( $stock['date'].$stock['time']);
        $secLog->max = $stock['max'];
        $secLog->min = $stock['min'];
        $secLog->buy1_price = $stock['buy1']['price'];
        $secLog->buy1_num = $stock['buy1']['num'];
        $secLog->buy2_price = $stock['buy2']['price'];
        $secLog->buy2_num = $stock['buy2']['num'];
        $secLog->buy3_price = $stock['buy3']['price'];
        $secLog->buy3_num = $stock['buy3']['num'];
        $secLog->buy4_price = $stock['buy4']['price'];
        $secLog->buy4_num = $stock['buy4']['num'];
        $secLog->buy5_price = $stock['buy5']['price'];
        $secLog->buy5_num = $stock['buy5']['num'];
        $secLog->sell1_price = $stock['sell1']['price'];
        $secLog->sell1_num = $stock['sell1']['num'];
        $secLog->sell2_price = $stock['sell2']['price'];
        $secLog->sell2_num = $stock['sell2']['num'];
        $secLog->sell3_price = $stock['sell3']['price'];
        $secLog->sell3_num = $stock['sell3']['num'];
        $secLog->sell4_price = $stock['sell4']['price'];
        $secLog->sell4_num = $stock['sell4']['num'];

        $secLog->save();

        file_put_contents(storage_path('logs/stock' . $this->stockCode . date('Y-m-d')),
            json_encode(['time' => date('Y-m-d H:i:s'), 'stock' => $stock]) . PHP_EOL, FILE_APPEND);
    }

    public function getStockCode()
    {
        return $this->stockCode;
    }
}