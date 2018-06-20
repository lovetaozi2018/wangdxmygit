<?php

namespace App\Http\Controllers;


use App\Models\SquadHints;
use App\Models\SquadMessage;
use App\Models\SquadVideo;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SquadVideoController extends Controller
{

    protected $squadMessage;
    function __construct(SquadMessage $squadMessage)
    {
        $this->squadMessage = $squadMessage;
    }

    /**
     * 班级视频列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $classId = Request::get('class_id') ?  Request::get('class_id') : 1;
        $page = Request::get('page') ? Request::get('page') : 1;
        $pageSize = Request::get('size') ? Request::get('size') : 2;
        $start = ($page - 1) * $pageSize;
        $count = SquadVideo::whereClassId($classId)->count();
        $videos = SquadVideo::whereClassId($classId)
            ->latest()
            ->offset($start)
            ->take($pageSize)
            ->get();
        if(sizeof($videos) != 0){
            foreach ($videos as $k=>$s){
                $videos[$k]->path = env('APP_URL').$s->path;
                if(!empty($s->image)){
                    $videos[$k]->image = env('APP_URL').$s->image;

                }
                $videos[$k]->total = SquadHints::whereSquadVideoId($s->id)->count();
            }
            # 统计点赞次数
        }
        if($page * $pageSize <= $count){
            $status = true;
        }else{
            $status = false;
        }
        return response()->json(['statusCode'=>200,'data' => $videos,'status'=>$status]);
    }

    /**
     * 视频详情
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail()
    {
        $classVideoId = Request::get('class_video_id') ? Request::get('class_video_id') : 1;
        $page = Request::get('page') ? Request::get('page') : 1;
        $pageSize = Request::get('size') ? Request::get('size') : 3;
        $start = ($page - 1) * $pageSize;
        $video = SquadVideo::find($classVideoId);
        if(sizeof($video) != 0){
            $video->path = env('APP_URL').$video->path;
            if(!empty($video->image)){
                $video->image = env('APP_URL').$video->image;

            }
            # 统计点赞次数
            $video->total = SquadHints::whereSquadVideoId($classVideoId)->count();
        }

        $count = SquadHints::whereSquadVideoId($classVideoId)->count();
        $messages = [];
        $messages = SquadMessage::whereClassVideoId($classVideoId)
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
        return response()->json(['statusCode'=>200,'data' => $video,'message'=>$messages,'status'=>$status]);

    }

    /**
     * 视频点赞
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function hints(){
        $classVideoId = Request::input('class_video_id');
        $userId = Auth::id();
        $studentId = Student::whereUserId($userId)->first()->id;

        #查询是否已经点赞
        $hints = SquadHints::whereSquadVideoId($classVideoId)
            ->where('student_id',$studentId)
            ->first();
        if($hints){
            return response()->json(['statusCode'=>201]);
        }
        $data = [
            'squad_video_id'=>$classVideoId,
            'student_id' => $studentId,
            'enabled' => 1
        ];
        $res = SquadHints::create($data);

        return $res ? response()->json(['statusCode'=>200,'data'=>$res]) :
            response()->json(['statusCode'=>400]);

    }

    /**
     * 留言
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $message = $this->squadMessage->store(Request::all());
        return $message ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }
}
