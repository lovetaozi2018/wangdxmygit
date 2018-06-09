<?php

namespace App\Http\Controllers;


use App\Models\SquadVideo;
use Illuminate\Support\Facades\Request;

class SquadVideoController extends Controller
{
    /**
     * 班级视频列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $classId = Request::get('class_id') ?  Request::get('class_id') : 1;
        $page = Request::get('page') ? Request::get('page') : 1;
        $pageSize = 2;
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
            }
        }
        if($page * $pageSize <= $count){
            $status = true;
        }else{
            $status = false;
        }
        return response()->json(['statusCode'=>200,'data' => $videos,'status'=>$status]);
    }
}
