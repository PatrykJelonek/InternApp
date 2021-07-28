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
Route::get('pdf/preview', [\App\Http\Controllers\Api\InternshipController::class, 'preview'])->name('pdf.preview');
Route::get('pdf/generate', [\App\Http\Controllers\Api\InternshipController::class, 'downloadInternshipJournal'])->name('pdf.generate');
//Vue routing
Route::get('/{any}', 'SinglePageController@index')->where('any', '.*');

