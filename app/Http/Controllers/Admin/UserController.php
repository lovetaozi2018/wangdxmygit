<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
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
            'js' => '../js/user/index.js',
        ]);
    }
}
