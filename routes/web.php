<?php

use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'UserController');
    Route::resource('province', 'ProvincesController');
    Route::resource('city', 'CityController');
    Route::resource('area', 'AreaController');
    Route::get('/logs', function () {
        return Activity::orderBy('updated_at', 'DESC')->get();
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
