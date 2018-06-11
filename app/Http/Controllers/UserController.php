<?php

namespace App\Http\Controllers;

use App\Models\StudentMessage;
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
//        $userId = Auth::id();
        $userId = 5;
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
        $userId = 5;
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
        $userId = 5;
        $user = User::find($userId);
        $studentId = $user->student->id;
        $pictures = StudentPhoto::whereStudentId($studentId)->get();
        foreach ($pictures as $k=>$p){
            $pictures[$k]->path = env('APP_URL').$p->path;
        }

        return response()->json(['statusCode' =>200,'data'=> $pictures]);

    }

    public function messages()
    {
        //        $userId = Auth::id();
        $userId = 5;
        $page = Request::get('page') ? Request::get('page') : 1;
        $pageSize = Request::get('size') ? Request::get('size') : 5;
        $start = ($page - 1) * $pageSize;
        $count = StudentMessage::whereUserId($userId)->count();
        $messages = StudentMessage::whereUserId($userId)
            ->offset($start)
            ->take($pageSize)
            ->get();
        foreach ($messages as $k=>$m){
            $messages[$k]->name = $m->sUser->realname;
            if($m->sUser->qrcode_image){
                $messages[$k]->qrcode_image = env('APP_URL').$m->sUser->qrcode_image;
            }else{
                $messages[$k]->qrcode_image = $m->sUser->qrcode_image;
            }

        }

        if($page * $pageSize <= $count){
            $status = true;
        }else{
            $status = false;
        }

        return response()->json(['statusCode'=>200,'data' => $messages,'status'=>$status]);

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

        if (!\Hash::check($password, $user->password)) {
            return response()->json(['statusCode' => 400]);
        }
        $res = $user->update(['password' => $pwd]);
        return $res ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 401]);

    }


}
