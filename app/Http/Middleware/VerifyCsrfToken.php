<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/login',
        'api/schoolVideo/hints',
        'api/schoolVideo/store',
        'api/squadVideo/hints',
        'api/squadVideo/store',
        'api/schoolmate/store',
        'api/users/index',
        'api/users/userInfo',
        'api/users/myPictures',
        'api/users/uploadHead',
        'api/users/uploadBack',
        'api/users/update',
        'api/users/messages',
        'api/users/reset',
    ];
}
