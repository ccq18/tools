<?php

namespace SsoAuth\Middleware;


use Closure;

class SsoAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        auth()->shouldUse('sso');
        /** @var \Illuminate\Auth\SessionGuard $guard */
        $guard = auth()->guard();
        //认证失败 跳转到登录页
        if (!$guard->check()) {
            //token认证流程
            $token = request('token');
            if(!empty($token)){
                $url = rtrim($request->fullUrlWithQuery(['token' => null]), '?');
                $isAuth  = $guard->attempt(['token' => $request->get('token')]);
                if ($isAuth) {
                    return redirect($url);
                }
            }
        }

        return $next($request);
    }
}