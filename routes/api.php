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

Route::resource('/users', 'Api\UserController');

//For Logged Users
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::resource('/user_statuses', 'Api\UserStatusController');
    //Route::resource('/users', 'Api\UserController');
    Route::resource('/cities', 'Api\CityController');
    Route::resource('/university-types', 'Api\UniversityTypeController');
    Route::resource('/universities', 'Api\UniversityController');
    Route::resource('/companies', 'Api\CompanyController');
    Route::resource('/company-categories', 'Api\CompanyCategoryController');
    Route::resource('/specializations', 'Api\SpecializationController');
    Route::resource('/students', 'Api\StudentController');
    Route::resource('/user-universities', 'Api\UserUniversityController');
    Route::resource('/user-companies', 'Api\UserCompanyController');
    Route::resource('/offers/categories', 'Api\OfferCategoryController');
    Route::resource('/offers', 'Api\OfferController');
    Route::post('/university/generate-code', 'Api\UniversityController@setNewAccessCode');
    Route::post('/university/use-code', 'Api\UniversityController@useCode');
    Route::post('/company/generate-code', 'Api\CompanyController@setNewAccessCode');
    Route::post('/company/use-code', 'Api\CompanyController@useCode');
    Route::get('/company/{id}/users', 'Api\CompanyController@getUsers');

    Route::get('/me', [
        'as' => 'login.me',
        'uses' => 'Api\Auth\AuthController@me'
    ]);
});

//For not logged in users
Route::get('/universities', 'Api\UniversityController@index');
Route::get('/specializations', 'Api\SpecializationController@index');
Route::get('/university/{id}/faculties', 'Api\UniversityController@universityFaculties');
Route::get('/faculty/{id}/fields', 'Api\FacultyController@facultyFields');
Route::get('/field/{id}/specializations', 'Api\FieldController@fieldSpecializations');
Route::post('/students', 'Api\StudentController@store');
