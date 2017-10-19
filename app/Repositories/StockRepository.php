<?php

namespace App\Repositories;


use App\Model\Finance\StockLog;
use Carbon\Carbon;

class StockRepository
{

    public function addStockLogFromWy($stockId, $wyLog)
    {
        $createdAt = Carbon::parse($wyLog[0]);
        $stockLog = StockLog::whereStockId($stockId)
                          ->where('created_at', $createdAt)
                          ->first();
        if (!empty($stockLog)) {
            return $stockLog;
        }
        $stockLog = new StockLog();
        $stockLog->stock_id = $stockId;
        $stockLog->open_price = $wyLog[1];
        $stockLog->close_price = $wyLog[2];
        $stockLog->high_price = $wyLog[3];
        $stockLog->low_price = $wyLog[4];
        $stockLog->price_change = $wyLog[6];
        $stockLog->turnover = $wyLog[5];
        $stockLog->price = $wyLog[2];
        $stockLog->created_at = $createdAt;
        $stockLog->save();
        return $stockLog;
    }

}