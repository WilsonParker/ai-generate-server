<?php

namespace App\Exceptions;

use AIGenerate\Services\Exceptions\Facades\ExceptionCodeService;
use AIGenerate\Services\Exceptions\Loggers\Contracts\ExceptionServiceContract;
use App\Http\Response\Facades\ResponseTemplate;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $throwable) {
            $service = app()->make(ExceptionServiceContract::class);
            $service->log($throwable);
        });

        $this->renderable(function (Throwable $throwable) {
            return ResponseTemplate::toJson(
                null,
                Str::limit($throwable->getMessage(), 256),
                ExceptionCodeService::getCode($throwable),
            );
        });
    }
}
