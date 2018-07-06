<?php

namespace App\Console\Commands;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Stock\StockService;


class StockListener extends Command
{
    protected $signature = 'stock:listener {--show=true}';

    protected $stockCode;
    protected $title = null;
    protected $show = false;
    protected $limit = 0.1;
    protected $linePrice = null;
    protected $max = null;
    protected $min = null;

    public function handle()
    {
        $this->show = $this->option('show') == 'true' ? true : false;
        $stockServices = [];
        if($this->show){
            $stockServices[] = new StockService(['348578429@qq.com'], 'sz300355');
        }else{
            $stockServices[] = new StockService(['348578429@qq.com'], 'sh600036');
            $stockServices[] = new StockService(['1536687236@qq.com'], 'sz300355');
            $stockServices[] = new StockService([], 'sh600756');
            $stockServices[] = new StockService([], 'sz300676');
            $stockServices[] = new StockService([], 'sh600718');
            $stockServices[] = new StockService([], 'sz300168');
            $stockServices[] = new StockService([], 'sz300253');
        }


        $stockServices = collect($stockServices);
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
                $stockServices->map(function ($stockService) {
                    /**
                     * @var StockService $stockService
                     */
                    $stockService->fetch();
                    $msgs = $stockService->getMsgs();
                    if ($this->show) {
                        collect($msgs)->map(function ($msg) {
                            if ($msg['isRed']) {
                                $this->error($msg['msg']);
                            } else {
                                $this->info($msg['msg']);
                            }
                        });
                    }
                    sleep(rand(1, 3));
                });

            } catch (\Exception $e) {
                $this->info(date('Y-m-d H:i:s ') . $e->getMessage());
            }
            sleep(rand(1, 5));

        }
    }


}