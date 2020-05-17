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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Login
Route::post('/login', [
    'as' => 'login.login',
    'uses' => 'Api\Auth\AuthController@login'
]);

Route::post('/logout', [
    'as' => 'login.logout',
    'uses' => 'Api\Auth\AuthController@logout'
]);

Route::get('/refresh', [
    'as' => 'login.refresh',
    'uses' => 'Api\Auth\AuthController@refresh'
]);

Route::post('/users', 'Api\UserController@store');

//For Logged Users
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::resource('/user_statuses', 'Api\UserStatusController');
    //Route::resource('/users', 'Api\UserController');
    Route::resource('/cities', 'Api\CityController');
    Route::resource('/university_types', 'Api\UniversityTypeController');
    Route::resource('/universities', 'Api\UniversityController');
    Route::resource('/companies', 'Api\CompanyController');
    Route::resource('/company_categories', 'Api\CompanyCategoryController');
    Route::resource('/specializations', 'Api\SpecializationController');
    Route::resource('/students', 'Api\StudentController');
    Route::get('/me', [
        'as' => 'login.me',
        'uses' => 'Api\Auth\AuthController@me'
    ]);
});

//Debug
Route::resource('/debug', 'Api\DebugController');
