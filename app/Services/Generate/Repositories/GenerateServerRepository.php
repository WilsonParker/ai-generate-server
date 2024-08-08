<?php

namespace App\Services\Generate\Repositories;

use App\Repositories\BaseRepository;
use App\Services\Generate\Contracts\GenerateServerContract;
use App\Services\Generate\Contracts\GenerateServerRepositoryContract;
use App\Services\Generate\Enums\ServerStatusEnum;
use App\Services\Generate\Enums\ServerTypeEnum;

class GenerateServerRepository extends BaseRepository implements GenerateServerRepositoryContract
{
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
        return $this->model::where('enabled', true)
            ->whereHas('types', fn($query) => $query->where('code', $type->value))
            ->whereRelation('status', fn($query) => $query->where('status', $status->value))
            ->join(
                'image_generate_server_statuses AS status',
                'image_generate_servers.id',
                '=',
                'status.image_generate_server_id'
            )
            ->orderBy('status.updated_at', 'desc')
            ->first();
    }

    public function updateServerStatus(GenerateServerContract $server, ServerStatusEnum $status): bool
    {
        $model = $this->model::findOrFail($server->getId());
        return $model->status()->update([
            'status' => $status->value,
            'status_changed_at' => now(),
        ]);
    }
}
