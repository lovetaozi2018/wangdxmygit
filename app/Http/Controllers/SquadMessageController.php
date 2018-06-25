<?php

namespace App\Http\Controllers;


use App\Models\SquadMessage;
use Illuminate\Support\Facades\Request;

class SquadMessageController extends Controller
{
    protected $squadMessage;
    function __construct(SquadMessage $squadMessage)
    {
        $this->squadMessage = $squadMessage;
    }

    /**
     * 留言列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $videoId = Request::get('video_id');
        $page = Request::get('page') ? Request::get('page') : 1;
        $pageSize = Request::get('size') ? Request::get('size') : 5;
        $count = SquadMessage::whereClassVideoId($videoId)->count();
        $start = ($page - 1) * $pageSize;
        $messages = SquadMessage::whereClassVideoId($videoId)
            ->latest()
            ->offset($start)
            ->take($pageSize)
            ->get();
        if($page * $pageSize <= $count){
            $status = true;
        }else{
            $status = false;
        }
        return response()->json(['statusCode'=>200,'data' => $messages,'status'=>$status]);

    }


}
