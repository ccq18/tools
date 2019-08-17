<?php

namespace App\Console\Commands;


use App\Model\Lang\Word;
use Illuminate\Console\Command;
use Ido\Tools\Util\FileReader;

class Translate extends Command
{
    protected $signature = 'translare:java';


    public function handle()
    {

        $i=0;
        $arr = FileReader::readAllLine(resource_path('data/java_word'),function ($s)use (&$i){
            // $i++;
            // if($i>10){
            //     return '';
            // }
            $arr = explode(',',$s);
            $this->info($s);
            if(count($arr) == 2){
                $w =  Word::whereWord($arr[0])->first();
                if(empty($w)){
                    return $s;
                }
                $t = "{$arr[0]},{$w->simple_trans}";
                return $t;
            }
            return '';
        });
        FileReader::writeLines(resource_path('data/java_word.txt'),collect($arr)->filter()->all());
        // dump(array_slice($arr,0,10));
        $this->info('success');
    }

}