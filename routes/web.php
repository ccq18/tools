<?php
// Auth::routes();
use App\Console\Commands\JdListener;

Route::group(['namespace' => 'Web',], function () {
    // Route::get('/', 'QuestionsController@index');
    Route::get('/', 'WordController@search');
    Route::get('/jdact', function () {
        $url = "https://so.m.jd.com/list/itemSearch.action?ptag=37287.6.5&promotion_aggregation=yes&activityId=50004594574&skuId=36700607795&pro_d=%E8%B7%A8%E8%87%AA%E8%90%A5%2F%E5%BA%97%E9%93%BA%E6%BB%A1%E5%87%8F&pro_s=%E6%BB%A1299%E5%85%83%E5%87%8F100%E5%85%83";
        $infos = resolve(JdListener::class)->getList($url);

        return $infos;
    });
    Route::get('/api/aa', function () {
        return 'helloapi';
    });

    Route::get('/home', 'HomeController@index');
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
    Route::group(['middleware' => ['auth']], function () {
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
