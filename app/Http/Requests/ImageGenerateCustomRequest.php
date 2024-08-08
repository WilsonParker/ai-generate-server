<?php

namespace App\Http\Requests;

use App\Http\Requests\Enums\RequestTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class ImageGenerateCustomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                'in:' . implode(',', collect(RequestTypeEnum::cases())->map(fn($type) => $type->value)->toArray()),
            ],
            'callback_url' => [
                'required',
                'url',
            ],
            'payload' => [
                'nullable',
                'string',
            ],
            'size' => [
                'nullable',
                'int',
            ],
            'image' => [
                'required',
                'url',
            ],
            'prompt' => [
                'required',
                'string',
            ],
            'negative' => [
                'required',
                'string',
            ],
            'width' => [
                'nullable',
                'int',
                'min:128',
                'max:2048',
            ],
            'height' => [
                'nullable',
                'int',
                'min:128',
                'max:2048',
            ],
            'sampler' => [
                'nullable',
                'string',
                'in:' . implode(',', [
                    'Euler a',
                    'Euler',
                    'LMS',
                    'Heun',
                    'DPM2',
                    'DPM2 a',
                    'DPM++ 2S a',
                    'DPM++ 2M',
                    'DPM++ SDE',
                    'DPM++ 2M SDE',
                    'DPM fast',
                    'DPM adaptive',
                    'LMS Karras',
                    'DPM2 Karras',
                    'DPM2 a Karras',
                    'DPM++ 2S a Karras',
                    'DPM++ 2M Karras',
                    'DPM++ SDE Karras',
                    'DPM++ 2M SDE Karras',
                    'DDIM',
                ]),
            ],
            'steps' => [
                'nullable',
                'int',
                'min:1',
                'max:100',
            ],
            'seed' => [
                'nullable',
                'int',
            ],
            'image_cfg_scale' => [
                'nullable',
                'numeric',
                'min:1',
                'max:10',
            ],
            'denoising_strength' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1',
            ],
        ];
    }

}
