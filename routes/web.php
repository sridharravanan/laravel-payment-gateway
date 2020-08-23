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


Route::get('/tutor-registration', 'Auth\RegisterController@tutorRegistration')->name('tutor-registration');
Route::post('/tutor-save', 'Auth\RegisterController@tutorSave')->name('tutor-save');
Auth::routes();
Route::group([
    'middleware' => 'auth:web'
], function () {
    Route::get('/', 'HomeController@index');
    //#uploads
    Route::post('/upload', 'UploadController@upload');
    Route::delete('/upload/{id}', 'UploadController@destroy');


    Route::get('/home', 'HomeController@index')->name('home');
    //Route::get('/category', 'CategoryController@index');

    //post
    Route::get('post/grid', 'PostController@getPost');
    Route::post('/post/get-reference', 'PostController@getReference');
    Route::delete('/post/post-tutor/{id}', 'PostController@deletePostTutor');
    Route::apiResource('post', 'PostController');


    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/dashboard/grid', 'DashboardController@getGrid');
    Route::post('/dashboard/additional-data', 'DashboardController@getAdditionalData');
    Route::post('/dashboard/pay-success', 'DashboardController@paySuccess');
    Route::get('/dashboard/post-download/{id}', 'DashboardController@postDownload');

    Route::get('tutor/grid', 'TutorController@getTutor');
    Route::apiResource('tutor', 'TutorController');
});

