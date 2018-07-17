<?php

namespace Stock;


use Apis\SinaStockApi;
use App\Model\Finance\Stock;
use App\Model\Finance\StockSecLog;
use Carbon\Carbon;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class StockProxyService
{


    /**
     * @var StockService[]
     */
    protected $stockServices = [];

    public function add($mails = [], $stockCode, $limit = 0.1, $showMin = true, $showMax = true)
    {
        $this->stockServices[] = new StockService($mails, $stockCode, $limit, $showMin, $showMax);
    }

    public function fetch()
    {
        $msgs = [];
        foreach ($this->stockServices as $stockService) {

            $api = new SinaStockApi();
            $stock = $api->getPrice($stockService->getStockCode());
            /**
             * @var StockService $stockService
             */
            $stockService->run($stock);
            $msgs = array_merge($msgs, $stockService->getMsgs());
            sleep(rand(1, 3));
        }

        return $msgs;

    }


}