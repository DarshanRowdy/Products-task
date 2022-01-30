<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Psy\Util\Json;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function _errorMessage($responseCode = 400, $message = 'Bad Request'){
        $body = Json::encode(
            array(
                "success" => false,
                "responseCode" => $responseCode,
                'message' => $message
            )
        );
        echo $body;die;
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            $this->_errorMessage(404, 'Page Not Found');
        });

        $this->renderable(function (ModelNotFoundException $e, $request) {
            $this->_errorMessage(404, 'Data Not Found');
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            $this->_errorMessage(405, 'Method is not allowed for the requested route');
        });
    }
}
