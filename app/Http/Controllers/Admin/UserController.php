<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    protected $user;

    function __construct(User $user) {
//        $this->middleware(['auth']);
        $this->user = $user;

    }


    public function index()
    {

        if (Request::get('draw')) {
            return response()->json($this->user->datatable());

        }
        return view('admin.user.index', [
            'js' => '../js/admin/user/index.js',
        ]);
    }

    public function edit($id) {
        if(Auth::user()->role_id == 2){
            if($id != Auth::id()){
                return '你没有权限访问此页面!';
            }
        }
        $user = $this->user->find($id);
        return view('admin.user.edit', [
            'user' => $user,
            'js' => '../../js/admin/user/edit.js',
        ]);

    }

    /**
     * 更新管理员
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UserRequest $request,$id)
    {
        $data = $request->all();
        $user = User::whereMobile($data['mobile'])
            ->where('id','!=',$id)
            ->first();
        if($user){
            return response()->json(['status'=>201]);
        }
        return $this->user->updateUser($data,$id) ?
            response()->json(['statusCode' => 200]) :
            response()->json(['statusCode' => 400]);
    }

    public function delete($id)
    {

    }


    /**
     * 修改密码
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function reset()
    {
        if (Request::isMethod('post')) {
            $password = Request::input('password');
            $pwd = bcrypt(Request::input('pwd'));
            $user = User::find(Auth::id());

            if (!\Hash::check($password,$user->password)) {
                return response()->json(['statusCode' => 400]);
            }
            $res = $user->update(['password' => $pwd]);
            if ($res) {
                return response()->json(['statusCode' => 200]);
            }
        }

        return view('admin.user.reset',[
            'user'=> Auth::user(),
            'js' => '../js/admin/user/reset.js',
        ]);
    }
}
