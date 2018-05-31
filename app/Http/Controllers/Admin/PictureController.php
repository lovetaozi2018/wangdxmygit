<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use App\Models\Squad;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class PictureController extends Controller
{
    protected $picture;
    protected $user;

    function __construct(Picture $picture,User $user) {
//        $this->middleware(['auth']);
        $this->picture = $picture;
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
            return response()->json($this->picture->datatable());

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
        $classes = Squad::whereEnabled(1)->get()->pluck('name', 'id');
        foreach ($classes as $k=>$c){

        }
        return view('admin.picture.create', [
            'classes' =>  $classes,
            'js' => '../js/admin/picture/create.js',
        ]);
    }


    /**
     * 保存
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $service = $this->picture->store(Request::all());
        return $service ? response()->json(['statusCode'=>200 ]) :
            response()->json(['statusCode'=>400]);
    }

    /**
     * 编辑的表单页面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {

        $service = $this->service->find($id);
        return view('service.edit', [
            'service' => $service,
            'js'    => '../../js/service/edit.js',
        ]);


    }

    /**
     * 更新
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update( $id)
    {
        $res = $this->service->modify(Request::all(),$id);
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
        return $this->service->remove($id)
            ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }
}
