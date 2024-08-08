<?php

namespace App\Console\Commands;

use App\Services\ImageGenerate\Repositories\ImageGenerateServerCacheRepository;
use Illuminate\Console\Command;

class RestoreServerCacheCommand extends Command
{
    protected $signature = 'restore:server-cache';

    protected $description = 'Command description';

    public function handle(): void
    {
        $repository = app()->make(ImageGenerateServerCacheRepository::class);
        $repository->storeServers();
    }
}
