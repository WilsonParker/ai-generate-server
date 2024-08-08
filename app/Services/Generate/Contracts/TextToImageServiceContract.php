<?php

namespace App\Services\Generate\Contracts;


use App\Services\Generate\Enums\SamplingMethod;

interface TextToImageServiceContract extends GenerateServiceContract
{
    public function generate(
        string $prompt,
        ?string $negative,
        int $width,
        int $height,
        SamplingMethod $method = SamplingMethod::DPM_PP_2M_SDE_KARRAS,
        int $step = 20,
        $cfgScale = 7.0,
        int $seed = -1,
        array $extension = [],
    );

}
