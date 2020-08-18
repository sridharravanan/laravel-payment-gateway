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

Route::get('/', 'HomeController@index');
Route::get('/tutor-registration', 'Auth\RegisterController@tutorRegistration')->name('tutor-registration');
Route::post('/tutor-save', 'Auth\RegisterController@tutorSave')->name('tutor-save');
Auth::routes();
Route::group([
    'middleware' => 'auth:web'
], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/category', 'CategoryController@index');
});

