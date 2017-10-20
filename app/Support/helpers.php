<?php

if (!function_exists('user')) {
    /**
     * @param null $driver
     * @return \App\Model\User
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
if (!function_exists('generate_path')) {

    function generate_path($base, $path)
    {
       return rtrim($base,'\/').'/'.ltrim($path,'\/');
    }

}
