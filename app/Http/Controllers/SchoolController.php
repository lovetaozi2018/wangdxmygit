<?php

namespace App\Http\Controllers;

use App\Models\Recommend;
use App\Models\School;
use App\Models\Slide;
use Illuminate\Support\Facades\Request;

class SchoolController extends Controller
{
    /**
     * 学校轮播图和简介
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $slide = [];
        $schoolId = Request::get('school_id');
        $slide = Slide::whereSchoolId($schoolId)->get();
        if(sizeof($slide) != 0){
            foreach ($slide as $k=>$s){
                $slide[$k]->path = env('APP_URL').$s->path;
            }
        }
        $recommend = Recommend::whereSchoolId($schoolId)->first();
        $recommend->schoolname = School::find($recommend->school_id)->name;
        return response()->json([
            'statusCode'=>200,
            'slide' => $slide,
            'recommend' => $recommend,
        ]);
    }
}
