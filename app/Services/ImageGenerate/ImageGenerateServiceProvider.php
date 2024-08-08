<?php

namespace App\Services\ImageGenerate;

use App\Services\Generate\Repositories\GenerateRequestRepository;
use App\Services\Generate\Repositories\GenerateResponseRepository;
use App\Services\Generate\Repositories\GenerateServerCacheRepository;
use App\Services\ImageGenerate\Contracts\ImageGenerateContract;
use Illuminate\Support\ServiceProvider;

class ImageGenerateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ImageGenerateApiService::class, fn($app) => new ImageGenerateApiService());

        $this->app->singleton(
            ImageGenerateService::class,
            fn($app) => new ImageGenerateService(
                $app->make(GenerateServerCacheRepository::class),
                $app->make(GenerateRequestRepository::class),
                $app->make(GenerateResponseRepository::class),
                $app->make(ImageGenerateApiService::class),
            )
        );

        $this->app->bind(ImageGenerateContract::class, ImageGenerateService::class);
    }

}
