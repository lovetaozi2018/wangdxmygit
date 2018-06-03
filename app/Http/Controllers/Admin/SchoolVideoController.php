<?php

namespace App\Http\Controllers\Admin;

use App\Models\School;
use App\Models\SchoolVideo;
use App\Models\Squad;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class SchoolVideoController extends Controller
{
    protected $schoolVideo;
    protected $user;

    function __construct(SchoolVideo $schoolVideo, User $user) {
        $this->schoolVideo = $schoolVideo;
        $this->user = $user;

    }

    /**
     * 列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->schoolVideo->datatable());

        }
        return view('admin.school_video.index', [
            'js' => '../js/admin/school_video/index.js',
        ]);
    }

    /**
     * 创建学校视频的表单
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.school_video.create', [
            'schools' =>  School::whereEnabled(1)->get()->pluck('name', 'id'),
            'js' => '../js/admin/school_video/create.js',
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

        $pictures = $this->schoolVideo->store(Request::all());
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

        $schoolVideo = $this->schoolVideo->find($id);
        return view('admin.school_video.edit', [
            'schoolVideo' =>  $schoolVideo,
            'schools' =>  School::whereEnabled(1)->get()->pluck('name', 'id'),
            'js'    => '../../js/admin/school_video/edit.js',
        ]);


    }


    /**
     * 更新视频
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $res = $this->schoolVideo->modify(Request::all(),$id);
        return $res ? response()->json(['statusCode'=>200 ]) :
            response()->json(['statusCode'=>400]);
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        return $this->schoolVideo->remove($id)
            ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }
}
