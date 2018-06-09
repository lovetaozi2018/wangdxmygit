<?php

namespace App\Http\Controllers;

use App\Models\StudentPhoto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{

    /**
     * 个人中心
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $userId = Auth::id();
        $user = User::find($userId);

        return response()->json(['statusCode' =>200,'data'=> $user]);
    }


    /**
     * 个人信息
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo()
    {
//        $userId = Auth::id();
        $userId = 4;
        $user = User::find($userId);
        $student = $user->student;
        if($student){
            $user->star = $student->star;
            $user->address = $student->address;
            $user->hobby = $student->hobby;
            $user->specialty = $student->specialty;
        }
        $user = $user->toArray();
        unset($user['student']);

        return response()->json(['statusCode' =>200,'data'=> $user]);
    }


    /**
     * 我的相册
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myPictures()
    {
        //        $userId = Auth::id();
        $userId = 4;
        $user = User::find($userId);
        $studentId = $user->student->id;
        $pictures = StudentPhoto::whereStudentId($studentId)->get();

        return response()->json(['statusCode' =>200,'data'=> $pictures]);

    }

    /**
     * 重置密码
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset()
    {
        $password = Request::input('password');
        $pwd = bcrypt(Request::input('pwd'));
        $user = User::find(Auth::id());

        if (!\Hash::check($password,$user->password)) {
            return response()->json(['statusCode' => 400]);
        }
        $res = $user->update(['password' => $pwd]);
        if ($res) {
            return response()->json(['statusCode' => 200]);
        }
    }


}
