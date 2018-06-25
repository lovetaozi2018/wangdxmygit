<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolRequest;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SchoolController extends Controller
{

    protected $school;

    function __construct(School $school) {
        $this->school = $school;

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->school->datatable());

        }
        return view('admin.school.index', [
            'js' => '../js/admin/school/index.js',
        ]);
    }


    public function create()
    {
        $user = Auth::user();
        $roleId = $user->role_id;

        # 如果是学校管理员
        if($roleId == 2){
            return '你没有权限访问该页面';
        }else{
            return view('admin.school.create', [
                'js' => '../js/admin/school/create.js',
            ]);
        }


    }


    /**
     * 保存学校
     *
     * @param SchoolRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(SchoolRequest $request)
    {
        $mobile = $request->all()['mobile'];
        $user = User::whereMobile($mobile)->first();
        if($user){
            return response()->json(['statusCode' => 201]);
        }
        return $this->school->store($request->all()) ?
            response()->json(['statusCode' => 200]):
            response()->json(['statusCode' => 400]);

    }

    public function edit($id) {

        $school = $this->school->find($id);
        $school->mobile = User::whereSchoolId($id)->first()->mobile;
        $school->realname = User::whereSchoolId($id)->first()->realname;

        return view('admin.school.edit', [
            'school' => $school,
            'js' => '../../js/admin/school/edit.js',
        ]);


    }

    /**
     * 更新学校
     *
     * @param SchoolRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(SchoolRequest $request, $id)
    {
        return $this->school->modify($request->all(),$id) ?
            response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

    /**
     * 删除
     *
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function delete($id) {
        $schoolIds = User::getSchoolId();
        if(in_array($id,$schoolIds)){
            $school = School::find($id);
            $grades = $school->grades;
            # 判断学校下面是否还有年级
            if(sizeof($grades)!=0){
                return response()->json(['statusCode' => 201]);
            }
            if(sizeof($school->schoolVideos)!=0){
                return response()->json(['statusCode' => 202]);
            }
            return $this->school->remove($id)
                ? response()->json(['statusCode' => 200]) :
                response()->json(['statusCode' => 400]);
        }else{
            return response()->json(['statusCode' => 404]);
        }

    }

}
