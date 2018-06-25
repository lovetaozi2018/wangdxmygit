<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SquadRequest;
use App\Models\Grade;
use App\Models\School;
use App\Models\Squad;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $user = Auth::user();
        $roleId = $user->role_id;

        # 如果是学校管理员
        if($roleId == 2){
            $schoolId = $user->school_id;
            $school = School::find($schoolId);
            $grades = $school->grades;
            $gradeIds=[];
            foreach ($grades as $k=>$g)
            {
                $gradeIds[]=$g->id;
            }
            $grades = Grade::whereEnabled(1)->whereIn('id',$gradeIds)->get()->pluck('name', 'id');

        }else{
            $grades = Squad::whereEnabled(1)->get()->pluck('name', 'id');
        }

        $data = Teacher::whereSchoolId($schoolId)->with('user')
            ->get()->toArray();
        $teachers = [];
        if (!empty($data)) {
            foreach ($data as $v) {
                $teachers[$v['id']] = $v['user']['realname'];
            }
        }


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

        $user = Auth::user();
        $roleId = $user->role_id;

        # 如果是学校管理员
        if($roleId == 2){
            $schoolId = $user->school_id;
            $school = School::find($schoolId);
            $grades = $school->grades;
            $gradeIds=[];
            foreach ($grades as $k=>$g)
            {
                $gradeIds[]=$g->id;
            }
            $grades = Grade::whereEnabled(1)->whereIn('id',$gradeIds)->get()->pluck('name', 'id');

        }else{
            $grades = Squad::whereEnabled(1)->get()->pluck('name', 'id');
        }

        foreach ($grades as $k=>$g){
            $grades[$k] = $g.'——'.Grade::whereId($k)->first()->school->name;
        }

        $selectedTeachers = [];
        # 获取老师
        $data = Teacher::whereSchoolId($schoolId)->with('user')
            ->get()->toArray();
        $teachers = [];
        if (!empty($data)) {
            foreach ($data as $v) {
                $teachers[$v['id']] = $v['user']['realname'];
            }
        }


        # 班级
        $classes = $this->squad->find($id);
        if($classes->teacher_ids){
            $teacherIds = explode(',',$classes->teacher_ids);
            #  获取被选中的老师
            foreach ($teacherIds as $id) {
                $teacher = Teacher::find($id);
                $selectedTeachers[$id] = $teacher->user->realname;
            }
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
        $classIds = User::getClassId();
        if(in_array($id,$classIds)){
            $squad = Squad::find($id);
            if(sizeof($squad->students)!=0){
                return response()->json(['statusCode' => 201]);
            }
            if(sizeof($squad->squadVideos)!=0){
                return response()->json(['statusCode' => 202]);
            }
            return $this->squad->remove($id)
                ? response()->json(['statusCode' => 200]) :
                response()->json(['statusCode' => 400]);
        }else{
            return response()->json(['statusCode' => 404]);

        }

    }


    /**
     * 生成二维码
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeQrcode()
    {
        $id = Request::input('id');
        $class = Squad::find($id);
        $url = 'http://ewm.baiheshequ.cn/qrcodes/class/'.$id;

        # 二维码图片的路径和名称
        $name ='uploads/qrcode/qrcode_'. str_random(5).'_'.$id.'.png';
        QrCode::format('png')->size(250)->generate($url,public_path($name));
        # 原来的二维码是否存在
        $image = '/'.$name;
        $lastImg = $class->code_image;

        $res = $class->update(['code_image'=> $image]);
        if($res){
            if($lastImg && public_path().$lastImg){
                unlink(public_path().$lastImg);
            }
            return response()->json(['statusCode' => 200]);
        }else{
            return response()->json(['statusCode'=> 400]);
        }

    }

}
