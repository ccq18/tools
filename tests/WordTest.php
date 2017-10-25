<?php

namespace Tests;


use App\Spl\LinkListHelper;

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
}