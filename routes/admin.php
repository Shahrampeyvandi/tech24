<?php

Route::group(['middleware' => ['auth', 'role:admin'], 'namespace' => 'Admin'], function () {
    Route::get('index', 'IndexController@index')->name('admin.index');
    Route::resource('users', 'UserController')->except(['show','update']);
    Route::resource('courses/quizzes', 'Course\QuizController')->except(['show','update']);
    Route::resource('courses', 'Course\CourseController')->except(['show','update']);
    Route::resource('groups', 'GroupController')->except(['show','update']);
    Route::resource('certificates', 'CertificateController')->except(['show','update']);
    Route::resource('notifications', 'NotificationController')->except(['show','update']);
    Route::resource('lessons', 'LessonController')->except(['show','update']);


    // ajax requests
    Route::post('/changeusergroup', 'UserController@changegroup')->name('users.changegroup');
});
