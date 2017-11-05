<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Auto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->testCacheNow();
        //
    }

    public function testCache()
    {
        $ids = [10, 14, 16, 17, 18];

        $cache = [];
        foreach ($ids as $id) {
            $now = $this->getNow($id);
            $nowconfig = $this->getNow($id, 'config', []);
            $nowCollects = $this->getNow($id, 'collect', []);
            //word-data
            $nowWordData = $this->getNow($id, 'word-data1', []);
            $nowWordData2 = $this->getNow($id, 'wordListData2', []);

            $cache[$id] = [
                ''              => $now,
                'config'        => $nowconfig,
                'collect'       => $nowCollects,
                'word-data1'    => $nowWordData,
                'wordListData2' => $nowWordData2,

            ];
        }
        file_put_contents(__DIR__ . '/../cache.php', '<?php return ' . var_export($cache, true) . ';');

    }

    public function testCacheNow()
    {
        $caches = require __DIR__ . '/../cache.php';
        foreach ($caches as $id => $data) {
            foreach ($data as $key => $val) {
                // dump($id,$val,$key);
                $this->cacheNow($id, $val, $key);
            }
        }
    }

    protected function cacheNow($id, $data, $prefix = '')
    {
        $k = 'word7000' . $prefix . $id;
        \Cache::put($k, $data, 1000);

    }

    protected function getNow($id, $prefix = '', $default = 0)
    {
        $k = 'word7000' . $prefix . $id;
        $data = \Cache::get($k, $default);

        return $data;
    }
}
