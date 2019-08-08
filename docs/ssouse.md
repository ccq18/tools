## 1.注册中间件
SsoAuthenticate.php 登录认证的页面使用
SsoAuthToken.php 自动认证token
## 2.注册 auth
AuthServiceProvider
Auth::provider('sso_authorization', function () {
            return new SsoUserProvider();
        });
auth.php
```
 'defaults' => [
        'guard' => 'sso',
        'passwords' => 'users',
    ],

    'guards' => [
        'sso' => [
            'driver' => 'session',
            'provider' => 'sso_authorized_users',
        ],
    ],

    'providers' => [

        'sso_authorized_users' => [
            'driver' => 'sso_authorization',
        ],

    ],
    
```

3.跳转地址

```
function login_url(){
    return resolve(SsoAuth\AuthHelper::class)->getLoginUrl();
}

function logout_url(){
    return url('/logout');
}
function register_url(){
    return resolve(SsoAuth\AuthHelper::class)->getRegisterUrl();
}
```
route.php
```
Route::get('/logout', function (){
    auth('sso')->logout();
    return redirect(resolve(SsoAuth\AuthHelper::class)->getLogoutUrl(build_url('/')));
});
```