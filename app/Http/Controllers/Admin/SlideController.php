<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recommend;
use App\Models\School;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class SlideController extends Controller
{
    protected $slide;
    protected $user;

    function __construct(Slide $slide,User $user) {

        $this->slide = $slide;
        $this->user = $user;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (Request::get('draw')) {
            return response()->json($this->slide->datatable());

        }
        return view('admin.slide.index', [
            'js' => '../js/admin/slide/index.js',
        ]);
    }


    /**
     * 创建表单
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.slide.create', [
            'js' => '../js/admin/slide/create.js',
            'schools' => School::whereEnabled(1)->get()->pluck('name', 'id'),
        ]);
    }


    /**
     * 保存
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store()
    {
        return $this->slide->store(Request::all()) ?
            response()->json(['statusCode' => 200]):
            response()->json(['statusCode' => 400]);

    }

    public function edit($id) {

        $slide = $this->slide->find($id);
        return view('admin.slide.edit', [
            'slide' => $slide,
            'schools' => School::whereEnabled(1)->get()->pluck('name', 'id'),
            'js' => '../../js/admin/slide/edit.js',
        ]);

    }

    /**
     * 更新轮播图
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update( $id)
    {
        return $this->slide->modify(Request::all(),$id) ?
            response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($id) {
        return $this->slide->remove($id)
            ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

}
