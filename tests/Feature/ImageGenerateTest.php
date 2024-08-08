<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Images\Enums\ServerStatusEnum;
use App\Services\ImageGenerate\Http\ImageGenerateRequest;
use App\Services\ImageGenerate\ImageGenerateService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageGenerateTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     */
    public function test_image_generate_successful(): void
    {
        $this->createApplication();
        /**
         * @var ImageGenerateService $service
         */
        $service = app()->make(ImageGenerateService::class);
        $server = $service->getAvailableServer();

        $image = base64_encode(Storage::get('public/00005-4188636796.png'));
        $request = new ImageGenerateRequest(
            image             : $image,
            prompt            : "Pretty smile, fair hair, lightly dressed, happy with the camera, looking happy. Shot of a beautiful Caucasian woman looking lonely over a studio wall, blond hair, 1girl, caucasian, RAW photo, (high detailed skin:1.2), 8k uhd, dslr, soft lighting, high quality, film grain, <lora:vodka_portraits:0.8>",
            negative          : "(deformed iris, deformed pupils, semi-realistic, cgi, 3d, render, sketch, cartoon, drawing, anime:1.4), text, close up, cropped, out of frame, worst quality, low quality, jpeg artifacts, ugly, duplicate, morbid, mutilated, extra fingers, mutated hands, poorly drawn hands, poorly drawn face, mutation, deformed, blurry, dehydrated, bad anatomy, bad proportions, extra limbs, cloned face, disfigured, gross proportions, malformed limbs, missing arms, missing legs, extra arms, extra legs, fused fingers, too many fingers, long neck, poorly drawn, wrong anatomy, extra limb, missing limb, floating limbs, disconnected limbs, mutated, disgusting, amputation, NSFW, NUDE, weird smart phone, weird mobile",
            sampler           : "DPM++ 2M SDE Karras",
            width             : 1024,
            height            : 768,
            steps             : 30,
            denoising_strength: 0.75,
            image_cfg_scale   : 7,
            seed              : "-1",
            aged              : 100,
            friendly          : 100,
        );
        $result = $service->generate($server, $request);
        $service->updateServerStatus($server, ServerStatusEnum::Ready);
        dump($result);
        $this->assertIsArray($result);
    }
}
