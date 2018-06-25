<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Model\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function index()
    {
        return view('urls.index');

        // return $this->view('urls.index');

    }

    public function listUrl()
    {
        $urls = Url::whereUid(auth()->id())->get();

        return $this->view('list_urls', ['urls' => $urls]);

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {

        if (!empty($request->get('code'))) {
            $url = Url::whereCode($request->input('code'))->first();
            if (!empty($url) && auth()->id() != $url->uid) {
                return $this->response(null, 401, '网址已存在');
            }

        }
        if (empty($url)) {
            $url = new  Url();
            $url->uid = auth()->id();
        }

        $url->data = trim($request->input('data'));
        $url->code = $request->input('code') ? trim($request->get('code')) : uniqid();
        $url->type = $request->input('type');
        $url->save();
        $url->short_url = $url->shortUrl();

        return $this->response($url);
    }


    public function redirect($code)
    {

        $url = Url::whereCode($code)->firstOrFail();
        if ($url->type == Url::TYPE_REDIRECT) {
            return redirect($url->data);
        } elseif ($url->type == Url::TYPE_SHOW) {
            return $url->data;
        }

    }

}