<?php

namespace App\Providers;

use App\Exceptions\Api\BaseException;
use App\Exceptions\Api\NotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $handler = app('Dingo\Api\Exception\Handler');

        $handler->register(function (BaseException $exception) {
            return $this->exceptionResponse($exception);
        });

        $handler->register(function (NotFoundHttpException $e) {
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                /**@var ModelNotFoundException $previousException */
                $previousException = $e->getPrevious();
                if ($previousException->getModel() === User::class) {
                    $msg = '用户不存在';
                } else {
                    $msg = '资源未找到 - ' . $previousException->getModel();
                }

                throw new NotFoundException($msg);
            }
        });

        $handler->register(function (Throwable $throwable) {
            return $this->exceptionResponse($throwable);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function exceptionResponse(Throwable $exception)
    {
        if ($exception->getCode() == 0) { // 系统抛出的异常 code 为 0, 所以改为 -3
            $errorCode = -3;
        } else {
            $errorCode = $exception->getCode();
        }

        if (!config('app.debug')) {
            return apiError($exception->getMessage(), $errorCode);
        }

        $debug = [
            'line' => $exception->getLine(),
            'file' => $exception->getFile(),
            'tract' => $exception->getTrace(),
        ];

        return apiError($exception->getMessage(), $errorCode, ['debug' => $debug]);
    }
}
