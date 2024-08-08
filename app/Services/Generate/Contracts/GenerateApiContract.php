<?php

namespace App\Services\Generate\Contracts;

interface GenerateApiContract
{
    public function generate(GenerateServerContract $server, GenerateRequestContract $request): GenerateResponseContract;
}
