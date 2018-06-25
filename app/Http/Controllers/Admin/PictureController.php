<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Picture;
use App\Models\School;
use App\Models\Squad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class PictureController extends Controller
{
    protected $picture;
    protected $user;
    protected $album;

    function __construct(Picture $picture,User $user,Album $album) {
//        $this->middleware(['auth']);
        $this->picture = $picture;
        $this->user = $user;
        $this->album = $album;

    }

    /**
     * 列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->album->datatable());

        }
        return view('admin.picture.index', [
            'js' => '../js/admin/picture/index.js',
        ]);
    }

    /**
     * 创建关于我们的表单
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

        foreach ($classes as $k=>$c){
            $classes[$k] = $c.'--'.Squad::find($k)->grade->school->name;
        }
        return view('admin.picture.create', [
            'classes' =>  $classes,
            'js' => '../js/admin/picture/create.js',
        ]);
    }


    /**
     * 保存图片
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store()
    {
        $pictures = $this->picture->store(Request::all());
        return $pictures ? response()->json(['statusCode'=>200 ]) :
            response()->json(['statusCode'=>400]);
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
        if ($roleId == 2) {
            $schoolId = $user->school_id;
            $school = School::find($schoolId);
            $grades = $school->grades;
            $classIds = [];
            foreach ($grades as $k => $g) {
                if ($g->squads) {
                    foreach ($g->squads as $s) {
                        $classIds[] = $s->id;
                    }
                }
            }
            $classes = Squad::whereEnabled(1)->whereIn('id', $classIds)->get()->pluck('name', 'id');

        } else {
            $classes = Squad::whereEnabled(1)->get()->pluck('name', 'id');
        }

        $picture = $this->picture->find($id);
        $picture->name = $picture->album->name;
        foreach ($classes as $k=>$c){
            $classes[$k] = $c.'--'.Squad::find($k)->grade->school->name;
        }
        return view('admin.picture.edit', [
            'picture' =>  $picture,
            'classes' =>  $classes,
            'js'    => '../../js/admin/picture/edit.js',
        ]);


    }

    /**
     * 更新
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update( $id)
    {
        $res = $this->picture->modify(Request::all(),$id);
        return $res ? response()->json(['statusCode'=>200 ]) :
            response()->json(['statusCode'=>400]);
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($id) {
        return $this->picture->remove($id)
            ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

    /**
     * 详情
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $album = Album::find($id);
        $pictures = Picture::whereAlbumId($album->id)
            ->where('class_id',$album->class_id)
            ->get();
        return view('admin.picture.detail', [
            'album' => $album,
            'pictures' =>$pictures,
            'js' => '../../js/admin/picture/detail.js',
        ]);
    }
}
