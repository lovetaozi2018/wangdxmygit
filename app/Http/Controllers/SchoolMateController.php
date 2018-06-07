<?php

namespace App\Http\Controllers;

use App\Models\Squad;
use App\Models\Student;
use App\Models\StudentMessage;
use App\Models\StudentPhoto;
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
                $students[$k]->realname = $t->user->realname;
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
        $studentPhotos = StudentPhoto::whereStudentId($studentId)->get();

        return response()->json(['statusCode' => 200,'data'=>$studentPhotos ]);

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
