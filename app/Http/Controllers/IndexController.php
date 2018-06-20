<?php

namespace App\Http\Controllers;

use App\Models\Squad;
use App\Models\SquadVideo;
use Illuminate\Support\Facades\Request;

class IndexController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $classId = Request::get('class_id') ? Request::get('class_id') : 1;
        $class = Squad::find($classId);
        $school = $class->grade->school;
        $video = SquadVideo::whereClassId($classId)->latest()->first();
        if($video){
            $video->path = env('APP_URL').$video->path;
        }

        if($video->image){
            $video->image = env('APP_URL').$video->image;
        }

        return response()->json([
            'stausCode'=>200,
            'class'=>$class,
            'school'=>$school,
            'video'=>$video
        ]);

    }
}
