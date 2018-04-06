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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
Route::get('my-theme', function () {

    return view('welcome2');

});
Route::get('/home', 'HomeController@index')->name('home');

//Route::resource('threads', 'ThreadController');
Route::get('/threads', 'ThreadController@index')->name('threads');
Route::get('/threads/create', 'ThreadController@create');
Route::get('/threads/{channel}', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
Route::post('/threads', 'ThreadController@store')->middleware('must-be-confirmed');
Route::patch('/threads/{channel}/{thread}', 'ThreadController@update');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy');

Route::post('/locked-thread/{thread}', 'LockThreadController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('/locked-thread/{thread}', 'LockThreadController@destroy')->name('locked-threads.destroy')->middleware('admin');

Route::post('/replies/{reply}/favorites', 'FavoriteController@store');
Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroy');

Route::post('replies/{reply}/best', 'BestReplyController@store')->name('best-replies.store');

Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::patch('/replies/{reply}', 'ReplyController@update');
Route::delete('/replies/{reply}', 'ReplyController@destroy')->name('replies.destroy');

Route::get('/profiles/{user}', 'ProfileController@show')->name('profile');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadsSubscribeController@store');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadsSubscribeController@destroy');

Route::get('/profiles/{user}/notifications', 'UserNotificationController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationController@destroy');

Route::get('/api/users', 'Api\UsersController@index');
Route::post('/api/users/{user}/avatar', 'Api\UsersAvatarController@store')->middleware('auth')->name('avatar');

Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
