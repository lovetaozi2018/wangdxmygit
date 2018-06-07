<?php

namespace App\Http\Controllers;

use App\Models\Squad;
use App\Models\SquadVideo;

class IndexController extends Controller
{
    public function index()
    {
        $classId =1;
        $class = Squad::find($classId);
        $school = $class->grade->school;
        $video = SquadVideo::whereClassId($classId)->latest()->first();
        if($video){
            $video->path = env('APP_URL').$video->path;
        }

        return response()->json([
            'stausCode'=>200,
            'class'=>$class,
            'school'=>$school,
            'video'=>$video
        ]);

    }
}
