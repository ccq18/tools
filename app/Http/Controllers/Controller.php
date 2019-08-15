<?php

namespace App\Http\Controllers;

use Dto\DtoService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($data, $code=200, $message='success')
    {
        return response()->json(['data' => $data,'code'=>$code,'message'=>$message]);

    }



    public function dto($data, $dtoProvider)
    {
        $data = resolve(DtoService::class)->transfer($data, $dtoProvider);
        return $this->response($data);
    }
}
