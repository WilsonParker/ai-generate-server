<?php

namespace App\Services\Generate\Repositories;

use App\Repositories\BaseRepository;
use App\Services\Generate\Contracts\GenerateRequestContract;
use App\Services\Generate\Contracts\GenerateRequestRepositoryContract;
use Illuminate\Database\Eloquent\Model;

class GenerateRequestRepository extends BaseRepository implements GenerateRequestRepositoryContract
{
    public function storeWithRequest(GenerateRequestContract $request): GenerateRequestContract&Model
    {
        return $this->create([
            'type'               => $request->getType(),
            'image'              => $request->getImage(),
            'prompt'             => $request->getPrompt(),
            'negative'           => $request->getNegative(),
            'width'              => $request->getWidth(),
            'height'             => $request->getHeight(),
            'sampler'            => $request->getSampler(),
            'steps'              => $request->getSteps(),
            'seed'               => $request->getSeed(),
            'denoising_strength' => $request->getDenoisingStrength(),
            'image_cfg_scale'    => $request->getImageCFGScale(),
            'callback_url'       => $request->getCallbackUrl(),
            'payload'            => $request->getPayload(),
            'size'               => $request->getSize(),
            'alwayson_scripts'   => $request->getAlwaysonScripts(),
        ]);
    }
}
