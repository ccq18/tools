<?php

namespace App\Http\Controllers\Api;


use App\Model\User;
use Ido\Tools\SsoAuth\AuthHelper;

class AuthController
{


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $ticket = request('ticket');
        if (!$token = auth('api')->attempt(['ticket'=>$ticket])) {
            return json_response(['error' => 'Unauthorized']);
        }

        return json_response($this->respondWithToken($token));
    }

    public function getLoginUrl()
    {
        $fromUrl = request('url');
        $loginUrl = resolve(\Ido\Tools\SsoAuth\AuthHelper::class)->getLoginUrl($fromUrl);

        return json_response($loginUrl);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        $fromUrl = request('url');
        return json_response(resolve(\Ido\Tools\SsoAuth\AuthHelper::class)->getLogoutUrl($fromUrl), 'Successfully logged out');
    }

    /**
     * Refresh a token.
     * 刷新token，如果开启黑名单，以前的token便会失效。
     * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return json_response($this->respondWithToken(auth('api')->refresh()));
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ];
    }
}