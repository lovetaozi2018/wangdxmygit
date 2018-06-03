<?php

namespace App\Http\Controllers\Admin;

use App\Models\Squad;
use App\Models\SquadVideo;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class SquadVideoController extends Controller
{
    protected $video;
    protected $user;

    function __construct(SquadVideo $video, User $user) {
//        $this->middleware(['auth']);
        $this->video = $video;
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
            return response()->json($this->video->datatable());

        }
        return view('admin.class_video.index', [
            'js' => '../js/admin/class_video/index.js',
        ]);
    }

    /**
     * 创建关于我们的表单
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $classes = Squad::whereEnabled(1)->get()->pluck('name', 'id');
        foreach ($classes as $k=>$c){
            $classes[$k] = $c.'--'.Squad::find($k)->grade->school->name;
        }
        return view('admin.class_video.create', [
            'classes' =>  $classes,
            'js' => '../js/admin/class_video/create.js',
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
        echo '<pre>';
        print_r(Request::all());exit;
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

        $picture = $this->picture->find($id);
        $classes = Squad::whereEnabled(1)->get()->pluck('name', 'id');
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
     */
    public function delete($id) {
        return $this->picture->remove($id)
            ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }
}
