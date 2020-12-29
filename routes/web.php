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

$router->group(['prefix' => 'Player'], function () use ($router) {
    $router->get('/', 'PlayerController@Index');
    $router->get('/{PlayerId}', 'PlayerController@GetPlayer');

    $router->post('/', 'PlayerController@InsertPlayer');

    $router->put('/{PlayerId}', 'PlayerController@UpdatePlayer');
    
    $router->delete('/{PlayerId}', 'PlayerController@DeletePlayer');
});

$router->group(['prefix' => 'Map'], function () use ($router) {
    $router->get('/', 'MapController@Index');
    $router->get('/{MapId}', 'MapController@GetMap');

    $router->post('/', 'MapController@InsertMap');

    $router->put('/{MapId}', 'MapController@UpdateMap');
    
    $router->delete('/{MapId}', 'MapController@DeleteMap');
});

$router->group(['prefix' => 'Style'], function () use ($router) {
    $router->get('/', 'StyleController@Index');
    $router->get('/{StyleName}', 'StyleController@GetStyle');

    $router->post('/', 'StyleController@InsertStyle');

    $router->put('/{StyleId}', 'StyleController@UpdateStyle');
    
    $router->delete('/{StyleId}', 'StyleController@DeleteStyle');
});
