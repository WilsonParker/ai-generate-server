<?php

namespace App\Services\ImageGenerate\Contracts;

use App\Services\Generate\Contracts\GenerateContract;
use App\Services\Generate\Contracts\GenerateRequestContract;

interface ImageGenerateContract extends GenerateContract
{
    public function generateWithLock(GenerateRequestContract $request): array;
    
}
