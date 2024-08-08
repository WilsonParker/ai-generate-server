<?php

namespace App\Services\Generate\Http;

use App\Services\Generate\Contracts\GenerateResponseContract;
use App\Services\Generate\Traits\Fillable;

class GenerateResponse implements GenerateResponseContract
{
    use Fillable;

    public $images;
    public $parameters;
    public $init_images;
    public bool $resize_mode;
    public float $denoising_strength;
    public int $image_cfg_scale;
    public $mask;
    public $mask_blur;
    public int $mask_blur_x;
    public int $mask_blur_y;
    public int $inpainting_fill;
    public bool $inpaint_full_res;
    public int $inpaint_full_res_padding;
    public int $inpainting_mask_invert;
    public $initial_noise_multiplier;
    public string $prompt;
    public $styles;
    public int $seed;
    public int $subseed;
    public $subseed_strength;
    public int $seed_resize_from_h;
    public int $seed_resize_from_w;
    public string $sampler_name;
    public int $batch_size;
    public int $n_iter;
    public int $steps;
    public $cfg_scale;
    public $width;
    public $height;
    public $restore_faces;
    public $tiling;
    public bool $do_not_save_samples;
    public bool $do_not_save_grid;
    public string $negative_prompt;
    public $eta;
    public $s_min_uncond;
    public $s_churn;
    public $s_tmax;
    public $s_tmin;
    public $s_noise;
    public $override_settings;
    public bool $override_settings_restore_afterwards;
    public array $script_args;
    public string $sampler_index;
    public bool $include_init_images;
    public $script_name;
    public bool $send_images;
    public bool $save_images;
    public $alwayson_scripts;
    public $info;
    public $error;
    public $detail;
    public $body;
    public $errors;

    public function __construct(array $properties = [])
    {
        foreach ($properties as $key => $value) {
            $this->{$key} = $value;
        }

        if (isset($properties['parameters'])) {
            foreach ($properties['parameters'] as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function getInfo(): string
    {
        return $this->info;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getError(): ?string
    {
        return $this->detail;
    }
}
