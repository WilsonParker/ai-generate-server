<?php

namespace App\Services\Generate\Contracts;

use App\Services\Generate\Enums\SamplingMethod;
use Illuminate\Http\UploadedFile;

interface ImageToImageServiceContract extends GenerateServiceContract
{
    public function generate(
        string|UploadedFile $image,
        string $prompt,
        ?string $negative,
        int $width,
        int $height,
        SamplingMethod $method = SamplingMethod::DPM_PP_2M_SDE_KARRAS,
        int $step = 20,
        $cfgScale = 7.0,
        $denoisingStrength = 0.75,
        int $seed = -1,
        array $extension = [],
    );

}
