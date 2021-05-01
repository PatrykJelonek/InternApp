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

Route::get('/helpers/offers', 'Api\LandingPageController@offers');

Route::resource('/users', 'Api\UserController');

//For Logged Users
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::resource('/user_statuses', 'Api\UserStatusController');
    //Route::resource('/users', 'Api\UserController');
//    Route::resource('/cities', 'Api\CityController');
    Route::resource('/university-types', 'Api\UniversityTypeController');
    Route::resource('/universities', 'Api\UniversityController');
    //Route::resource('/companies', 'Api\CompanyController');
    Route::resource('/specializations', 'Api\SpecializationController');
    Route::resource('/students', 'Api\StudentController');
    Route::resource('/user-universities', 'Api\UserUniversityController');
    Route::resource('/user-companies', 'Api\UserCompanyController');
    Route::resource('/offers/categories', 'Api\OfferCategoryController');
//    Route::resource('/offers', 'Api\OfferController');
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
    //Route::get('/universities/{id}/agreements', 'Api\UniversityController@getUniversityAgreements');
    //Route::get('/universities/{id}/internships', 'Api\UniversityController@getInternships');
    //Route::get('/universities/{university_id}/students', 'Api\UniversityStudentController@index');
    //Route::get('/companies/{id}/offers', 'Api\CompanyController@getCompanyOffers');
    Route::get('/companies/{id}/agreements', 'Api\CompanyController@getCompanyAgreements');
    Route::get('/companies/{id}/interns', 'Api\CompanyController@getInterns');
    Route::post('/agreements/{id}/active', 'Api\AgreementController@active');
    Route::get('/internships/{id}/confirm', 'Api\InternshipController@confirm');
    Route::get('/user/internships', 'Api\UserController@getInternships');
    Route::get('/user/journals', 'Api\UserController@getJournals');
    Route::get('/user/interns', 'Api\UserController@getInterns');
    Route::get('/internships/{internship}/tasks', 'Api\TaskController@index');

    //NEW ENDPOINTS
    //Route::get('/internships','Api\InternshipController@index');
    Route::get('/internships/{internship}','Api\InternshipController@show');
    Route::get('/internships/{internship}/students','Api\InternshipStudentController@index');
    Route::get('/internships/{internship}/students/{student}/journal-entries', 'Api\StudentJournalEntryController@index');
    Route::post('/internships/{internship}/students/{student}/journal-entries', 'Api\StudentJournalEntryController@store');
    Route::get('/internships/{internship}/students/{student}/journal-entries/{journalEntry}','Api\JournalController@show');
//    Route::get('/users/{user_id}/internships/{internship_id}/journal_entries', '');

    # New endpoints
    Route::get('/cities','Api\CityController@index');
    Route::get('/cities/{postcode?}','Api\CityController@showByPostcode');
    Route::post('/cities', 'Api\CityController@create');
    Route::put('/cities', 'Api\CityController@edit');
    Route::delete('/cities/{id}', 'Api\CityController@delete');


    # Companies
    Route::get('/companies', 'Api\CompanyController@index');
    Route::get('/companies/{slug}', 'Api\CompanyController@show');
    Route::get('/companies/{slug}/offers','Api\CompanyController@getCompanyOffers');
    Route::get('/companies/{slug}/workers','Api\CompanyController@getCompanyWorkers');
    Route::get('/companies/categories', 'Api\CompanyCategoryController@index');

    # Offers
    Route::get('/offers','Api\OfferController@index');
    Route::post('/offers', 'Api\OfferController@store');
    Route::get('/offers/statuses', 'Api\OfferStatusController@index');
    Route::get('/offers/categories', 'Api\OfferCategoryController@index');
    Route::get('/offers/{slug}','Api\OfferController@show');
    Route::get('/offers/{slug}/accept','Api\OfferController@accept');
    Route::get('/offers/{slug}/reject','Api\OfferController@reject');

    # Internship Tasks
    Route::post('/internships', 'Api\InternshipController@store');
    Route::post('/internships/{internship}/tasks', 'Api\TaskController@store');
    Route::get('/internships/{internship}/students/{student}/tasks', 'Api\StudentTaskController@index');
    Route::post('/internships/{internship}/students/{student?}/tasks', 'Api\TaskController@store');
    Route::get('/internships/{internship}/students/{student}/tasks/{task}', 'Api\TaskController@show');

    # Universities
    Route::get('/universities/{slug}', 'Api\UniversityController@show');
    Route::get('/universities/{slug}/workers','Api\UniversityController@getWorkers');
    Route::get('/universities/{slug}/students','Api\UniversityController@getStudents');
    Route::get('/universities/{slug}/agreements','Api\UniversityController@getAgreements');
    Route::get('/universities/{slug}/internships','Api\UniversityController@getInternships2');
    Route::get('/universities/{slug}/faculties','Api\UniversityController@getFaculties');
    Route::get('/universities/{slug}/offers','Api\UniversityController@getOffers');

    # Student
    Route::post('/students/internships', 'Api\StudentController@createStudentOwnInternship');

    # User
    Route::get('/me/internships/{status?}', 'Api\UserController@getUserInternships')->where('status', \App\Constants\InternshipStatusConstants::STATUS_ACCEPTED.'|'.\App\Constants\InternshipStatusConstants::STATUS_NEW);
    Route::get('/me/internships', 'Api\UserController@getUserInternships');
    Route::get('/me/universities', 'Api\UserUniversityController@index');
    Route::get('/me/companies', 'Api\UserCompanyController@index');
    Route::get('/me/notifications', 'Api\NotificationController@index');
    Route::get('/me/offers','Api\StudentController@getAvailableInternshipOffers');

    # Statistics
    Route::get('/statistics/offers/count','Api\StatisticController@getNumberOfOffers');
    Route::get('/statistics/offers/new/count/','Api\StatisticController@getNumberOfNewOffers');
    Route::get('/statistics/users/count','Api\StatisticController@getNumberOfUsers');
    Route::get('/statistics/agreements/count','Api\StatisticController@getNumberOfAgreements');
    Route::get('/statistics/universities/count','Api\StatisticController@getNumberOfUniversities');
    Route::get('/statistics/companies/count','Api\StatisticController@getNumberOfCompanies');
    Route::get('/statistics/attachments/count','Api\StatisticController@getNumberOfAttachments');
    Route::get('/statistics/offers/attachments/count','Api\StatisticController@getNumberOfOffersAttachments');

    Route::get('/test', 'Api\TestController@test');


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
