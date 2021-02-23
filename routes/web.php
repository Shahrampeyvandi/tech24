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
Route::get('/',function()
{
    // $conn = ftp_connect('download.techone24.com');
    // // tMC&.nJ]fBg,
    // $login = ftp_login($conn, 'upload@download.techone24.com', 'tMC&.nJ]fBg,');
    // dd($login);
    // ftp_set_option($conn, FTP_USEPASVADDRESS, false);
    // ftp_pasv($conn, true);
    // ftp_put($conn, '/uploads/file.txt', $_FILES['file']['tmp_name'], FTP_BINARY);
    // ftp_close($conn);
});


// Route::get('/', function () {
//     return redirect('/index');
// });

Auth::routes();
Route::get('logout', 'QovexController@logout');

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