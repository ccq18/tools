<?php

namespace App\Console\Commands;

use App\Model\Lang\Sent;
use App\Model\Lang\Word;
use Illuminate\Console\Command;

class BuildSent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:build-sent';

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
        $s1 = $this->getSentByFile(resource_path('/data/1.txt'));
        $s2 = $this->getSentByFile(resource_path('/data/2.txt'));
        $s3 = $this->getSentByFile(resource_path('/data/3.txt'));
        $s4 = $this->getSentByFile(resource_path('/data/4.txt'));
        $s5 = $this->getSentByFile(resource_path('/data/5.txt'));
        $s6 = $this->getSentByFile(resource_path('/data/6.txt'));
        $s7 = $this->getSentByFile(resource_path('/data/7.txt'));
        $s9 = $this->getSentByFile(resource_path('/data/9.txt'));
        $s8 = $this->getSentByFile(resource_path('/data/8.txt'));

        $s = array_merge($s1,$s2,$s3,$s4,$s5,$s6,$s7,$s9);
        $ss = [];
        foreach ($s as $k=>$v){
            $ss[$v['orig']] = $v;
        }
        foreach ($ss as $k=>$v){
           $s = Sent::where('orig',$v['orig'])->first();
           if(!empty($s)){
               continue;
           }
            $s= new Sent();
            $s->orig = $v['orig'];
            $s->trans = $v['trans'];
            $s->save();
        }
        //单词匹配例句
        $allwords = Word::get();
        $allwords->map(function(Word $word){
           $sents = Sent::where('orig','like',"%{$word->word}%")->get();
           $sentIds = [];
           $sents->map(function(Sent $sent)use(&$sentIds,$word){
               $sentWords = $this->parseWords($sent->orig);
               if(in_array($word->word,$sentWords)){
                   $sentIds[] = $sent->id;
               }
           });
           if($sentIds>10){
               $sentIds = array_slice($sentIds,0,10);
           }
            $word->sent = $sentIds;
            $word->save();

        });
        // dump(count($s),count($ss));
    }



    public function parseWords($sent)
    {
        $words = explode(" ", $sent);
        $rs = [];
        foreach ($words as $word){
            $word = trim($word,'-.s,!()\/“”\'‘’"?%;:[]£°$');
            if(!preg_match('/[a-zA-Z]+/',$word)||empty($word)|| in_array($word,$rs)){
                continue;
            }
            $rs[] = $word;
        }
        return $rs;
    }

    public function uniqueMerge($uniqueAr, $words2)
    {
        foreach ($words2 as $word){
            if(empty($word)|| in_array($word,$uniqueAr)){
                continue;
            }
            $uniqueAr[] = $word;
        }
        return $uniqueAr;
    }

    public function getSentByFile($file)
    {
        $s = file_get_contents($file);
        $lines = explode("\n", $s);
        // dd($this->isEnglish(' I\'ve made a mistake.'));
        $rs = [];
        $en = 0;
        $cn = 0;
        foreach ($lines as $line){
            if($this->isEnglish($line)){
                $rs[] = ['en',$line];
                $en++;
            }else if($this->isChinese($line)){
                $rs[] = ['cn',$line];
                $cn++;
            }
        }


        foreach ($rs as $k=>$v){
            try{
                if($k%2==0 && $v[0] != 'en'){
                    throw new \Exception('not en:'.$v[1]);
                }
                if($k%2==1 && $v[0] != 'cn'){
                    throw new \Exception('not cn:'.$v[1]);
                }
            }catch (\Exception $e){
                throw new \Exception('not en:'.$v[1]);
            }

        }
        $sents = [];
        for($i=0;$i<count($rs);$i++){
            $sents[] = ['orig'=>$rs[$i][1],'trans'=>$rs[$i+1][1]];
            $i++;
        }
        return $sents;
    }
    public function isEnglish($str)
    {
        if(empty(trim($str))){
            return false;
        }
        return preg_match('/^[a-zA-Z0-9\-\.\s,! \(\)\/\“\”\'‘’\"\?\%\;\:\[\]\£°\$，——、]+$/',$str);
    }

    public function isChinese($str)
    {
        if(empty(trim($str))){
            return false;
        }
        return !$this->isEnglish($str);
    }
}
