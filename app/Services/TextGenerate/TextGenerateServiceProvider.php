<?php

namespace App\Services\TextGenerate;

use App\Listeners\TextGenerateListener;
use App\Services\Generate\Contracts\GenerateContract;
use App\Services\Generate\Repositories\GenerateRequestRepository;
use App\Services\Generate\Repositories\GenerateResponseRepository;
use App\Services\Generate\Repositories\GenerateServerCacheRepository;
use App\Services\TextGenerate\Contracts\TextGenerateContract;
use Illuminate\Support\ServiceProvider;

class TextGenerateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TextGenerateApiService::class, fn($app) => new TextGenerateApiService());

        $this->app->singleton(
            TextGenerateService::class,
            fn($app) => new TextGenerateService(
                $app->make(GenerateServerCacheRepository::class),
                $app->make(GenerateRequestRepository::class),
                $app->make(GenerateResponseRepository::class),
                $app->make(TextGenerateApiService::class),
            )
        );

        $this->app->bind(TextGenerateContract::class, TextGenerateService::class);

        $this->app->when(TextGenerateListener::class)
            ->needs(GenerateContract::class)
            ->give(TextGenerateService::class);
    }

}
