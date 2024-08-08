<?php

namespace App\Services\Generate\Contracts;

use App\Services\Generate\Enums\ServerStatusEnum;
use App\Services\Generate\Enums\ServerTypeEnum;

interface GenerateServerRepositoryContract
{
    public function getServerByCrawlAndReady(): ?GenerateServerContract;

    public function getServerByGeneratorAndReady(): ?GenerateServerContract;

    public function getServerByTypeAndStatus(
        ServerTypeEnum   $type,
        ServerStatusEnum $status
    ): ?GenerateServerContract;

    public function updateServerStatus(GenerateServerContract $server, ServerStatusEnum $status): bool;
}
