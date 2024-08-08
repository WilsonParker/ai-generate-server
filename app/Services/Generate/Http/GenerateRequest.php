<?php

namespace App\Services\Generate\Http;

use App\Services\Generate\Contracts\GenerateRequestContract;
use App\Services\Generate\Traits\Fillable;

class GenerateRequest implements GenerateRequestContract
{
    use Fillable;

    public function __construct(
        public string $type = '',
        public string $payload = '',
        public string $callback_url = '',
        public int $size = 1,
        public string $image = '',
        public string $prompt = '',
        public string $negative = '',
        public int $width = 512,
        public int $height = 512,
        public string $sampler = 'DPM++ 2M SDE Karras',
        public int $steps = 30,
        public int $seed = -1,
        public float $denoising_strength = 0.75,
        // public int    $image_cfg_scale = 7,
        public $image_cfg_scale = 3.5,
        public int $aged = 0,
        public int $friendly = 0,
        public $alwayson_scripts = null,
    ) {}

    public function getType(): string
    {
        return $this->type;
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

    public function getImage(): string
    {
        return $this->image;
    }

    public function getAged(): int
    {
        return $this->aged;
    }

    public function getFriendly(): int
    {
        return $this->friendly;
    }

    public function getId(): int
    {
        return $this->id ?? 0;
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
