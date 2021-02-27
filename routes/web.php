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

// Route::get('/', function () {
//     return redirect('/index');
// });

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::get('/','Home\IndexController@index')->name('baseurl');
Route::get('/aboutus','Home\IndexController@aboutus')->name('aboutus');
Route::get('/contactus','Home\IndexController@contactus')->name('contactus');
Route::get('/webinars/{category?}','Home\PostController@posts');
Route::get('/courses/{category?}','Home\PostController@posts');
Route::get('/podcasts','Home\PostController@podcasts');
Route::get('/category/{slug}','Home\CategoryController@posts');
Route::get('/{post}','Home\PostController@show')->name('post.show');
Route::post('/ticket/send','Home\TicketController@store')->name('ticket.store');
Route::get('/play/{slug}','Home\PostController@play')->name('play');


Route::get('pages-login', 'QovexController@index');
Route::get('pages-login-2', 'QovexController@index');
Route::get('pages-register', 'QovexController@index');
Route::get('pages-register-2', 'QovexController@index');
Route::get('pages-recoverpw', 'QovexController@index');
Route::get('pages-recoverpw-2', 'QovexController@index');
Route::get('pages-lock-screen', 'QovexController@index');
Route::get('pages-lock-screen-2', 'QovexController@index');
Route::get('pages-404', 'QovexController@index');
Route::get('pages-500', 'QovexController@index');
Route::get('pages-maintenance', 'QovexController@index');
Route::get('pages-comingsoon', 'QovexController@index');
Route::post('login-status', 'QovexController@checkStatus');


// You can also use auth middleware to prevent unauthenticated users
Route::group(['middleware' => 'auth'], function () {
    // Route::get('/home', 'HomeController@index')->name('home');
    Route::get('{any}', 'QovexController@index');
});