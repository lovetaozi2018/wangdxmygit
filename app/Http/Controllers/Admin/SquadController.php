<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SquadRequest;
use App\Models\Grade;
use App\Models\Squad;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Support\Facades\Request;

class SquadController extends Controller
{

    protected $squad;
    protected $grade;

    function __construct(Grade $grade,Squad $squad) {
//        $this->middleware(['auth']);
        $this->grade = $grade;
        $this->squad = $squad;

    }

    /**
     * 年级列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->squad->datatable());

        }
        return view('admin.class.index', [
            'js' => '../js/admin/class/index.js',
        ]);
    }

    /**
     * 创建年级的表单
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data = Teacher::with('user')
            ->where('school_id', 1)
            ->get()->toArray();
        $teachers = [];
        if (!empty($data)) {
            foreach ($data as $v) {
                $teachers[$v['id']] = $v['user']['realname'];
            }
        }

        $grades = Grade::whereEnabled(1)->get()->pluck('name', 'id');

        foreach ($grades as $k=>$g){
            $grades[$k] = $g.'——'.Grade::whereId($k)->first()->school->name;
        }

        return view('admin.class.create', [
            'js' => '../js/admin/class/create.js',
            'grades' => $grades,
            'teachers' => $teachers,
        ]);
    }


    /**
     * 保存班级
     *
     * @param SquadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SquadRequest $request)
    {

        return $this->squad->store($request->all()) ?
            response()->json(['statusCode' => 200]):
            response()->json(['statusCode' => 400]);

    }

    /**
     * 编辑的表单页面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {

        # 获取老师
        $data = Teacher::with('user')
            ->where('school_id', 1)
            ->get()->toArray();
        $teachers = [];
        if (!empty($data)) {
            foreach ($data as $v) {
                $teachers[$v['id']] = $v['user']['realname'];
            }
        }


        # 获取年级
        $grades = Grade::whereEnabled(1)->get()->pluck('name', 'id');

        foreach ($grades as $k=>$g){
            $grades[$k] = $g.'——'.Grade::whereId($k)->first()->school->name;
        }
        # 班级
        $classes = $this->squad->find($id);
        $teacherIds = explode(',',$classes->teacher_ids);
        #  获取被选中的老师
        foreach ($teacherIds as $id) {
            $teacher = Teacher::find($id);
            $selectedTeachers[$id] = $teacher->user->realname;
        }

        return view('admin.class.edit', [
            'classes' => $classes,
            'grades' => $grades,
            'teachers' => $teachers,
            'selectedTeachers' => $selectedTeachers,
            'js'    => '../../js/admin/class/edit.js',
        ]);


    }

    /**
     * 更新学校
     *
     * @param SquadRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SquadRequest $request, $id)
    {
        return $this->squad->modify($request->all(),$id) ?
            response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

    /**
     * 删除班级
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        return $this->squad->remove($id)
            ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

}
