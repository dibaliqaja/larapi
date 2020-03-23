<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'ApiController@register');
Route::post('login', 'ApiController@login');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('tes', 'ApiController@tesAuth');
    Route::get('user', 'ApiController@getAuthenticatedUser');
    Route::get('logout', 'ApiController@logout');

    // Route API Provinces
    Route::get('/province', 'ApiController@getIndexProvinces');
    Route::post('/province/store', 'ApiController@storeProvinces');
    Route::get('/province/{id?}', 'ApiController@showProvinces');
    Route::post('/province/update/{id?}', 'ApiController@updateProvinces');
    Route::delete('/province/{id?}', 'ApiController@destroyProvinces');

    // Route API City
    Route::get('/city', 'ApiController@getIndexCity');
    Route::post('/city/store', 'ApiController@storeCity');
    Route::get('/city/{id?}', 'ApiController@showCity');
    Route::post('/city/update/{id?}', 'ApiController@updateCity');
    Route::delete('/city/{id?}', 'ApiController@destroyCity');

    // Route API Areas
    Route::get('/area', 'ApiController@getIndexArea');
    Route::post('/area/store', 'ApiController@storeArea');
    Route::get('/area/{id?}', 'ApiController@showAreas');
    Route::post('/area/update/{id?}', 'ApiController@updateArea');
    Route::delete('/area/{id?}', 'ApiController@destroyArea');

});
