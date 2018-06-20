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
        $userId = Auth::id();
//        $userId = 5;
        $user = User::find($userId);
        if($user->qrcode_image){
            $user->qrcode_image = env('APP_URL').$user->qrcode_image;
        }
        if($user->ground_image){
            $user->ground_image = env('APP_URL').$user->ground_image;
        }
        return response()->json(['statusCode' =>200,'data'=> $user]);
    }


    /**
     * 个人信息
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo()
    {
        $userId = Auth::id();
//        $userId = 5;
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
        $userId = Auth::id();
        $user = User::find($userId);
        $studentId = $user->student->id;
        # 获取照片的创建时间
        $date = StudentPhoto::whereStudentId($studentId)->get(['created_at']);
        foreach ($date as $k=>$d)
        {
            $month[] = substr($d['created_at'],0,7);
        }
        $month = array_unique($month);
        foreach ($month as $m){
            $pictures = StudentPhoto::whereStudentId($studentId)
                ->where('created_at', 'like', '%' . $m . '%')
                ->get();
            foreach ($pictures as $k=>$p){
                $p->path = env('APP_URL').$p->path;
            }
            $studentPhotos[$m] = $pictures;
        }

        return response()->json(['statusCode' =>200,'data'=> $studentPhotos]);

    }

    /**
     * 上一张和下一张图片
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function preNext()
    {
//        $userId = Auth::id();
        $userId = 5;
        $user = User::find($userId);
        $studentId = $user->student->id;
        # 图片id
        $id = Request::get('id');
        $picture = StudentPhoto::whereId($id)->first();
        $picture->path = env('APP_URL').$picture->path;
        # 年月
        $month = substr($picture['created_at'],0,7);
        $pre = $next = [];
        # 上一个id
        $pre = StudentPhoto::whereStudentId($studentId)
            ->where('id','<',$id)
            ->where('created_at', 'like', '%' . $month . '%')
            ->first();
        if($pre){
            $pre->path = env('APP_URL').$pre->path;
        }

        # 下一张图片
        $next = StudentPhoto::whereStudentId($studentId)
            ->where('id','>',$id)
            ->where('created_at', 'like', '%' . $month . '%')
            ->first();
        if($next){
            $next->path = env('APP_URL').$next->path;
        }

        return response()->json([
            'statusCode'=> 200,
            'data'=>$picture,
            'pre' => $pre,
            'next' => $next
        ]);

    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function messages()
    {
                $userId = Auth::id();
//        $userId = 5;
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
     * 上传头像
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadHead()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        # 原来的头像
        $lastImage = $user->qrcode_image;
        if($lastImage){
            $imagePath = public_path().$lastImage;
        }
        $classId = User::find($userId)->student->id;
        $file = Request::file('fileImg');
        $path = public_path().'/uploads/head/'.$classId.'/';
        $image = User::uploadedMedias($file,$path);
        $qrcodeImage = '/uploads/head/'.$classId.'/'.$image['filename'];
        $res = User::whereId($userId)->update(['qrcode_image'=>$qrcodeImage ]);

        if($res){
            if($lastImage && is_file($imagePath)){
                unlink($imagePath);
            }
            return  response()->json(['statusCode' => 200]);
        }else{
            return response()->json(['statusCode'=>400]);
        }

    }

    /**
     * 上传背景图
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadBack()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        # 原来的背景
        $lastImage = $user->ground_image;
        if($lastImage){
            $imagePath = public_path().$lastImage;
        }
        $classId = User::find($userId)->student->id;
        $file = Request::file('fileImg');
        $path = public_path().'/uploads/picture/background/'.$classId.'/';
        $image = User::uploadedMedias($file,$path);
        $groundImage = '/uploads/picture/background/'.$classId.'/'.$image['filename'];
        $res = User::whereId($userId)->update(['ground_image'=>$groundImage ]);

        if($res){
            if($lastImage && is_file($imagePath)){
                unlink($imagePath);
            }
            return  response()->json(['statusCode' => 200]);
        }else{
            return response()->json(['statusCode'=>400]);
        }
    }

    /**
     * 上传图片到个人相册
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function uploadMyPicture()
    {
        $file = Request::file('fileImg');
        $res = User::uploadMyPicture($file);
        return $res ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode'=>400]);
    }
    /**
     * 更新个人信息
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update()
    {
        $res = User::modify(Request::all());
        return $res ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode'=>400]);
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
