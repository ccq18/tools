<?php

namespace Commands;


use App\Model\Finance\Stock;
use App\Model\Finance\StockLog;
use App\Model\Task;
use Carbon\Carbon;
use PHPHtmlParser\Dom\AbstractNode;
use Util\Db;

class HsStock extends SpiderBase
{


    protected $signature = 'hs-stock-spider {runner}';

    protected $baseUrl = 'http://www.wstock.net/';
    protected $domain = 'wstock.net';

    const TYPE_SH_STOCK_CODE = 'sh-stock-code';
    const TYPE_SZ_STOCK_CODE = 'sz-stock-code';
    const TYPE_SH_STOCK_DETAIL = 'sh-stock-detail';
    const TYPE_SZ_STOCK_DETAIL = 'sz-stock-detail';

    public function runnerTaskInit()
    {
        $this->addTask('http://www.wstock.net/wstock/market/shcode1.htm', static::TYPE_SH_STOCK_CODE);
        $this->addTask('http://www.wstock.net/wstock/market/szcode1.htm', static::TYPE_SZ_STOCK_CODE);

    }

    public function parse(Task $task)
    {
        //http://img1.money.126.net/data/hs/kline/day/history/2005/0600590.json

        $str = $task->taskDocument->page_content;
        switch ($task->type) {
            case static::TYPE_SH_STOCK_CODE:
            case static::TYPE_SZ_STOCK_CODE:
                $r = $this->parseStock($str, $task);
                break;
            case static::TYPE_SH_STOCK_DETAIL:
            case static::TYPE_SZ_STOCK_DETAIL:
                $r = $this->parseStockDetail($str, $task);
                break;

        }

        return $r;
    }

    public function parseStock($str, Task $task)
    {
        $this->dom->load($str);
        $r = $this->dom->find("[class=TextBody]");
        /**
         * @var AbstractNode $r
         * @var AbstractNode[] $as
         */
        $as = $r->find('a');
        foreach ($as as $v) {
            if (trim($v->text()) == '下一页') {
                $this->addTask($this->filterRelativeUrl($v->getAttribute('href'), $task->task_url), $task->type);
            } elseif (intval($v->text()) > 0) {
                $this->addStockTasksByCode(trim($v->text()), $task);

            }
        }

        return true;
    }


    public function addStockTasksByCode($code, Task $task)
    {
        for ($y = 2015; $y <= intval(date('Y')); $y++) {
            if ($task->type == static::TYPE_SH_STOCK_CODE) {
                $this->addTask("http://img1.money.126.net/data/hs/kline/day/history/{$y}/0{$code}.json",
                    static::TYPE_SH_STOCK_DETAIL);
            } elseif ($task->type == static::TYPE_SZ_STOCK_CODE) {
                $this->addTask("http://img1.money.126.net/data/hs/kline/day/history/{$y}/1{$code}.json",
                    static::TYPE_SZ_STOCK_DETAIL);

            }

        }
    }

    public function parseStockDetail(
        $str,
        Task $task
    ) {
        try {
            $rs = json_decode($str, true);
            if (empty($rs)) {
                return false;
            }

            if ($task->type == static::TYPE_SH_STOCK_DETAIL) {
                $type = Stock::TYPE_SH;
            } elseif ($task->type == static::TYPE_SZ_STOCK_DETAIL) {
                $type = Stock::TYPE_SZ;
            } else {
                return false;
            }
            $stock = Stock::whereCode($rs['symbol'])->whereType($type)->first();
            if (empty($stock)) {
                $stock = new Stock();
                $stock->type = $type;
                $stock->code = $rs['symbol'];
                $stock->title = $rs['name'];
                $stock->unit = '元';
                $stock->save();
            }


            foreach ($rs['data'] as $v) {
                $stockLog = new StockLog();
                $stockLog->stock_id = $stock->id;
                $stockLog->open_price = $v[1];
                $stockLog->close_price = $v[2];
                $stockLog->high_price = $v[3];
                $stockLog->low_price = $v[4];
                $stockLog->price_change = $v[6];
                $stockLog->turnover = $v[5];
                $stockLog->price = $v[2];
                $stockLog->created_at = Carbon::parse($v[0]);
                $stockLog->save();

            }

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $this->info($e->getMessage());

            return false;
        }

        return true;


    }

}