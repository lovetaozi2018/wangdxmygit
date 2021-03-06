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


Route::get('/', function () {
    return redirect('login');
});
Route::get('/home', function () {
    return redirect('login');
});
Route::get('/home', function () {
    return redirect('grades/index');
});
Auth::routes();
Route::any('register', function() {
    return redirect('login');
});
Route::any('password/reset',function(){
    return redirect('login');
});
Route::any('password/email',function(){
    return redirect('login');
});
Route::any('password/reset/{token}',function(){
    return redirect('login');
});
Route::any('password/reset',function(){
    return redirect('login');
});
Route::get('logout', 'Auth\LoginController@logout');
Route::get('test', 'TestController@index');
Route::get('a', 'TestController@a');
Route::get('b', 'TestController@b');

//Route::get('users/index', 'admin\UserController@index');
Route::group(['namespace' => 'Admin'], function () {

    Route::get('qrcodes/class/{id}', 'QrcodeController@index');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('users/index', 'UserController@index');
        Route::get('users/edit/{id}', 'UserController@edit');
        Route::put('users/update/{id}', 'UserController@update');
        Route::any('users/reset', 'UserController@reset');
        # 学校管理
        Route::get('schools/index', 'SchoolController@index');
        Route::get('schools/create', 'SchoolController@create');
        Route::post('schools/store', 'SchoolController@store');
        Route::get('schools/edit/{id}', 'SchoolController@edit');
        Route::put('schools/update/{id}', 'SchoolController@update');
        Route::delete('schools/delete/{id}', 'SchoolController@delete');

        # 学校视频
        Route::get('schoolVideos/index', 'SchoolVideoController@index');
        Route::get('schoolVideos/create', 'SchoolVideoController@create');
        Route::post('schoolVideos/store', 'SchoolVideoController@store');
        Route::get('schoolVideos/edit/{id}', 'SchoolVideoController@edit');
        Route::post('schoolVideos/update/{id}', 'SchoolVideoController@update');
        Route::delete('schoolVideos/delete/{id}', 'SchoolVideoController@delete');

        # 轮播图管理
        Route::get('slides/index', 'SlideController@index');
        Route::get('slides/create', 'SlideController@create');
        Route::post('slides/store', 'SlideController@store');
        Route::get('slides/edit/{id}', 'SlideController@edit');
        Route::post('slides/update/{id}', 'SlideController@update');
        Route::delete('slides/delete/{id}', 'SlideController@delete');

        # 年级管理
        Route::get('grades/index', 'GradeController@index');
        Route::get('grades/create', 'GradeController@create');
        Route::post('grades/store', 'GradeController@store');
        Route::get('grades/edit/{id}', 'GradeController@edit');
        Route::put('grades/update/{id}', 'GradeController@update');
        Route::delete('grades/delete/{id}', 'GradeController@delete');

        # 班级管理
        Route::get('classes/index', 'SquadController@index');
        Route::get('classes/create', 'SquadController@create');
        Route::post('classes/store', 'SquadController@store');
        Route::get('classes/edit/{id}', 'SquadController@edit');
        Route::put('classes/update/{id}', 'SquadController@update');
        Route::post('classes/makeCode', 'SquadController@makeQrcode');
        Route::delete('classes/delete/{id}', 'SquadController@delete');


        # 班级相册管理
        Route::get('pictures/index', 'PictureController@index');
        Route::get('pictures/create', 'PictureController@create');
        Route::post('pictures/store', 'PictureController@store');
        Route::get('pictures/edit/{id}', 'PictureController@edit');
        Route::get('pictures/detail/{id}', 'PictureController@detail');
        Route::post('pictures/update/{id}', 'PictureController@update');
        Route::delete('pictures/delete/{id}', 'PictureController@delete');
        Route::delete('album/remove/{id}', 'PictureController@remove');

        # 班级视频
        Route::get('squadVideos/index', 'SquadVideoController@index');
        Route::get('squadVideos/create', 'SquadVideoController@create');
        Route::post('squadVideos/store', 'SquadVideoController@store');
        Route::get('squadVideos/edit/{id}', 'SquadVideoController@edit');
        Route::post('squadVideos/update/{id}', 'SquadVideoController@update');
        Route::delete('squadVideos/delete/{id}', 'SquadVideoController@delete');

        # 教师管理
        Route::get('teachers/index', 'TeacherController@index');
        Route::get('teachers/create', 'TeacherController@create');
        Route::post('teachers/store', 'TeacherController@store');
        Route::get('teachers/edit/{id}', 'TeacherController@edit');
        Route::put('teachers/update/{id}', 'TeacherController@update');
        Route::delete('teachers/delete/{id}', 'TeacherController@delete');
        Route::post('teachers/import', 'TeacherController@import');


        # 学生管理
        Route::get('students/index', 'StudentController@index');
        Route::get('students/create', 'StudentController@create');
        Route::post('students/store', 'StudentController@store');
        Route::get('students/edit/{id}', 'StudentController@edit');
        Route::put('students/update/{id}', 'StudentController@update');
        Route::delete('students/delete/{id}', 'StudentController@delete');
        Route::post('students/import', 'StudentController@import');
    });

});
//Route::namespace('admin')->group(function () {
//    Route::get('users/index', 'UserController@index');
//});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


