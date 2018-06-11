<?php

namespace App\Http\Controllers;


use App\Models\Squad;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class TeacherController extends Controller
{
    /**
     * 教师录
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $classId = Request::get('class_id') ? Request::get('class_id') : 1;
        $page = Request::get('page') ? Request::get('page') : 1;
        $pageSize = Request::get('size') ? Request::get('size') : 5;
        $start = ($page - 1) * $pageSize;
        $teacherId = Squad::find($classId)->teacher_ids;
        if (!$teacherId) {
            return response()->json(['statusCode' => 201, 'messgae' => '该班级老师为空']);
        }
        $teacherIds = explode(',', $teacherId);
        $teachers = Teacher::whereIn('id', $teacherIds)
            ->get();
        foreach ($teachers as $t) {
            $userIds[] = $t->user_id;
        }
        $users = User::whereEnabled(1)->whereIn('id', $userIds)->get();
        foreach ($users as $k=>$u){
            $users[$k]->subject = Teacher::whereUserId($u['id'])->first()->subject;
        }
        $count  = $users->count();
        if($page * $pageSize <= $count){
            $status = true;
        }else{
            $status = false;
        }
        $user=array_slice($users->toArray(),$start,$pageSize);
        return response()->json(['statusCode'=> 200 ,'user'=>$user, 'status'=> $status ]);
    }
}
