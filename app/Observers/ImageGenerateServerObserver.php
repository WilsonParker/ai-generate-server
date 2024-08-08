<?php

namespace App\Observers;

use App\Models\Images\ImageGenerateServer;

class ImageGenerateServerObserver
{
    public function created(ImageGenerateServer $model)
    {
        $model->status()->create([
            'image_generate_server_id' => $model->getKey(),
        ]);
    }
}
