<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $e
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof HttpException) {
            return new JsonResponse([
                'message' => $e->getMessage() ?: $this->getMessageFromClassName($e),
            ], $e->getStatusCode());
        }

        return parent::render($request, $e);
    }

    /**
     * Get Message From Class Name.
     *
     * @param HttpException $e
     *
     * @return string
     */
    protected function getMessageFromClassName(HttpException $e)
    {
        $class = get_class($e);
        $file = Arr::last(explode('\\', $class));

        return Str::snake(str_ireplace(
            ['HttpException', 'Exception'],
            ['', ''],
            $file
        ));
    }
}
