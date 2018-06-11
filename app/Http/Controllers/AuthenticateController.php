<?php

namespace App\Http\Controllers;

use App\Helpers\Api\ApiResponse;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;

class AuthenticateController extends Controller
{
    use AuthenticatesUsers,ApiResponse;

    public $successStatus = 200;
    protected $user;

    public function __construct(User $user)
    {
        $this->middleware('auth:api')->only([
            'logout'
        ]);
        $this->user = $user;
    }

    // 登录用户名标示为username字段
    public function username()
    {
        return 'username';
    }


    /**
     * login api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $this->validate($request, [
            'username'    => 'required',
            'password' => 'required|between:5,64',
        ]);

        $credentials = $this->credentials($request);
        if ($this->guard('api')->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }
        return response()->json(['status'=> 400,'code'=> 400,'message'=>'登陆失败']);

    }



    /**
     * 退出登录
     *
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {

        if (Auth::guard('api')->check()){

            Auth::guard('api')->user()->token()->revoke();

        }

        return $this->message('退出登录成功');

    }

    /**
     * 调用认证接口获取授权码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    protected function authenticateClient(Request $request)
    {
        $credentials = $this->credentials($request);
        # 查询client_id和secret
        $passwordClient = Client::query()->where('password_client',1)->latest()->first();
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $passwordClient['id'],
            'client_secret' => $passwordClient['secret'],
            'username' => $credentials['username'],
            'password' => $credentials['password'],
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );
        $user = User::where('username',$credentials['username'])->first();
        $response = \Route::dispatch($proxy);

        return $this->message(array_merge(json_decode($response->getContent(), true),
            [
                'user_id' => optional($user)->id,
            ]));

    }


    /**
     * 刷新令牌
     *
     * @param Request $request
     * @return mixed
     */
    public function refreshToken(Request $request) {
        $this->validate($request, [
            'refresh_token' => 'required',
        ]);

        # 查询client_id和secret
        $passwordClient = Client::query()->where('password_client',1)->where('id',1)->first();

        $request->request->add([
            'grant_type' => 'refresh_token',
            'client_id' => $passwordClient->id,
            'client_secret' => $passwordClient->secret,
            'refresh_token' => $request->get('refresh_token'),
            'scope' => '',
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = \Route::dispatch($proxy);

        if($response->getStatusCode() >= 300) {
            return $this->failed(json_decode($response->getContent(), true), $response->getStatusCode());
        }

        return $this->message(json_decode($response->getContent(), true));
    }

    protected function authenticated(Request $request)
    {
        return $this->authenticateClient($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($request);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $msg = $request['errors'];
        $code = $request['code'];
        return $this->setStatusCode($code)->failed($msg);
    }



}
