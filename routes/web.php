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
// Route::post('forgotpass/sendsms','Auth\LoginController@sendsms');
Route::get('/','Home\IndexController@index')->name('baseurl');
Route::get('/aboutus','Home\IndexController@aboutus')->name('aboutus');
Route::get('/contactus','Home\IndexController@contactus')->name('contactus');
Route::get('/webinars/{category?}','Home\PostController@posts');
Route::get('/courses/{category?}','Home\PostController@posts');
Route::get('/blogs/{category?}','Home\BlogController@posts');
Route::get('/podcasts/{category?}','Home\PostController@posts');
Route::get('/category/{slug}','Home\CategoryController@posts');
Route::get('/pay','Home\PayController@pay')->name('pay')->middleware('auth');
Route::get('/pay/callback','Home\PayController@callback')->name('pay.callback')->middleware('auth');
Route::get('/play/{slug}','Home\PostController@play')->name('play');
Route::post('/ticket/send','Home\TicketController@store')->name('ticket.store');
Route::get('/{post}','Home\PostController@show')->name('post.show');
Route::get('/{post}/register','Home\PostController@register')->name('post.register')->middleware('auth');


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
    Route::get('/panel/{user}/posts', 'Panel\UserController@posts')->name('member.posts');
    Route::get('/panel/{user}/profile', 'Panel\UserController@profile')->name('member.profile');
    Route::post('/panel/{user}/profile', 'Panel\UserController@updateProfile')->name('member.profile');
    
    Route::get('/panel/{user}/post/{id}', 'Panel\UserController@show_post_lessons')->name('member.course.lessons');
    Route::get('/panel/{user}/lesson/{id}/quiz', 'Panel\CourseController@show_quiz')->name('member.course.quiz.show');
    Route::get('/panel/{user}/lesson/{id}/start-quiz', 'Panel\CourseController@start_quiz')->name('member.course.quiz.start');
    Route::post('/panel/quiz/answer/submit', 'Panel\CourseController@submit_answer');
    Route::get('/panel/{user}', 'Panel\UserController@index')->name('member.dashboard');

    // Route::get('{any}', 'QovexController@index');
});

