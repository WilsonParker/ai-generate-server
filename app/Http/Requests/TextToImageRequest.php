<?php

namespace App\Http\Requests;

use App\Http\Requests\Enums\RequestTypeEnum;
use App\Services\Generate\Enums\SamplingMethod;
use Illuminate\Foundation\Http\FormRequest;

class TextToImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'               => [
                'required',
                'string',
                'in:' . implode(',', RequestTypeEnum::getEnumAttributeValues()->toArray()),
            ],
            'callback_url'       => [
                'required',
                'url',
            ],
            'payload'            => [
                'nullable',
                'string',
            ],
            'prompt'             => [
                'required',
                'string',
            ],
            'negative'           => [
                'required',
                'string',
            ],
            'width'              => [
                'nullable',
                'int',
                'min:128',
                'max:2048',
            ],
            'height'             => [
                'nullable',
                'int',
                'min:128',
                'max:2048',
            ],
            'sampler'            => [
                'nullable',
                'string',
                'in:' . implode(',', SamplingMethod::getEnumAttributeValues()->toArray()),
            ],
            'steps'              => [
                'nullable',
                'int',
                'min:1',
                'max:100',
            ],
            'seed'               => [
                'nullable',
                'int',
            ],
            'denoising_strength' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1',
            ],
            'alwayson_scripts'   => [
                'nullable',
                'json',
            ],
        ];
    }

}
