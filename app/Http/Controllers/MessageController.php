<?php

namespace App\Http\Controllers;


use App\Models\Message;
use App\Models\Student;
use Illuminate\Support\Facades\Request;

class MessageController extends Controller
{
    protected $message;

    function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * 留言列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $classId = Request::get('class_id') ?  Request::get('class_id') : 1;
        $page = Request::get('page') ? Request::get('page') : 1;
        $pageSize = Request::get('size') ? Request::get('size') : 5;
        $count = Message::whereClassId($classId)->count();
        $start = ($page - 1) * $pageSize;
        $messages = Message::whereClassId($classId)
            ->latest()
            ->offset($start)
            ->take($pageSize)
            ->get();
        foreach ($messages as $k=>$m){
            $student = Student::find($m->student_id);
            $messages[$k]->username = $student->user->realname;
            if(!empty($student->user->qrcode_image)){
                $messages[$k]->qrcode_image = env('APP_URL').$student->user->qrcode_image;
            }else{
                $messages[$k]->qrcode_image = $student->user->qrcode_image;
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
     * 留言
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $message = $this->message->store(Request::all());
        return $message ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }



}
