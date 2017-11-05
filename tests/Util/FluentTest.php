<?php

namespace Tests\Util;

use Tests\TestCase;
use Util\Fluent;

class FluentTest extends TestCase
{


    public function testMerge()
    {
        $d = new DemoFluent();
        $d[]=1;

        $this->assertEquals(1, count($d));
        $this->assertFalse(empty($d));


    }

    public function testAdd()
    {
        $d = new DemoFluent();
        $this->assertEquals([], $d->toArray());

        $d[] = 0;
        $d[1] = 1;
        $d['2'] = 2;
        $d['three'] = 3;

        $this->assertEquals([0, 1, 2, 'three' => 3], $d->toArray());

    }

    public function testMul()
    {
        $d = new DemoFluent();
        $d['a'] = [1, 2, 3];
        $d['b'] = [];//import
        $d['b']['c'] = [1, 2, 3];
        $d['b']['d'] = [4, 5, 6];
        $this->assertEquals([1, 2, 3], $d['a']);
        $this->assertEquals([1, 2, 3], $d['b']['c']);
        $this->assertEquals(['c' => [1, 2, 3], 'd' => [4, 5, 6]], $d['b']);


    }
}

class DemoFluent extends Fluent
{

}