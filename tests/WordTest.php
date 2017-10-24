<?php

namespace Tests;


use App\Spl\LinkListHelper;

class WordTest extends TestCase
{
    public function testPush()
    {
        $data = range(1,10);
        $linkHelper = new LinkListHelper();
        $doubly = $linkHelper->getByPad(count($data)*4,$data);
        foreach ($data as $k=> $id){
            $doubly->add($k+4,$id);
            $doubly->add($k+8,$id);
            $doubly->add($k+16,$id);
            dump($linkHelper->getArrAndNotNull($doubly));
            // $doubly->add($k+16,$id);
            // $doubly->add($k+1024,$id);

        }
        dump($linkHelper->getArrAndNotNull($doubly));
        dump(strlen(json_encode($linkHelper->getArrAndNotNull($doubly))));
        // $this->assertEquals([1, 1, 2,  3,2, 3], );

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
}