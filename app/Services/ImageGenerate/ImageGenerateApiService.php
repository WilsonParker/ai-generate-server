<?php

namespace App\Services\ImageGenerate;

use App\Services\Generate\Contracts\GenerateRequestContract;
use App\Services\Generate\GenerateApiService;

class ImageGenerateApiService extends GenerateApiService
{
    protected function getApiUrl(): string
    {
        return '/sdapi/v1/img2img';
    }

    protected function getParams(GenerateRequestContract $request): array
    {
        $result = parent::getParams($request);
        $result['init_images'] = [
            base64_encode(file_get_contents($request->getImage())),
        ];
        return $result;
    }

}
