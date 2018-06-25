<?php

namespace App\Http\Controllers;


use App\Models\Album;
use App\Models\Picture;
use Illuminate\Support\Facades\Request;

class SquadPictureController extends Controller
{

    /**
     * 班级相册列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $classId = Request::get('class_id');
        # 获取相册id
        $albumId =  Picture::whereClassId($classId)
            ->get(['album_id']);
        if(!$albumId){
            return response()->json(['statusCode'=> 400]);

        }
        $albumIds =[];
        foreach ($albumId as $k=>$d)
        {
            $albumIds[] = $d['album_id'];
        }
        # 去重
        $albumIds = array_unique($albumIds);
        foreach ($albumIds as $a){
            $album = Album::find($a);
            $picture  = Picture::whereAlbumId($a)
                ->where('class_id',$classId)
                ->latest()->first();
            $album->class_id = $classId;
            $album->path = env('APP_URL').$picture->path;
            $album->total = Picture::whereAlbumId($a)->where('class_id',$classId)->count();
            $albums[] = $album;
        }
        return response()->json(['statusCode'=> 200,'data'=>$albums]);

    }
    /**
     * 班级相册详情
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(){
        $classId = Request::get('class_id');
        $albumId = Request::get('album_id');
        # 获取相册的年月
        $date = Picture::whereAlbumId($albumId)
            ->where('class_id',$classId)
            ->get(['created_at']);

        foreach ($date as $k=>$d)
        {
            $month[] = substr($d['created_at'],0,7);
        }
        $month = array_unique($month);
        foreach ($month as $m){
            $pictures = Picture::whereClassId($classId)
                ->where('created_at', 'like', '%' . $m . '%')
                ->get();
            foreach ($pictures as $k=>$p){
                $p->path = env('APP_URL').$p->path;
                $p->name = Album::find($p->album_id)->name;
            }
            $squadPictures[$m] = $pictures;
        }

        return response()->json(['statusCode'=> 200,'data'=>$squadPictures]);

    }

    /**
     * 上一张和下一张图片
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function preNext()
    {
        $id = Request::get('id');
        $picture = Picture::whereId($id)->first();
        $picture->path = env('APP_URL').$picture->path;
        $classId = $picture->class_id;
        # 年月
        $month = substr($picture['created_at'],0,7);
        $pre = $next = [];
        # 上一个id
        $pre = Picture::whereClassId($classId)
            ->where('id','<',$id)
            ->where('created_at', 'like', '%' . $month . '%')
            ->first();
        if($pre){
            $pre->path = env('APP_URL').$pre->path;
        }

        # 下一张图片
        $next = Picture::whereClassId($classId)
            ->where('id','>',$id)
            ->where('created_at', 'like', '%' . $month . '%')
            ->first();
        if($next){
            $next->path = env('APP_URL').$next->path;
        }

        return response()->json([
            'statusCode'=> 200,
            'data'=>$picture,
            'pre' => $pre,
            'next' => $next
        ]);

    }




}
