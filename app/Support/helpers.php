<?php

if (!function_exists('user')) {
    /**
     * @param null $driver
     * @return App\User
     */
    function user($driver = null)
    {
        if ($driver) {
            return app('auth')->guard($driver)->user();
        }

        return app('auth')->user();
    }
}

if (!function_exists('flash')) {

    function flash($title, $message)
    {
        session()->flash('flash_message', [
            // 'type'    => $type,
            'title'   => $title,
            'message' => $message
        ]);
    }

}