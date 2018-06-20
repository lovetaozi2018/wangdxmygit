<?php

namespace App\Http\Controllers;


use App\Models\SchoolHints;
use App\Models\SchoolMessage;
use App\Models\SchoolVideo;
use App\Models\Squad;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SchoolVideoController extends Controller
{
    protected $schoolMessage;
    function __construct(SchoolMessage $schoolMessage)
    {
        $this->schoolMessage = $schoolMessage;
    }

    /**
     * 班级视频列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $classId = Request::get('class_id') ?  Request::get('class_id') : 1;
        $schoolId = Squad::find($classId)->grade->school->id;
        $page = Request::get('page') ? Request::get('page') : 1;
        $pageSize = Request::get('size') ? Request::get('size') : 2;
        $start = ($page - 1) * $pageSize;
        $count = SchoolVideo::whereSchoolId($schoolId)->count();
        $videos = SchoolVideo::whereSchoolId($schoolId)
            ->offset($start)
            ->take($pageSize)
            ->get();
        if(sizeof($videos) != 0){
            foreach ($videos as $k=>$s){
                $videos[$k]->path = env('APP_URL').$s->path;
                if(!empty($s->image)){
                    $videos[$k]->image = env('APP_URL').$s->image;

                }
                # 统计点赞次数
                $videos[$k]->total = SchoolHints::whereSchoolVideoId($s->id)->count();

            }
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
        $schoolVideoId = Request::get('school_video_id') ? Request::get('school_video_id') : 1;
        $page = Request::get('page') ? Request::get('page') : 1;
        $pageSize = Request::get('size') ? Request::get('size') : 3;
        $start = ($page - 1) * $pageSize;
        $video = SchoolVideo::find($schoolVideoId);
        if(sizeof($video) != 0){
            $video->path = env('APP_URL').$video->path;
                if(!empty($video->image)){
                    $video->image = env('APP_URL').$video->image;

                }
                # 统计点赞次数
            $video->total = SchoolHints::whereSchoolVideoId($schoolVideoId)->count();
            }

        $count = SchoolHints::whereSchoolVideoId($schoolVideoId)->count();
        $messages = [];
        $messages = SchoolMessage::whereSchoolVideoId($schoolVideoId)
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
        $schoolVideoId = Request::input('school_video_id');
        $studentId = Student::whereUserId(Auth::id())->first()->id;

        #查询是否已经点赞
        $hints = SchoolHints::whereSchoolVideoId($schoolVideoId)
            ->where('student_id',$studentId)
            ->first();
        if($hints){
            return response()->json(['statusCode'=>201]);
        }
        $data = [
            'school_video_id'=>$schoolVideoId,
            'student_id' => $studentId,
            'enabled' => 1
        ];
        $res = SchoolHints::create($data);

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
        $message = $this->schoolMessage->store(Request::all());
        return $message ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }
}
