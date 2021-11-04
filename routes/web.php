<?php

/**
 * @var \Laravel\Lumen\Routing\Router $router
 */

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

$router->group(['prefix' => 'Player', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'PlayerController@Index');
    $router->get('/Id/{PlayerId}', 'PlayerController@GetPlayer');

    $router->post('/', 'PlayerController@InsertPlayer');

    $router->put('/Id/{PlayerId}', 'PlayerController@UpdatePlayer');
    
    $router->delete('/Id/{PlayerId}', 'PlayerController@DeletePlayer');
});

$router->group(['prefix' => 'Map', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'MapController@Index');
    $router->get('/Id/{MapId}', 'MapController@GetMapById');
    $router->get('/Name/{MapName}', 'MapController@GetMapByName');
    $router->get('/MatchName/{MapName}', 'MapController@GetMapsByName');

    $router->post('/', 'MapController@InsertMaps');

    $router->put('/Id/{MapId}', 'MapController@UpdateMap');
    
    $router->delete('/Id/{MapId}', 'MapController@DeleteMap');
});

$router->group(['prefix' => 'Style', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'StyleController@Index');
    $router->get('/Id/{StyleId}', 'StyleController@GetStyleById');
    $router->get('/Name/{StyleName}', 'StyleController@GetStyleByName');

    $router->post('/', 'StyleController@InsertStyle');

    $router->put('/Id/{StyleId}', 'StyleController@UpdateStyle');
    
    $router->delete('/Id/{StyleId}', 'StyleController@DeleteStyle');
});

$router->group(['prefix' => 'PlayerSettings', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/PlayerId/{PlayerId}/Setting/{SettingName}', 'PlayerSettingsController@GetValue');

    $router->get('/PlayerId/{PlayerId}', 'PlayerSettingsController@GetValueByPlayerId');
    $router->get('/Setting/{SettingName}', 'PlayerSettingsController@GetValueBySettingName');

    $router->post('/', 'PlayerSettingsController@InsertSetting');

    $router->patch('/PlayerId/{PlayerId}/Setting/{SettingName}', 'PlayerSettingsController@UpdateSetting');

    $router->delete('/PlayerId/{PlayerId}', 'PlayerSettingsController@DeleteSettingsByPlayerId');
    $router->delete('/Setting/{SettingName}', 'PlayerSettingsController@DeleteSettingsBySettingName');
    $router->delete('/PlayerId/{PlayerId}/Setting/{SettingName}', 'PlayerSettingsController@DeleteSettingsByIdAndName');
});

$router->group(['prefix' => 'PlayerHud', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/PlayerId/{PlayerId}', 'PlayerHudController@GetHud');

    $router->post('/PlayerId/{PlayerId}', 'PlayerHudController@InsertHud');

    $router->patch('/PlayerId/{PlayerId}', 'PlayerHudController@UpdateHud');

    $router->delete('/PlayerId/{PlayerId}', 'PlayerHudController@DeleteHudByPlayerId');
    $router->delete('/PlayerId/{PlayerId}/Key/{Key}', 'PlayerHudController@DeleteHudByPlayerIdAndKey');
});

$router->group(['prefix' => 'Records', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/MapId/{MapId}', 'RecordsController@GetMapRecord');
    $router->get('Count/MapId/{MapId}', 'RecordsController@GetMapRecordsCount');
    $router->get('AvgTime/MapId/{MapId}', 'RecordsController@GetMapRecordsAvgTime');

    $router->get('/MapId/{MapId}/PlayerId/{PlayerId}', 'RecordsController@GetMapPlayerRecord');

    $router->post('/', 'RecordsController@InsertRecord');

    $router->put('/', 'RecordsController@UpdateRecord');

    $router->delete('/PlayerTimingId/{PlayerTimingId}', 'RecordsController@DeleteRecord');
    // TODO: Delete all records by Map, Player, Style?
});

$router->group(['prefix' => 'Location', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/MapId/{MapId}/PlayerId/{PlayerId}', 'LocationController@GetPlayerLocations');
    $router->post('/', 'LocationController@InsertLocation');
    $router->put('/LocationId/{LocationId}', 'LocationController@UpdateLocation');
    $router->delete('/LocationId/{LocationId}', 'LocationController@DeleteLocation');
});
