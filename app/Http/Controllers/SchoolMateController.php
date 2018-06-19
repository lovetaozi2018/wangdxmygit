<?php

namespace App\Http\Controllers;

use App\Models\Squad;
use App\Models\Student;
use App\Models\StudentMessage;
use App\Models\StudentPhoto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SchoolMateController extends Controller
{
    protected $message;

    function __construct(StudentMessage $message)
    {
        $this->message = $message;
    }

    /**
     * 同学录
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $classId = Request::get('class_id') ? Request::get('class_id') : 1;
        $class = Squad::whereId($classId)->first();
        $students = [];
        $students = $class->students;
        if(sizeof($students) != 0){
            foreach ($students as $k=>$t)
            {
                $user = User::whereId($t->user_id)->first();
                $students[$k]->realname = $user->realname;
                if($user->qrcode_image){
                    $students[$k]->qrcode_image = env('APP_URL').$user->qrcode_image;
                }else{
                    $students[$k]->qrcode_image = $user->qrcode_image;
                }
            }
        }

        return response()->json(['statusCode' => 200,'students'=>$students ]);

    }

    /**
     * 同学录相册
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail()
    {
        $studentId = Request::get('student_id') ? Request::get('student_id') : 1;
        $user = Student::find($studentId)->user;

        if($user->qrcode_image){
            $user->qrcode_image = env('APP_URL').$user->qrcode_image;
        }

        if($user->ground_image){
            $user->ground_image = env('APP_URL').$user->ground_image;
        }

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

        return response()->json(['statusCode' => 200,'user'=>$user,'data'=>$studentPhotos]);

    }

    /**
     * 上一张和下一张图片
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function preNext()
    {
        $id = Request::get('id');
        $picture = StudentPhoto::whereId($id)->first();
        $picture->path = env('APP_URL').$picture->path;
        $studentId = $picture->student_id;
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
     * 学生个人信息
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo()
    {
        $studentId = Request::get('student_id') ? Request::get('student_id') : 1;
        $student = Student::find($studentId);
        $student->qq = $student->user->qq;
        $student->wechat = $student->user->wechat;
        $student->mobile = $student->user->mobile;

        $student = $student->toArray();
        unset($student['user']);

        return response()->json(['statusCode' => 200,'data'=>$student ]);

    }

    /**
     * 给同学留言
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $board = $this->message->store(Request::all());
        return $board ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode'=>400]);
    }
}
