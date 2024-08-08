<?php

namespace App\Services\Generate\Repositories;

use App\Repositories\BaseRepository;
use App\Services\Generate\Contracts\GenerateRequestContract;
use App\Services\Generate\Contracts\GenerateResponseContract;
use App\Services\Generate\Contracts\GenerateResponseRepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GenerateResponseRepository extends BaseRepository implements GenerateResponseRepositoryContract
{
    public function storeWithResponse(
        GenerateResponseContract $response,
        GenerateRequestContract  $request,
        array                    $images,
    ): Model {
        $model = $this->create(
            [
                'image_generate_request_id' => $request->getId(),
                'info' => $response->getInfo(),
                'parameters' => json_encode($response->getParameters()),
                'errors' => $response->getError(),
            ]);
        foreach ($images as $image) {
            $model->addMediaFromBase64($image)
                  ->usingFileName(Str::random(40) . '.png')
                  ->toMediaCollection('gallery');
        }
        return $model;
    }

}
