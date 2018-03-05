<?php

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
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

//Route::resource('threads', 'ThreadController');
Route::get('/threads', 'ThreadController@index');
Route::get('/threads/create', 'ThreadController@create');
Route::get('/threads/{channel}', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy');
Route::post('/threads', 'ThreadController@store');

Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::post('/replies/{reply}/favorites', 'FavoriteController@store');

Route::get('/profiles/{user}', 'ProfileController@show')->name('profile');

