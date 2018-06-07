<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;

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
