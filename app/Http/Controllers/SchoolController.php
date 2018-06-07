<?php

namespace App\Http\Controllers;


use App\Models\Recommend;
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
        $schoolId = Request::get('school_id') ? Request::get('school_id') : 1 ;
        $slide = Slide::whereSchoolId($schoolId)->get();
        $recommend = Recommend::whereSchoolId($schoolId)->first();
        return response()->json([
            'statusCode'=>200,
            'slide' => $slide,
            'recommend' => $recommend,
        ]);
    }
}
