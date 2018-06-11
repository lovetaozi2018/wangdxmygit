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
        if(!$name){
            return response()->json(['statusCode'=> 400]);
        }
        foreach ($name as $n){
            $names[] = $n['name'];
        }
        $names = array_unique($names);

        foreach ($names as $k=>$n){
            $picture = Picture::whereName($n)->latest()->first()->toArray();
            $picture['path'] = env('APP_URL').$picture['path'];
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
        $classId = Request::get('class_id') ? Request::get('class_id') : 1;
        $pictures = Picture::whereName($name)
            ->where('class_id',$classId)
            ->get(['id','name','path'])->toArray();
        foreach ($pictures as $k=>$v)
        {
            $pictures[$k]['path'] = env('APP_URL').$v['path'];
        }
        return response()->json(['statusCode'=> 200,'data'=>$pictures]);
    }


}
