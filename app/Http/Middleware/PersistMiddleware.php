<?php

namespace App\Http\Middleware;




use Closure;
use GuzzleHttp\Middleware;
use Util\Persist\Persist;

class PersistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Http\Exceptions\PostTooLargeException
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        Persist::saveAll();
    }
}