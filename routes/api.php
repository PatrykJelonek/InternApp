<?php

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

//Login
Route::post('/login', [
    'as' => 'login.login',
    'uses' => 'Api\Auth\AuthController@login'
]);

Route::get('/debug-sentry', function () {
    throw new \RuntimeException('My first Sentry error!');
});

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
    Route::resource('/agreements', 'Api\AgreementController');
    Route::resource('/internships', 'Api\InternshipController');
    Route::resource('/journals', 'Api\JournalController');
    Route::post('/university/generate-code', 'Api\UniversityController@setNewAccessCode');
    Route::post('/university/use-code', 'Api\UniversityController@useCode');
    Route::post('/company/generate-code', 'Api\CompanyController@setNewAccessCode');
    Route::post('/company/use-code', 'Api\CompanyController@useCode');
    Route::post('/journals/confirmMany', 'Api\JournalController@confirmMany');
    Route::get('/company/{id}/users', 'Api\CompanyController@getUsers');
    Route::get('/universities/{id}/users', 'Api\UniversityController@getUsers');
    Route::get('/universities/{id}/agreements', 'Api\UniversityController@getUniversityAgreements');
    Route::get('/universities/{id}/internships', 'Api\UniversityController@getInternships');
    Route::get('/universities/{university_id}/students', 'Api\UniversityStudentController@index');
    Route::get('/companies/{id}/offers', 'Api\CompanyController@getCompanyOffers');
    Route::get('/companies/{id}/agreements', 'Api\CompanyController@getCompanyAgreements');
    Route::get('/companies/{id}/interns', 'Api\CompanyController@getInterns');
    Route::post('/agreements/{id}/active', 'Api\AgreementController@active');
    Route::get('/internships/{id}/confirm', 'Api\InternshipController@confirm');
    Route::get('/user/internships', 'Api\UserController@getInternships');
    Route::get('/user/journals', 'Api\UserController@getJournals');
    Route::get('/user/interns', 'Api\UserController@getInterns');
    Route::get('/users/{user_id}/internships/{internship_id}/tasks', 'Api\TaskController@index');
    Route::get('/users/{user_id}/internships/{internship_id}/journal_entries', '');

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
