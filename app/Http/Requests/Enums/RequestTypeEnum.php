<?php

namespace App\Http\Requests\Enums;

use AIGenerate\Services\Enums\Traits\GetEnumAttributeTraits;

enum RequestTypeEnum: string
{
    use GetEnumAttributeTraits;

    case Generate     = 'generate';
    case TextToImage  = 'txt2img';
    case ImageToImage = 'img2img';
    case Stock        = 'stock';

    public function getQueue(): string
    {
        return match ($this) {
            self::Generate, self::TextToImage, self::ImageToImage => 'ai-generate-image-generate',
            self::Stock => 'ai-generate-stock-image-generate',
        };
    }
}
