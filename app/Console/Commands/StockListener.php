<?php

namespace App\Console\Commands;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Stock\StockProxyService;
use Stock\StockService;


class StockListener extends Command
{
    protected $signature = 'stock:listener {--show=true}';

    protected $stockCode;
    protected $title = null;
    protected $debug = false;
    protected $limit = 0.1;
    protected $linePrice = null;
    protected $max = null;
    protected $min = null;

    public function handle()
    {
        $this->debug = $this->option('show') == 'true' ? true : false;
        $stockService = new StockProxyService();
        // $stockServices = [];
        if($this->debug){
            $stockService->add(['348578429@qq.com'], 'sz300355');
        }else{
            $stockService->add(['348578429@qq.com'], 'sh600036');
            $stockService->add(['1536687236@qq.com'], 'sz300355');
            $stockService->add([], 'sh600756');
            $stockService->add([], 'sz300676');
            $stockService->add([], 'sh600718');
            $stockService->add([], 'sz300168');
            $stockService->add([], 'sz300253');
        }


        // $stockServices = collect($stockServices);
        while (true) {
            try {

                // if (!(
                //     Carbon::now()->between(Carbon::parse('9:30'), Carbon::parse('11:30')) ||
                //     Carbon::now()->between(Carbon::parse('13:00'), Carbon::parse('15:00'))
                // )) {
                //     $this->info('sleep');
                //     sleep(5);
                //     continue;
                // }
                $msgs = $stockService->fetch();
                if ($this->debug) {
                    collect($msgs)->map(function ($msg) {
                        if ($msg['isRed']) {
                            $this->error($msg['msg']);
                        } else {
                            $this->info($msg['msg']);
                        }
                    });
                }

            } catch (\Exception $e) {
                $this->info(date('Y-m-d H:i:s ') . $e->getMessage());
            }
            sleep(rand(1, 5));

        }
    }


}