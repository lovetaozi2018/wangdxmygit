<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Squad;
use App\Models\Student;
use Illuminate\Support\Facades\Request;

class StudentController extends Controller
{
    protected $student;

    function __construct(Student $student) {
        $this->student = $student;

    }

    /**
     * 教师列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->student->datatable());

        }
        return view('admin.student.index', [
            'js' => '../js/admin/student/index.js',
        ]);
    }

    /**
     * 创建教师表单
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $classes = Squad::whereEnabled(1)->get()->pluck('name', 'id');

        foreach ($classes as $k=>$g){
            $classes[$k] = $g.'——'.Squad::whereId($k)->first()->grade->school->name;
        }

        return view('admin.student.create', [
            'js' => '../js/admin/student/create.js',
            'classes' => $classes,
        ]);
    }


    /**
     * 保存学生
     *
     * @param StudentRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(StudentRequest $request)
    {
        return $this->student->store($request->all()) ?
            response()->json(['statusCode' => 200]):
            response()->json(['statusCode' => 400]);

    }

    /**
     * 编辑学生页面表单
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $classes = Squad::whereEnabled(1)->get()->pluck('name', 'id');

        foreach ($classes as $k=>$g){
            $classes[$k] = $g.'——'.Squad::whereId($k)->first()->grade->school->name;
        }

        $student['student'] = $this->student->find($id);
        $student['user'] = $this->student->find($id)->user;

        return view('admin.student.edit', [
            'student' => $student,
            'classes' => $classes,
            'js'    => '../../js/admin/student/edit.js',
        ]);


    }

    /**
     * 更新学生信息
     *
     * @param StudentRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StudentRequest $request, $id)
    {
//        echo '<pre>';
//        print_r($request->all());exit;
        return $this->student->modify($request->all(),$id) ?
            response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

    /**
     * 删除学生
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($id) {
        return $this->student->remove($id)
            ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }
}
