<?php

namespace App\Services\Generate;

use App\Services\Generate\Contracts\GenerateApiContract;
use App\Services\Generate\Contracts\GenerateRequestContract;
use App\Services\Generate\Contracts\GenerateServerContract;
use App\Services\Generate\Exceptions\GenerateException;
use App\Services\Generate\Http\GenerateResponse;
use Illuminate\Support\Facades\Http;

abstract class GenerateApiService implements GenerateApiContract
{
    public function generate(
        GenerateServerContract $server,
        GenerateRequestContract $request,
    ): GenerateResponse {
        $host = $server->getHost();
        $response = Http::post($host . $this->getApiUrl(), $this->getParams($request));
        throw_if($response->failed(), new GenerateException($response->body()));
        return new GenerateResponse(json_decode($response->body(), true));
    }

    abstract protected function getApiUrl(): string;

    protected function getParams(GenerateRequestContract $request): array
    {
        $params = [
            'prompt'              => $request->getPrompt(),
            'negative_prompt'     => $request->getNegative(),
            'width'               => $request->getWidth(),
            'height'              => $request->getHeight(),
            'sampler_name'        => $request->getSampler(),
            'steps'               => $request->getSteps(),
            'seed'                => $request->getSeed(),
            'denoising_strength'  => $request->getDenoisingStrength(),
            'image_cfg_scale'     => $request->getImageCFGScale(),
            "send_images"         => true,
            "save_images"         => false,
            "do_not_save_samples" => true,
            "do_not_save_grid"    => true,
            'payload'             => $request->getImageCFGScale(),
        ];

        if ($request->getAlwaysonScripts()) {
            $params['alwayson_scripts'] = json_decode($request->getAlwaysonScripts(), true);
        }
        return $params;
    }
}
