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


    Route::post('schoolVideo/hints', 'SchoolVideoController@hints'); //学校视频点赞
    Route::post('schoolVideo/store', 'SchoolVideoController@store'); //保存学校视频留言


    Route::post('squadVideo/hints', 'SquadVideoController@hints'); //班级视频点赞
    Route::post('squadVideo/store', 'SquadVideoController@store'); //保存班级视频留言
    Route::post('schoolmate/store', 'SchoolMateController@store'); //保存同学留言

    # 个人中心
    Route::get('users/index', 'UserController@index'); //个人中心
    Route::get('users/userInfo', 'UserController@userInfo'); //个人信息
    Route::get('users/myPictures', 'UserController@myPictures'); //我的相册
    Route::get('users/messages', 'UserController@messages'); //同学留言
    Route::post('users/reset', 'UserController@reset'); //密码修改


});

Route::get('index', 'IndexController@index'); //主页


Route::post('login', 'AuthenticateController@login');
Route::post('logout', 'AuthenticateController@logout');

# 视频
Route::get('squadVideo/index', 'SquadVideoController@index'); //班级视频
Route::get('squadVideo/detail', 'SquadVideoController@detail'); //班级视频详情

Route::get('schoolVideo/index', 'SchoolVideoController@index'); //学校视频
Route::get('schoolVideo/detail', 'SchoolVideoController@detail'); //学校视频详情

Route::get('school/index', 'SchoolController@index'); //学校轮播图和学校简介
Route::get('teacher/index', 'TeacherController@index'); //教师录

# 同学录
Route::get('schoolmate/index', 'SchoolMateController@index'); //同学录
Route::get('schoolmate/detail', 'SchoolMateController@detail'); //同学录详情
Route::get('schoolmate/userInfo', 'SchoolMateController@userInfo'); //同学个人信息

# 班级相册
Route::get('squad/index', 'SquadPictureController@index'); //班级相册
Route::get('squad/detail', 'SquadPictureController@detail'); //班级相册详情

#班级留言
Route::get('squadMessage/index', 'SquadMessageController@index'); //留言详情


