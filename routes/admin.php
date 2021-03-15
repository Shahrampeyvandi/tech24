<?php

use Illuminate\Support\Facades\Redirect;

Route::group(['middleware' => ['auth', 'role:admin'], 'namespace' => 'Admin'], function () {
    Route::get('/', function () {
        return Redirect::route('admin.index');
    });
    Route::get('index', 'IndexController@index')->name('admin.index');
    Route::resource('users', 'UserController')->except(['show', 'update']);
    Route::resource('courses/quizzes', 'Course\QuizController')->except(['show', 'update']);
    Route::resource('questions', 'QuestionController')->except(['show', 'update']);

    Route::resource('posts', 'PostController')->except(['show', 'update']);
    Route::resource('groups', 'GroupController')->except(['show', 'update']);
    Route::resource('certificates', 'CertificateController')->except(['show', 'update']);
    Route::resource('notifications', 'NotificationController')->except(['show', 'update']);
    Route::resource('lessons', 'LessonController')->except(['show', 'update']);
    Route::get('question/excel/download','QuestionController@download');
    Route::resource('blogs', 'BlogController')->except(['show', 'update']);
    Route::resource('sliders', 'SliderController')->except(['show', 'update']);
    Route::resource('settings', 'SettingController')->except(['show', 'update']);

    
    Route::get('quiz/questions/download', 'Course\QuizController@download')->name('questions.download');
    // ajax requests
    Route::post('/changeusergroup', 'UserController@changegroup')->name('users.changegroup');
    Route::post('ajax/parent-category', 'PostController@parent_category');

});
