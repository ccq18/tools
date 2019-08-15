 ## sso安装
 重命名 .env.example 为.env
 配置 .env 文件
 ## 
 
 composer require tymon/jwt-auth 1.0.0-rc.4.1 
 
 
 ```
 'providers' => [
 
     ...
 
     Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
 ]
 ```
 
 ```
 php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

 ```
 
 ```
 php artisan jwt:secret

```


##  get /api/login-url 获取登录页面

    params:
    ```
    {"url":""}
    ```
    
    resonse:
    ```
    url
```
## post /api/login ticket登录

    params:
    ```json
    {"ticket":""}
    ```
    resonse:
    ```
    {
        "access_token":"",
        "token_type":"",
        "expires_in":""
    }
    ```
    
## post /api/logout ticket登录

    params:
    ```json
    {"url":"",token}
    ```
    resonse:
    ```
   url
    ```