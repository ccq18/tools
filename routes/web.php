<?php
use App\Console\Commands\JdListener;

Route::get('/logout', function (){
    auth('sso')->logout();
    return redirect(resolve(Ido\Tools\SsoAuth\AuthHelper::class)->getLogoutUrl(build_url('/')));
});

Route::group(['namespace' => 'Web',], function () {
    // Route::get('/', 'QuestionsController@index');
    Route::get('/', 'WordController@search');
    Route::get('/jdact', function () {
        $infos = resolve(JdListener::class)->getCoupon(197751398);
        return $infos;
    });

    Route::get('/api/ip', function () {
        return $_SERVER;
    });
    Route::get('/dto', 'HomeController@demodto');


    Route::get('/home', 'HomeController@index')->middleware('auth');
    Route::get('email/verify/{token}', ['as' => 'email.verify', 'uses' => 'EmailController@verify']);
    Route::resource('questions', 'QuestionsController', [
        'names' => [
            'create' => 'question.create',
            'show'   => 'question.show',
        ]
    ]);
    Route::post('questions/{question}/answer', 'AnswersController@store');
    Route::get('question/{question}/follow', 'QuestionFollowController@follow');

    Route::get('notifications', 'NotificationsController@index');
    Route::get('notifications/{notification}', 'NotificationsController@show');


    Route::get('avatar', 'UsersController@avatar');
    Route::post('avatar', 'UsersController@changeAvatar');

    Route::get('password', 'PasswordController@password');
    Route::post('password/update', 'PasswordController@update');

    Route::get('setting', 'SettingController@index');
    Route::post('setting', 'SettingController@store');
    // Route::group(['middleware' => ['ssoauth']], function () {
    Route::group(['middleware' => ['ssoauth']], function () {
        //单词
        Route::get('words/config', 'WordController@config');
        Route::post('words/config', 'WordController@config');
        //单词查询
        Route::get('words/search-word', 'WordController@searchWord');
        //单词搜索
        Route::get('words/search', 'WordController@search');
        Route::get('words/{id}', 'WordController@getWord')->where('id', '[0-9]+');
        // Route::get('words/{id}', 'WordController@getWord')->where('id', '[0-9]+');;

        Route::get('words/index', 'WordController@index');
        Route::get('words', 'WordController@listWord');
        Route::get('words/read-word', 'WordController@readWord');
        Route::get('words/ant', 'WordController@ant');

        Route::get('words/index', 'WordController@index');
        Route::get('words', 'WordController@listWord');
        Route::get('words/read-word', 'WordController@readWord');
        Route::get('words/read-list', 'WordController@readWordLists');
        Route::get('words/read-list/{listId}', 'WordController@readWordGroups');
        Route::get('words/read-list/{listId}/{groupId}', 'WordController@readWordGroupList');
        Route::any('words/add-collect', 'WordController@addCollect');
        Route::get('words/collects', 'WordController@collectList');
        Route::get('words/learned-list', 'WordController@getLearnedList');


        Route::get('inbox', 'InboxController@index');
        Route::get('inbox/{dialogId}', 'InboxController@show');
        Route::post('inbox/{dialogId}/store', 'InboxController@store');
        Route::get('url/index', 'UrlController@index');
        Route::get('url/list', 'UrlController@listUrl');
        Route::post('url/add', 'UrlController@add');

        Route::group(['prefix' => 'account'], function () {
            Route::get('/index', 'AccountController@index');
            Route::post('/recharge', 'AccountController@recharge');
            Route::post('/transfer', 'AccountController@transfer');


        });
    });
    Route::any('u/{code}', 'UrlController@redirect');
    Route::any('graphql', 'GraphqlController@run');

});
