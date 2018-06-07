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
        $classId = Request::get('class_id') ?  Request::get('class_id') : 1;
        $page = Request::get('page') ? Request::get('page') : 1;
        $pageSize = 5;
        $start = ($page - 1) * $pageSize;
        $messages = SquadMessage::whereClassId($classId)
            ->latest()
            ->offset($start)
            ->take($pageSize)
            ->get();

        return response()->json(['statusCode'=>200,'data' => $messages]);

    }

    /**
     * 留言
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $message = $this->squadMessage->store(Request::all());
        return $message ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }
}
