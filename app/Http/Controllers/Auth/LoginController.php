<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/users/index';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('guest')->except('logout');

    }

    public function login(Request $request) {

        $input = $request->input('input');
        $password = $request->input('password');
        $rememberMe = $request->input('rememberMe') == 'true' ? true : false;
        if (User::whereUsername($input)->first()) {
            $user = User::whereUsername($input)->first();
            $field = 'username';
        } else {
            $mobile = User::whereMobile($input)->first();
            if (!$mobile) {
                return response()->json(['statusCode' => 500]);
            }
            $username = User::whereMobile($input)->first()->username;
            $user = User::whereUsername($username)->first();
            if (
            Auth::attempt(
                ['username' => $username, 'password' => $password],
                $rememberMe
            )
            ) {
                Session::put('user', $user);

                return response()->json([
                    'statusCode' => 200,
                    'url'        => '/',
                ]);
            } else {
                return response()->json(['statusCode' => 500]);
            }
        }
        if (Auth::attempt([$field => $input, 'password' => $password],$rememberMe)) {
            Session::put('user', $user);

            return response()->json([
                'statusCode' => 200,
                'url'        => '/',
            ]);
        }

        return response()->json(['statusCode' => 500]);

    }
}
