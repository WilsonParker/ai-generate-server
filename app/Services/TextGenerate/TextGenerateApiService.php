<?php

namespace App\Services\TextGenerate;

use App\Services\Generate\GenerateApiService;

class TextGenerateApiService extends GenerateApiService
{
    protected function getApiUrl(): string
    {
        return '/sdapi/v1/txt2img';
    }

}
