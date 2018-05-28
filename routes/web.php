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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('test', 'TestController@index');

//Route::get('users/index', 'admin\UserController@index');
Route::group(['namespace' => 'Admin'], function () {
    Route::get('users/index', 'UserController@index');


    # 学校管理
    Route::get('schools/index', 'SchoolController@index');
    Route::get('schools/create', 'SchoolController@create');
    Route::post('schools/store', 'SchoolController@store');
    Route::get('schools/edit/{id}', 'SchoolController@edit');
    Route::put('schools/update/{id}', 'SchoolController@update');
    Route::delete('schools/delete/{id}', 'SchoolController@delete');

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
    Route::delete('classes/delete/{id}', 'SquadController@delete');

    # 教师管理
    Route::get('teachers/index', 'TeacherController@index');
    Route::get('teachers/create', 'TeacherController@create');
    Route::post('teachers/store', 'TeacherController@store');
    Route::get('teachers/edit/{id}', 'TeacherController@edit');
    Route::put('teachers/update/{id}', 'TeacherController@update');
    Route::delete('teachers/delete/{id}', 'TeacherController@delete');

    # 学生管理
    Route::get('students/index', 'StudentController@index');
    Route::get('students/create', 'StudentController@create');
    Route::post('students/store', 'StudentController@store');
    Route::get('students/edit/{id}', 'StudentController@edit');
    Route::put('students/update/{id}', 'StudentController@update');
    Route::delete('students/delete/{id}', 'StudentController@delete');
});
//Route::namespace('admin')->group(function () {
//    Route::get('users/index', 'UserController@index');
//});