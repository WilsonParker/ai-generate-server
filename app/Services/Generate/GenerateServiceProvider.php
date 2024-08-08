<?php

namespace App\Services\Generate;

use App\Models\Images\ImageGenerateRequest;
use App\Models\Images\ImageGenerateResponse;
use App\Models\Images\ImageGenerateServer;
use App\Services\Generate\Contracts\GenerateRequestRepositoryContract;
use App\Services\Generate\Contracts\GenerateResponseRepositoryContract;
use App\Services\Generate\Contracts\GenerateServerRepositoryContract;
use App\Services\Generate\Repositories\GenerateRequestRepository;
use App\Services\Generate\Repositories\GenerateResponseRepository;
use App\Services\Generate\Repositories\GenerateServerCacheRepository;
use App\Services\Generate\Repositories\GenerateServerRepository;
use Illuminate\Support\ServiceProvider;

class GenerateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            GenerateServerRepository::class,
            fn() => new GenerateServerRepository(ImageGenerateServer::class)
        );
        $this->app->singleton(
            GenerateServerCacheRepository::class,
            fn() => new GenerateServerCacheRepository(ImageGenerateServer::class)
        );
        $this->app->singleton(
            GenerateRequestRepository::class,
            fn() => new GenerateRequestRepository(ImageGenerateRequest::class)
        );
        $this->app->singleton(
            GenerateResponseRepository::class,
            fn() => new GenerateResponseRepository(ImageGenerateResponse::class)
        );

        $this->app->bind(GenerateServerRepositoryContract::class, GenerateServerRepository::class);
        $this->app->bind(GenerateRequestRepositoryContract::class, GenerateRequestRepository::class);
        $this->app->bind(GenerateResponseRepositoryContract::class, GenerateResponseRepository::class);
    }

}
