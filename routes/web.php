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

    $router->post('/', 'MapController@InsertMap');

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

$router->group(['prefix' => 'PlayerTiming', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'PlayerTimingController@Index');

    $router->get('/TimingId/{TimingId}', 'PlayerTimingController@GetByTimingId');
    $router->get('/MapId/{MapId}', 'PlayerTimingController@GetByMapId');
    $router->get('/PlayerId/{PlayerId}', 'PlayerTimingController@GetByPlayerId');
    $router->get('/StyleId/{StyleId}', 'PlayerTimingController@GetByStyleId');

    $router->get('/MapId/{MapId}/PlayerId/{PlayerId}', 'PlayerTimingController@GetByMapPlayerId');
    $router->get('/MapId/{MapId}/StyleId/{StyleId}', 'PlayerTimingController@GetByMapStyleId');
    $router->get('/PlayerId/{PlayerId}/StyleId/{StyleId}', 'PlayerTimingController@GetByPlayerStyleId');

    $router->get('/MapId/{MapId}/PlayerId/{PlayerId}/StyleId/{StyleId}', 'PlayerTimingController@GetByAll');

    $router->post('/', 'PlayerTimingController@InsertPlayerTiming');
    
    $router->delete('/TimingId/{TimingId}', 'PlayerTimingController@DeleteByTimingId');
    $router->delete('/MapId/{MapId}', 'PlayerTimingController@DeleteByMapId');
    $router->delete('/PlayerId/{PlayerId}', 'PlayerTimingController@DeleteByPlayerId');
    $router->delete('/StyleId/{StyleId}', 'PlayerTimingController@DeleteByStyleId');

    $router->delete('/MapId/{MapId}/PlayerId/{PlayerId}', 'PlayerTimingController@DeleteByMapPlayerId');
    $router->delete('/MapId/{MapId}/StyleId/{StyleId}', 'PlayerTimingController@DeleteByMapStyleId');
    $router->delete('/PlayerId/{PlayerId}/StyleId/{StyleId}', 'PlayerTimingController@DeleteByPlayerStyleId');

    $router->delete('/MapId/{MapId}/PlayerId/{PlayerId}/StyleId/{StyleId}', 'PlayerTimingController@DeleteByAll');
});

$router->group(['prefix' => 'PlayerTimingInsight', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/TimingId/{TimingId}', 'PlayerTimingInsightController@GetInsight');

    $router->post('/', 'PlayerTimingInsightController@InsertInsight');

    $router->delete('/InsightId/{InsightId}', 'PlayerTimingInsightController@DeleteInsightByInsightId');
    $router->delete('/TimingId/{TimingId}', 'PlayerTimingInsightController@DeleteInsightByTimingId');
});

$router->group(['prefix' => 'PlayerSettings', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/PlayerId/{PlayerId}/Setting/{SettingName}', 'PlayerSettingsController@GetValue');

    $router->get('/PlayerId/{PlayerId}', 'PlayerSettingsController@GetValueByPlayerId');
    $router->get('/Setting/{SettingName}', 'PlayerSettingsController@GetValueBySettingName');

    $router->post('/', 'PlayerSettingsController@InsertSetting');

    $router->delete('/PlayerId/{PlayerId}', 'PlayerSettingsController@DeleteSettingsByPlayerId');
    $router->delete('/Setting/{SettingName}', 'PlayerSettingsController@DeleteSettingsBySettingName');
    $router->delete('/PlayerId/{PlayerId}/Setting/{SettingName}', 'PlayerSettingsController@DeleteSettingsByIdAndName');
});

$router->group(['prefix' => 'PlayerHudSettings', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/PlayerId/{PlayerId}', 'PlayerHudSettingsController@GetHudSettings');

    $router->post('/', 'PlayerHudSettingsController@InsertHudSetting');
    $router->post('/Preset', 'PlayerHudSettingsController@InsertHudPreset');

    $router->patch('/PlayerId/{PlayerId}/Side/{Side}/Line/{Line}', 'PlayerHudSettingsController@UpdateHudSetting');

    $router->delete('/PlayerId/{PlayerId}', 'PlayerHudSettingsController@DeleteHudSettingsByPlayerId');
});
