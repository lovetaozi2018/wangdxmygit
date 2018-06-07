<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {

});
Route::post('login', 'AuthenticateController@login');

Route::get('school/index', 'SchoolController@index'); //学校轮播图和学校简介
Route::get('teacher/index', 'TeacherController@index'); //教师录
Route::get('schoolmate/index', 'SchoolMateController@index'); //同学录
