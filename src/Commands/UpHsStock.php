<?php

namespace Commands;

use App\Model\Finance\Stock;
use App\Model\Finance\StockLog;
use App\Repositories\StockRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpHsStock extends Command
{
    protected $signature = 'up-hs-stock';

    protected $description = 'update stock';

    public function handle()
    {
        $stocks = Stock::whereType(Stock::TYPE_SH)->get();
        $this->upStocks($stocks);
        $stocks = Stock::whereType(Stock::TYPE_SZ)->get();
        $this->upStocks($stocks);
    }

    public function upStocks($stocks)
    {
        $http = new \Util\Http();
        collect($stocks)->map(function(Stock $stock)use($http){
            $y = date('Y');
            if ($stock->type == Stock::TYPE_SH) {
                $url = "http://img1.money.126.net/data/hs/kline/day/history/{$y}/0{$stock->code}.json";
            } elseif ($stock->type == Stock::TYPE_SZ) {
                $url = "http://img1.money.126.net/data/hs/kline/day/history/{$y}/1{$stock->code}.json";
            }else{
                return;
            }

            $data = $http->getJson($url);
            $last = StockLog::whereStockId($stock->id)->orderByDesc('created_at')->first();

            foreach ($data['data'] as $v) {

                $createdAt = Carbon::parse($v[0]);
                if(empty($last)||$createdAt>$last->created_at){
                    resolve(StockRepository::class)->addStockLogFromWy($stock->id,$v);
                    $this->info($createdAt->format('Y-m-d').':'.$stock->code);
                }

            }
            sleep(1);
        });

    }
}