<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Dto\DtoBuilder;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers\Web
 */
class HomeController extends Controller
{


    public function demodto(){
        return $this->dto(
            ['key1' => ['key3'=>111], 'key2' => ['key3'=>123],],
            function (DtoBuilder $dtoBuilder) {
                $dtoBuilder->add('key1.key3', ['format' => 'string']);
                $dtoBuilder->add('key2.key3', ['format' => 'string','as'=>'key4']);
            }
        );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
