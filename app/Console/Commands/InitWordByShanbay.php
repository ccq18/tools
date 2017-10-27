<?php

namespace App\Console\Commands;

use App\Model\Lang\Word;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Util\Http;

class InitWordByShanbay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:init-by-shanbay {bookid=1}';

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
        $http = new Http();
        $i = 0;
         Word::where('book_id',1)->where('type','youdao')->orderBy('updated_at','asc')->limit(600)->get()->map(function(Word $word)use($http,&$i){
             $i++;
             try{
                 $tanslate = $http->getJson('https://api.shanbay.com/bdc/search/',['word'=>$word->word]);
                 if($tanslate['msg']!='SUCCESS'){
                     throw new \Exception('not find');
                 }
                 $example = [];
                 $exampleSys = $http->getJson('https://api.shanbay.com/bdc/example/',['vocabulary_id'=>$tanslate['data']['id'],'type'=>'sys']);
                 if($exampleSys['msg']!='SUCCESS'){
                     throw new \Exception('not find');
                 }
                 $exampleOther = $http->getJson('https://api.shanbay.com/bdc/example/',['vocabulary_id'=>$tanslate['data']['id']]);
                 if($exampleOther['msg']!='SUCCESS'){
                     throw new \Exception('not find');
                 }
                 $example['sys'] = $exampleSys['data'];
                 $example['other'] = $exampleOther['data'];
                 $this->info($word->word);
                 \DB::transaction(function ()use($word,$tanslate,$example){
                     $this->info('brefor:'.$word->getFirstTranslateText());
                     $word->type = 'shanbay';
                     $word->translate = $tanslate['data'];
                     $word->example = $example;
                     $word->save();
                     $word = Word::find($word->id);
                     $this->info('after:'.$word->getFirstTranslateText());
                 });
             }catch (\Exception $e){
                 $this->info($e->getMessage().'-'.$i);
                 $word = Word::find($word->id);
                 $word->updated_at = Carbon::now();
                 $word->save();
             }
             sleep(1);
         });
    }
}
