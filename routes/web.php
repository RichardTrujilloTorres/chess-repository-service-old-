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
    'prefix' => 'auth',
], function () use($router) {
    $router->post('login', 'User\LoginController@__invoke');
    $router->post('', 'User\RegisterController@__invoke');

    $router->group(['middleware' => ['auth']], function () use($router) {
        $router->get('refresh', 'User\TokenRefreshController@__invoke');
        $router->get('user', 'User\UserController@__invoke');
        $router->put('user', 'User\UserUpdateController@__invoke');
        $router->post('logout', 'User\LogoutController@__invoke');
    });
});

$router->group([
    'middleware' => ['auth'],
    'prefix' => 'users',
], function () use($router) {
    $router->put('', 'User\UserUpdateController@__invoke');
});

$router->group([
    'middleware' => ['auth'],
    'prefix' => 'games',
], function () use($router) {
    $router->get('', 'Game\IndexController@__invoke');
    $router->get('{id:[0-9]+}', 'Game\ShowController@__invoke');
    $router->get('{id:[0-9]+}/download', 'Game\DownloadController@__invoke');
    $router->post('', 'Game\StoreController@__invoke');
});

$router->group([
    'middleware' => ['auth'],
    'prefix' => 'analysis',
], function () use($router) {
    $router->post('{id:[0-9]+}', 'Analysis\AppendController@__invoke');
});
