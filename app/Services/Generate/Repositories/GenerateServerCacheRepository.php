<?php

namespace App\Services\Generate\Repositories;

use App\Repositories\BaseRepository;
use App\Services\Generate\Contracts\GenerateServerContract;
use App\Services\Generate\Contracts\GenerateServerRepositoryContract;
use App\Services\Generate\Enums\ServerStatusEnum;
use App\Services\Generate\Enums\ServerTypeEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GenerateServerCacheRepository extends BaseRepository implements GenerateServerRepositoryContract
{

    private string $cacheKey = 'generate_servers';

    public function getServerByCrawlAndReady(): ?GenerateServerContract
    {
        return $this->getServerByTypeAndStatus(ServerTypeEnum::Crawler, ServerStatusEnum::Ready);
    }

    public function getServerByGeneratorAndReady(): ?GenerateServerContract
    {
        return $this->getServerByTypeAndStatus(ServerTypeEnum::Generator, ServerStatusEnum::Ready);
    }

    public function getServerByTypeAndStatus(
        ServerTypeEnum   $type,
        ServerStatusEnum $status
    ): ?GenerateServerContract
    {
        return $this->getServers()
            ->filter(fn($item) => $item->status === $status->value)
            ->filter(fn($item) => $item->types->first(fn($sub) => $sub->code === $type->value) !== null)
            ->sortBy(fn($item) => $item->status_changed_at)
            ->first();
    }

    public function updateServerStatus(GenerateServerContract $server, ServerStatusEnum $status): bool
    {
        $servers = $this->getServers();
        if (isset($servers[$server->getKey()])) {
            $server = $servers[$server->getKey()];
            $server->status = $status->value;
            $server->status_changed_at = now();
            $servers[$server->getKey()] = $server;
            Cache::put($this->cacheKey, $servers, now()->addHour());
            return true;
        } else {
            $this->storeServers();
            return false;
        }
    }

    private function getServers(): Collection
    {
        if (!Cache::has($this->cacheKey)) {
            $this->storeServers();
        }
        return Cache::get($this->cacheKey);
    }

    public function storeServers(): void
    {
        $servers = $this->model::with('types')
            ->where('enabled', true)
            ->get()
            ->mapWithKeys(function ($item) {
                $item->status = 'ready';
                return [
                    $item->getKey() => $item,
                ];
            });

        if (Cache::has($this->cacheKey)) {
            Cache::put($this->cacheKey, $servers, now()->addHour());
        } else {
            Cache::add($this->cacheKey, $servers, now()->addHour());
        }
    }

}
