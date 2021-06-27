<?php

use Illuminate\Support\Facades\Auth;
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



Route::post('/verify-mobile','Panel\UserController@verifyMobile');
// Authentication Routes...
Route::get('login', function(){
    return redirect('/');
})->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('auth/{provider}', 'Auth\SocialController@redirect');
Route::get('auth/{provider}/callback','Auth\SocialController@Callback');
// Registration Routes...
Route::get('register',function(){
    return redirect('/');
})->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::post('/check-mobile', 'Auth\RegisterController@checkMobile');



Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/confirm-code','Auth\ForgotPasswordController@SendCode')->name('password.sendcode');
Route::post('password/confirm-code','Auth\ResetPasswordController@reset')->name('password.sendcode');

Route::get('/','Home\IndexController@index')->name('baseurl');
Route::get('/aboutus','Home\IndexController@aboutus')->name('aboutus');
Route::get('/contactus','Home\IndexController@contactus')->name('contactus');
Route::get('/webinars/{category?}','Home\PostController@posts');
Route::get('/courses/{category?}','Home\PostController@posts');
Route::get('/blogs/{category?}','Home\BlogController@posts');
Route::get('/blog/{slug}','Home\BlogController@show');
Route::get('/podcasts/{category?}','Home\PostController@posts');
Route::get('/category/{slug}','Home\CategoryController@posts');
Route::get('/pay','Home\PayController@pay')->name('pay')->middleware(['auth','userAccount']);
Route::get('/pay/callback','Home\PayController@callback')->name('pay.callback')->middleware('auth');
Route::get('/play/{slug}','Home\PostController@play')->name('play');
Route::post('/ticket/send','Home\TicketController@store')->name('ticket.store');
Route::get('/search','Home\SearchController@index');
Route::post('/search','Home\SearchController@search');
Route::get('/{post}','Home\PostController@show')->name('post.show');
Route::get('/{post}/register','Home\PostController@register')->name('post.register')
->middleware(['auth','userAccount'])
;





// You can also use auth middleware to prevent unauthenticated users
Route::group(['middleware' => 'auth'], function () {
    Route::post('comment/create','Controller@createComment')->name('comment.insert');

    Route::group([
        'prefix'=>'panel',
        'as' => 'member.'
    ],function (){
        Route::get('/{user}/posts', 'Panel\UserController@posts')->name('posts');
        Route::get('/{user}/profile', 'Panel\UserController@profile')->name('profile');
        Route::post('/{user}/profile', 'Panel\UserController@updateProfile')->name('profile');

        Route::get('/{user}/post/{id}', 'Panel\UserController@show_post_lessons')->name('course.lessons');
        Route::get('/{user}/lesson/{id}/quiz', 'Panel\CourseController@show_quiz')->name('course.quiz.show');
        Route::get('/{user}/lesson/{id}/start-quiz', 'Panel\CourseController@start_quiz')->name('course.quiz.start');
        Route::post('/quiz/answer/submit', 'Panel\CourseController@submit_answer');
        Route::get('/{user}', 'Panel\UserController@index')->name('dashboard');
        Route::get('/chat/{group}', 'Panel\UserController@chat')->name('chat');
    });

    // Route::get('{any}', 'QovexController@index');
});

