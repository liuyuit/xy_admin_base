<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "admin" middleware group. Enjoy building your API!
|
*/

/* @var \Dingo\Api\Routing\Router $api */
$api = app('Dingo\Api\Routing\Router');

$globalParams = [
    'domain' => config('app.admin_url'),
    'namespace' => 'App\\Http\\Controllers\\Admin',
    'version' => 'v1',
];

$api->group($globalParams, function () use ($api) {

    $api->group(['middleware' => 'web'], function () use ($api) {
        $api->get('', 'LaravueController@index')->where('any', '.*')->name('admin.laravue');
    });


});
