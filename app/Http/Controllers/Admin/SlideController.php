<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Support\Facades\Request;

class SlideController extends Controller
{
    protected $slide;

    function __construct(Slide $slide) {

        $this->slide = $slide;
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


    public function create()
    {
        return view('admin.school.create', [
            'js' => '../js/admin/school/create.js',
        ]);
    }


    /**
     * 保存学校
     *
     * @param SchoolRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SchoolRequest $request)
    {
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
     */
    public function update(SchoolRequest $request, $id)
    {
        return $this->school->modify($request->all(),$id) ?
            response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

    public function delete($id) {
        return $this->school->remove($id)
            ? response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

}
