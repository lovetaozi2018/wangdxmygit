<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class TeacherController extends Controller
{
    protected $teacher;

    function __construct(Teacher $teacher) {
//        $this->middleware(['auth']);
        $this->teacher = $teacher;

    }

    /**
     * 教师列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->teacher->datatable());

        }
        return view('admin.teacher.index', [
            'js' => '../js/admin/teacher/index.js',
        ]);
    }

    /**
     * 创建教师表单
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.teacher.create', [
            'js' => '../js/admin/teacher/create.js',
            'schools' => School::whereEnabled(1)->get()->pluck('name', 'id'),
        ]);
    }


    /**
     * 保存教师
     *
     * @param TeacherRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(TeacherRequest $request)
    {
        return $this->teacher->store($request->all()) ?
            response()->json(['statusCode' => 200]):
            response()->json(['statusCode' => 400]);

    }

    /**
     * 编辑老师页面表单
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {

        $teacher = $this->teacher->find($id);
        $teacher->realname = $teacher->user->realname;
        $teacher->mobile = $teacher->user->mobile;
        $teacher->remark = $teacher->user->remark;
        return view('admin.teacher.edit', [
            'teacher' => $teacher,
            'schools' => School::whereEnabled(1)->get()->pluck('name', 'id'),
            'js'    => '../../js/admin/teacher/edit.js',
        ]);


    }

    /**
     * 更新老师信息
     *
     * @param TeacherRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(TeacherRequest $request, $id)
    {
        return $this->teacher->modify($request->all(),$id) ?
            response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

    /**
     * 删除老师
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($id) {
        return $this->teacher->remove($id)
            ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }
}
