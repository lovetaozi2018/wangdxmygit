<?php

namespace App\Http\Controllers;


use App\Models\Picture;
use Illuminate\Support\Facades\Request;

class SquadPictureController extends Controller
{

    /**
     * 班级相册列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $classId = Request::get('class_id') ? Request::get('class_id') : 1;
        $name = Picture::whereClassId($classId)
            ->get(['name']);
        foreach ($name as $n){
            $names[] = $n['name'];
        }
        $names = array_unique($names);

        foreach ($names as $k=>$n){
            $picture = Picture::whereName($n)->latest()->first()->toArray();
            $picture['total'] = Picture::whereName($n)->count();
            $pictures[] = $picture;
        }

        return response()->json(['statusCode'=> 200,'data'=>$pictures]);

    }

    /**
     * 班级相册详情
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail()
    {
        $name = Request::get('name');
        $pictures = Picture::whereName($name)->get(['id','name','path'])->toArray();

        return response()->json(['statusCode'=> 200,'data'=>$pictures]);
    }


}
