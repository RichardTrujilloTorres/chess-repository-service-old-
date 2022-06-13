<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group([
//    'middleware' => '',
    'prefix' => 'users',
], function () use($router) {
    $router->post('', 'User\RegisterController@__invoke');
});

$router->group([
//    'middleware' => '',
    'prefix' => 'games',
], function () use($router) {
    $router->get('{id:[0-9]+}', 'Game\ShowController@__invoke');
    $router->get('{id:[0-9]+}/download', 'Game\DownloadController@__invoke');
    $router->post('', 'Game\StoreController@__invoke');
});

$router->group([
//    'middleware' => '',
    'prefix' => 'analysis',
], function () use($router) {
    $router->post('{id:[0-9]+}', 'Analysis\AppendController@__invoke');
});
