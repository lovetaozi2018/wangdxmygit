<?php

namespace App\Http\Controllers;


use App\Models\Squad;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $classId = Request::get('class_id') ? Request::get('class_id') : 1;
        $teacherId = Squad::find($classId)->teacher_ids;
        if (!$teacherId) {
            return response()->json(['statusCode' => 201, 'messgae' => '该班级老师为空']);
        }

        $teacherIds = explode(',', $teacherId);
        $teachers = Teacher::whereIn('id', $teacherIds)->get();
        foreach ($teachers as $t) {
            $userIds[] = $t->user_id;
        }
        $users = User::whereEnabled(1)->whereIn('id', $userIds)->get();
        return response()->json(['statusCode','user'=>$users]);
    }
}
