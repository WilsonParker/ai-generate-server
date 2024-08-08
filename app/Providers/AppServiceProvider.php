<?php

namespace App\Providers;

use App\Http\Response\ResponseTemplate;
use App\Models\Images\ImageGenerateServer;
use App\Observers\ImageGenerateServerObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('responseTemplate', function ($app) {
            return new ResponseTemplate();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        ImageGenerateServer::observe(ImageGenerateServerObserver::class);
    }
}
