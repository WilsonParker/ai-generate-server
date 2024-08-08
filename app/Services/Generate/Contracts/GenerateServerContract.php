<?php

namespace App\Services\Generate\Contracts;

interface GenerateServerContract
{
    public function getId(): int;

    public function getHost(): string;

    public function isAvailable(): bool;
}
