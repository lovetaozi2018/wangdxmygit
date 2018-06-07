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

# 同学录
Route::get('schoolmate/index', 'SchoolMateController@index'); //同学录
Route::get('schoolmate/detail', 'SchoolMateController@detail'); //同学录详情
Route::get('schoolmate/userInfo', 'SchoolMateController@userInfo'); //同学个人信息
Route::post('schoolmate/store', 'SchoolMateController@store'); //保存留言

# 班级相册
Route::get('squad/index', 'SquadPictureController@index'); //班级相册
Route::get('squad/detail', 'SquadPictureController@detail'); //班级相册详情

#班级留言
Route::get('squadMessage/index', 'SquadMessageController@index'); //留言详情
Route::post('squadMessage/store', 'SquadMessageController@store'); //保存留言