<?php

use Illuminate\Support\Facades\Route;

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

//Auth routing
Route::post('/auth/login', 'Auth\LoginController@authenticate');
Route::post('/auth/logout', 'Auth\LoginController@logout');

//Vue routing
Route::get('/{any}', 'SinglePageController@index')->where('any', '.*');
