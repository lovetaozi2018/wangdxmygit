<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\School;
use App\Models\Squad;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $roleId = $user->role_id;

        # 如果是学校管理员
        if($roleId == 2){
            $schoolId = $user->school_id;
            $school = School::find($schoolId);
            $grades = $school->grades;
            $classIds=[];
            foreach ($grades as $k=>$g)
            {
                if($g->squads){
                    foreach ($g->squads as $s){
                        $classIds[] = $s->id;
                    }
                }
            }
            $classes = Squad::whereEnabled(1)->whereIn('id',$classIds)->get()->pluck('name', 'id');

        }else{
            $classes = Squad::whereEnabled(1)->get()->pluck('name', 'id');
        }

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
        $user = Auth::user();
        $roleId = $user->role_id;

        # 如果是学校管理员
        if($roleId == 2){
            $schoolId = $user->school_id;
            $school = School::find($schoolId);
            $grades = $school->grades;
            $classIds=[];
            foreach ($grades as $k=>$g)
            {
                if($g->squads){
                    foreach ($g->squads as $s){
                        $classIds[] = $s->id;
                    }
                }
            }
            $classes = Squad::whereEnabled(1)->whereIn('id',$classIds)->get()->pluck('name', 'id');

        }else{
            $classes = Squad::whereEnabled(1)->get()->pluck('name', 'id');
        }

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
     * @throws \Exception
     */
    public function update(StudentRequest $request, $id)
    {
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

    /**
     * 导入学籍
     * @throws \PHPExcel_Exception
     */
    public function import() {

        if (Request::isMethod('post')) {
            $file = Request::file('file');
            if (empty($file)) {
                $result = [
                    'statusCode' => 500,
                    'message'    => '您还没选择文件！',
                ];
                return response()->json($result);
            }
            // 文件是否上传成功
            if ($file->isValid()) {

                $result = Student::upload($file);
                return response()->json($result);
            }
        }

        return null;

    }
}
