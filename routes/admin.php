<?php

Route::group(['middleware' => ['auth', 'role:admin'], 'namespace' => 'Admin'], function () {
    Route::get('index', 'IndexController@index')->name('admin.index');
    Route::resource('users', 'UserController');
    Route::resource('courses/quizzes', 'Course\QuizController');
    Route::resource('courses', 'Course\CourseController');
    Route::resource('groups', 'GroupController');
    Route::resource('certificates', 'CertificateController');



    // ajax requests
    Route::post('/changeusergroup', 'UserController@changegroup')->name('users.changegroup');
});
