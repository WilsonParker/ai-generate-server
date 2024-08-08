<?php

namespace App\Providers;

use App\Events\ImageGenerateRequestEvent;
use App\Events\StockImageGenerateRequestEvent;
use App\Events\TextGenerateRequestEvent;
use App\Listeners\ImageGenerateListener;
use App\Listeners\StockImageGenerateListener;
use App\Listeners\TextGenerateListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ImageGenerateRequestEvent::class => [
            ImageGenerateListener::class,
        ],
        StockImageGenerateRequestEvent::class => [
            StockImageGenerateListener::class,
        ],
        TextGenerateRequestEvent::class => [
            TextGenerateListener::class,
        ],
    ];

    protected $subscribe = [];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
