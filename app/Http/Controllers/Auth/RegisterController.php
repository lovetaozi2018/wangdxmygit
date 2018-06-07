<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/users/index';
    protected $user;

    /**
     * Create a new controller instance.
     * @param User $user
     */
    public function __construct(User $user) {
        $this->middleware('guest');
        $this->user = $user;

    }

    public function register(RegisterUser $request) {
        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());

    }

    /**
     * 创建用户
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data) {
        return $this->user->create([
            'realname' => $data['realname'],
            'username' => $data['username'],
            'mobile'   => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);

    }
}
