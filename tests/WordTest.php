<?php

namespace Tests;


use App\Model\Lang\Word;
use App\Spl\LinkListHelper;
use Ddc\CoreBundle\Service\Express\SfExpress\XmlHelper;
use Util\Parser;

class WordTest extends TestCase
{
    public function testPush()
    {
        $data = range(1,7000);
        $linkHelper = new LinkListHelper();
        $doubly = $linkHelper->getByPad(count($data) * 10);
        //
        foreach ($data as $k => $id) {
            // $first = $linkHelper->findFirst($doubly,function ($v)use($id){
            //     return $id == $v;
            // });
            $first = $linkHelper->findFirst($doubly, null);
            $linkHelper->addOrReplace($doubly,$first, $id);
            // $doubly->add($index,$v);
            $linkHelper->addOrReplace($doubly,$first + 4, $id);
            $linkHelper->addOrReplace($doubly,$first + 8, $id);
            $linkHelper->addOrReplace($doubly,$first + 16, $id);
            $linkHelper->addOrReplace($doubly,$first + 32, $id);
            $linkHelper->addOrReplace($doubly,$first + 64, $id);
            $linkHelper->addOrReplace($doubly,$first + 256, $id);
        }
        dump($linkHelper->getArrAndNotNull($doubly));

    }


    public function testPush2(){
        $data = range(1,3);
        $linkHelper = new LinkListHelper();
        $doubly = $linkHelper->getByPad(100,$data);
        $doubly->add(1,1);
        $doubly->add(2,2);
        $doubly->add(3,3);
        $this->assertEquals([1, 1, 2,  3,2, 3], $linkHelper->getArrAndNotNull($doubly));
    }


    public function testPushs()
    {
        $a = [1,2,3,4];
        $a = array_merge($a,[1,2,3,4]);
        dump($a);
    }


    public function testDetail()
    {
        $str = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
   <dict num=\"219\" id=\"219\" name=\"219\">
   <key>good</key>
   <ps>gʊd</ps>
   <pron>http://res.iciba.com/resource/amp3/oxford/0/28/a2/28a24294fed307cf7e65361b8da4f6e5.mp3</pron>
   <ps>ɡʊd</ps>
   <pron>http://res.iciba.com/resource/amp3/1/0/75/5f/755f85c2723bb39381c7379a604160d8.mp3</pron>
   <pos>adj.</pos>
   <acceptation>好的；优秀的；有益的；漂亮的，健全的；
   </acceptation>
   <pos>n.</pos>
   <acceptation>好处，利益；善良；善行；好人；
   </acceptation>
   <pos>adv.</pos>
   <acceptation>同well；
   </acceptation>
   <sent><orig>
   Best is the superlative form of good and worst is the superlative form of bad.
   </orig>
   <trans>
   “best”是“good”的最高级形式,“worst” 是“bad”的最高级形式.
   </trans></sent>
   <sent><orig>
   Good has captured the essence of the runaway, but does not pursue its most disturbing consequences.
   </orig>
   <trans>
   Good抓住了这场失控的本质, 但没有进一步追踪这个事件最让人担忧的后果.
   </trans></sent>
   <sent><orig>
   The state of the stream is revealed by the bad, fail, eof, and good operations.
   </orig>
   <trans>
   流的状态由bad 、 fail 、 eof 和good操作提示.
   </trans></sent>
   <sent><orig>
   Good Christian, good parent, good child, good wife, good husband.
   </orig>
   <trans>
   虔诚的基督徒, 慈爱的父母, 孝顺的儿女, 贤良的妻子, 尽职的丈夫.
   </trans></sent>
   <sent><orig>
   Good habits nurture good characters; good characters mold good fates.
   </orig>
   <trans>
   好习惯育成好品格, 好品格塑造好命运.
   </trans></sent>
   </dict>";
        $goods = str_translate('goods');
        dump($goods);
        print_r( xml_to_array($str));

    }

    public function testVerifyFile()
    {
        $s = file_get_contents(resource_path('/data/8.txt'));

        $lines = explode("\n", $s);
        // dd($this->isEnglish('Victory won\'t come to me unless I go to it.'));
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
            if($k%2==0 && $v[0] != 'en'){
                dd($k%2==0 ,$k,'not en',$v);
            }
            if($k%2==1 && $v[0] != 'cn'){
                dd($k%2==1,$k,'not cn',$v);
            }
        }
        $this->assertEquals($en,$cn);
    }

    public function testParse()
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
        $words = [];
        $wn = 0;
        $ss = [];
        foreach ($s as $k=>$v){
            $ss[$v['orig'][1]] = $v;
            try{
                $nws = $this->parseWords($v['orig'][1]);
                $wn+=count($nws);
                $words = $this->uniqueMerge($words,$nws);
            }catch (\Exception $e){
                dd($v,$k);
            }

        }
        dump(count($s),count($ss),count($words));
        $allwords = Word::get()->pluck('word');
        dump($allwords->count());
        dump(count($allwords->intersect($words)));

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
            if($k%2==0 && $v[0] != 'en'){
                throw new \Exception('not en:'.$v);
            }
            if($k%2==1 && $v[0] != 'cn'){
                throw new \Exception('not cn:'.$v);
            }
        }
        $sents = [];
        for($i=0;$i<count($rs);$i++){
            $sents[] = ['orig'=>$rs[$i],'trans'=>$rs[$i+1]];
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