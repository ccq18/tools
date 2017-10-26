<?php
Auth::routes();
Route::group(['namespace' => 'Web',], function () {
    Route::get('/', 'QuestionsController@index');
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

        Route::get('words/index', 'WordController@index');
        Route::get('words', 'WordController@listWord');
        Route::get('words/read-word', 'WordController@readWord');

        Route::get('words/index', 'WordController@index');
        Route::get('words', 'WordController@listWord');
        Route::get('words/read-word', 'WordController@readWord');
        Route::get('words/read-list', 'WordController@readWordLists');
        Route::get('words/read-list/{listId}', 'WordController@readWordGroups');
        Route::get('words/read-list/{listId}/{groupId}', 'WordController@readWordGroupList');
        Route::any('words/add-collect', 'WordController@addCollect');
        Route::get('words/collects', 'WordController@collectList');

        Route::get('inbox', 'InboxController@index');
        Route::get('inbox/{dialogId}', 'InboxController@show');
        Route::post('inbox/{dialogId}/store', 'InboxController@store');

        Route::group(['prefix' => 'account'], function () {
            Route::get('/index', 'AccountController@index');
            Route::post('/recharge', 'AccountController@recharge');
            Route::post('/transfer', 'AccountController@transfer');


        });
    });
});
