<?php

namespace App\Models\Images;

use App\Services\Generate\Contracts\GenerateRequestContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageGenerateRequest extends Model implements GenerateRequestContract
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'image',
        'prompt',
        'negative',
        'width',
        'height',
        'sampler',
        'steps',
        'seed',
        'denoising_strength',
        'image_cfg_scale',
        'aged',
        'friendly',
        'callback_url',
        'payload',
        'size',
        'alwayson_scripts',
    ];

    public function response(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ImageGenerateResponse::class, 'image_generate_request_id', 'id');
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getPrompt(): string
    {
        return $this->prompt;
    }

    public function getNegative(): string
    {
        return $this->negative;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getSampler(): string
    {
        return $this->sampler;
    }

    public function getSteps(): int
    {
        return $this->steps;
    }

    public function getSeed(): int
    {
        return $this->seed;
    }

    public function getDenoisingStrength(): float
    {
        return $this->denoising_strength;
    }

    public function getImageCFGScale(): float
    {
        return $this->image_cfg_scale;
    }

    public function getAged()
    {
        return $this->aged;
    }

    public function getFriendly()
    {
        return $this->friendly;
    }

    public function getId(): int
    {
        return $this->getKey();
    }

    public function getCallbackUrl(): string
    {
        return $this->callback_url;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getAlwaysonScripts()
    {
        return $this->alwayson_scripts;
    }
}
