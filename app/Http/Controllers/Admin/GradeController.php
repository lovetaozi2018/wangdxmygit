<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class GradeController extends Controller
{

    protected $grade;
    protected $school;

    function __construct(Grade $grade,School $school) {
//        $this->middleware(['auth']);
        $this->grade = $grade;
        $this->school = $school;

    }

    /**
     * 年级列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->grade->datatable());

        }
        return view('admin.grade.index', [
            'js' => '../js/admin/grade/index.js',
        ]);
    }

    /**
     * 创建年级的表单
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
            $schools = School::whereEnabled(1)->whereId($schoolId)->get()->pluck('name', 'id');
        }else{
            $schools = School::whereEnabled(1)->get()->pluck('name', 'id');
        }
        return view('admin.grade.create', [
            'js' => '../js/admin/grade/create.js',
            'schools' => $schools,
        ]);
    }


    /**
     * 保存年级
     *
     * @param GradeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GradeRequest $request)
    {

        return $this->grade->store($request->all()) ?
            response()->json(['statusCode' => 200]):
            response()->json(['statusCode' => 400]);

    }

    public function edit($id) {
        $user = Auth::user();
        $roleId = $user->role_id;

        # 如果是学校管理员
        if($roleId == 2){
            $schoolId = $user->school_id;
            $schools = School::whereEnabled(1)->whereId($schoolId)->get()->pluck('name', 'id');
        }else{
            $schools = School::whereEnabled(1)->get()->pluck('name', 'id');
        }

        $grade = $this->grade->find($id);
        return view('admin.grade.edit', [
            'grade' => $grade,
            'schools' => $schools,
            'js'    => '../../js/admin/grade/edit.js',
        ]);


    }

    /**
     * 更新学校
     *
     * @param GradeRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GradeRequest $request, $id)
    {
        return $this->grade->modify($request->all(),$id) ?
            response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

    /**
     * 删除年级
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        $gradeIds = User::getGradeId();
        if(in_array($id,$gradeIds)){
            $grade = Grade::find($id);
            if(sizeof($grade->squads)!=0){
                return response()->json(['statusCode' => 201]);
            }
            return $this->grade->remove($id)
                ? response()->json(['statusCode' => 200]) :
                response()->json(['statusCode' => 400]);
        }else{
            return response()->json(['statusCode' => 404]);
        }

    }


}
