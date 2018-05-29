<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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


    public function create()
    {
        return view('admin.slide.create', [
            'js' => '../js/admin/slide/create.js',
            'schools' => School::whereEnabled(1)->get()->pluck('name', 'id'),
        ]);
    }



    public function store()
    {
       $file = Request::file('fileImg');
       $input = Request::all();
       $path = public_path().'/uploads/picture/';
       foreach ($file as $v){
           $image = $this->user->uploadedMedias($v,$path);
           $data = [
               'school_id'=> $input['school_id'],
               'path'=> $image['filename'],
               'enabled'=> $input['enabled'],
           ];
           Slide::create($data);
       }
//        return $this->slide->store($request->all()) ?
//            response()->json(['statusCode' => 200]):
//            response()->json(['statusCode' => 400]);

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
