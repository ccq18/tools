<?php

namespace App\Pagination;


use Illuminate\Pagination\UrlWindow;

class LengthAwarePaginator extends \Illuminate\Pagination\LengthAwarePaginator
{
    protected $urlWindowClass = SimplePage::class;

    public function setUrlWindow($urlWindowClass = SimplePage::class)
    {
        $this->urlWindowClass = $urlWindowClass;

        return $this;
    }

    public function url($page)
    {
        return build_url(request()->getRequestUri(),['page'=>$page]);
    }

    /**
     * Get the array of elements to pass to the view.
     *
     * @return array
     */
    protected function elements()
    {
        $window = call_user_func([$this->urlWindowClass, 'make'], $this);

        return array_filter([
            $window['first'],
            // is_array($window['slider']) ? '...' : null,
            $window['slider'],
            // is_array($window['last']) ? '...' : null,
            $window['last'],
        ]);
    }

}