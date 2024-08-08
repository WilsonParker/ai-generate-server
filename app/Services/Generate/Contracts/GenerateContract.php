<?php

namespace App\Services\Generate\Contracts;

interface GenerateContract
{
    public function generate(GenerateServerContract $server, GenerateRequestContract $request): array;

    public function showRequest(int $id): GenerateRequestContract;
    
}
