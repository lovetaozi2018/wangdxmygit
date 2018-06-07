<?php

namespace App\Helpers\Api;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionReport
{
    use ApiResponse;

    /**
     * @var Exception
     */
    public $exception;
    /**
     * @var Request
     */
    public $request;

    /**
     * @var
     */
    protected $report;

    protected $errors;

    /**
     * ExceptionReport constructor.
     * @param Request $request
     * @param Exception $exception
     */
    function __construct(Request $request, Exception $exception)
    {
        $this->request = $request;
        $this->exception = $exception;
        $this->errors = method_exists($exception, 'errors') ? json_encode($exception->errors()) : '';
    }

    protected function doReport() {
        return [
            AuthenticationException::class => ['未授权',401],
            ModelNotFoundException::class => ['数据不存在',404],
            NotFoundHttpException::class => ['Api请求不存在', 404],
            MethodNotAllowedHttpException::class => ['Api请求方法不正确', 405],
            ValidationException::class => [[$this->exception->getMessage(), $this->errors], 422],
            MethodNotFoundException::class => ['请求方法不存在', 405],
        ];
    }

    /**
     * @return bool
     */
    public function shouldReturn(){

        if (! ($this->request->wantsJson() || $this->request->ajax())){
            return false;
        }

        foreach (array_keys($this->doReport()) as $report){

            if ($this->exception instanceof $report){

                $this->report = $report;
                return true;
            }
        }

        return false;
    }

    /**
     * @param Exception $e
     * @return static
     */
    public static function make(Exception $e){

        return new static(\request(),$e);
    }

    /**
     * @return mixed
     */
    public function report(){

        $message = $this->doReport()[$this->report];

        return $this->failed($message[0],$message[1]);

    }

}