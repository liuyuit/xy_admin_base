<?php

/**@var \Dingo\Api\Routing\Router $api */
$api = app('Dingo\Api\Routing\Router');

$globalParams = [
    'domain' => config('app.api_url'),
    'namespace' => 'App\\Http\\Controllers\\Api\\V1',
    'version' => 'v1',
    'middleware' => 'api',
    'as' => 'api',
];

$api->group($globalParams, function () use ($api) {

    $api->group(['prefix' => 'user', 'namespace' => 'User', 'as' => 'user'], function () use ($api){
        $api->any('login', 'LoginController@index')->name('.login');
        $api->any('refresh-token', 'RefreshTokenController@index')->name('.refresh-token');
        $api->any('me', 'MeController@index')->name('.me');
        $api->any('me/update', 'MeController@update')->name('.me.update');
        $api->any('user', 'UserController@index')->name('.user');
    });


    $api->group(['prefix' => 'test', 'namespace' => 'Test'], function() use ($api) {
        $api->any('test', ['as' => 'api.test.test', 'uses' => 'TestController@index']);
        $api->any('authorize', ['as' => 'api.test.authorize', 'uses' => 'AuthorizeController@index']);
        $api->any('route', ['as' => 'api.test.route', 'uses' => 'RouteController@index']);
        $api->any('response', ['as' => 'api.test.response', 'uses' => 'ResponseController@index']);
        $api->any('exception', ['as' => 'api.test.exception', 'uses' => 'ExceptionController@index']);
        $api->any('cache', ['as' => 'api.test.cache', 'uses' => 'CacheController@index']);
        $api->any('swagger', ['as' => 'api.test.swagger', 'uses' => 'SwaggerController@index']);
        $api->any('swagger', ['as' => 'api.test.swagger', 'uses' => 'SwaggerController@index']);
        $api->any('exception-handle', ['as' => 'api.test.exception-handle', 'uses' => 'ExceptionHandleController@index']);
        $api->any('bit-operator', ['as' => 'api.test.bit-operator', 'uses' => 'BitOperatorController@index']);
        $api->any('validator', ['as' => 'api.test.validator', 'uses' => 'ValidatorController@index']);
        $api->any('transaction', ['as' => 'api.test.transaction', 'uses' => 'TransactionController@index']);
    });
});
