<?php

namespace App\Http\Controllers\Generate;

use App\Events\ImageGenerateRequestEvent;
use App\Events\StockImageGenerateRequestEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Enums\RequestTypeEnum;
use App\Http\Requests\ImageGenerateCustomRequest;
use App\Http\Requests\ImageGeneratePromptRequest;
use App\Http\Requests\ImageGenerateRequest;
use App\Http\Response\Facades\ResponseTemplate;
use App\Services\ImageGenerate\ImageGenerateService;

class ImageGenerateController extends Controller
{

    public function __construct(
        private readonly ImageGenerateService $imageGenerateService,
    ) {}

    public function generate(ImageGenerateRequest $request)
    {
        $validated = $request->validated();
        return $this->transaction(function () use ($validated) {
            $server = $this->imageGenerateService->getAvailableServer();
            $request = new \App\Models\Images\ImageGenerateRequest();
            foreach ($validated as $key => $value) {
                $request->$key = $value;
            }
            return ResponseTemplate::toJson($this->imageGenerateService->generate($server, $request));
        });
    }

    /**
     * img generate 요청을 받습니다.
     * @OA\Post(
     *     path="api/generate/img/queue",
     *     summary="image generate",
     *     tags={"image", "generate"},
     *     @OA\Parameter(
     *         description="generate type",
     *         in="query",
     *         name="type",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="generate", value="generate", summary="generate"),
     *         @OA\Examples(example="stock", value="stock", summary="stock"),
     *     ),
     *     @OA\Parameter(
     *         description="call url after generate completed",
     *         in="query",
     *         name="callback_url",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="http://localhost/callback", value="http://localhost/callback", summary="http://localhost/callback"),
     *     ),
     *     @OA\Parameter(
     *         description="payload",
     *         in="query",
     *         name="payload",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="payload", value="payload", summary="payload"),
     *     ),
     *      @OA\Parameter(
     *          description="image generate count",
     *          in="query",
     *          name="size",
     *          required=false,
     *          @OA\Schema(type="int"),
     *          @OA\Examples(example="1", value="1", summary="1"),
     *      ),
     *     @OA\Parameter(
     *         description="image url",
     *         in="query",
     *         name="image",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="http://exmaple.png", value="http://exmaple.png", summary="http://exmaple.png"),
     *     ),
     *     @OA\Parameter(
     *         description="people count",
     *         in="query",
     *         name="people",
     *         required=true,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="1", value="1", summary="1"),
     *     ),
     *     @OA\Parameter(
     *         description="gender",
     *         in="query",
     *         name="gender",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="man", value="man", summary="man"),
     *     ),
     *     @OA\Parameter(
     *         description="race",
     *         in="query",
     *         name="race",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="caucasian", value="caucasian", summary="caucasian"),
     *     ),
     *     @OA\Parameter(
     *         description="width",
     *         in="query",
     *         name="width",
     *         required=false,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="1024", value="1024", summary="1024"),
     *     ),
     *     @OA\Parameter(
     *         description="height",
     *         in="query",
     *         name="height",
     *         required=false,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="1024", value="1024", summary="1024"),
     *     ),
     *     @OA\Parameter(
     *         description="sampler",
     *         in="query",
     *         name="sampler",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="DPM++ 2M SDE Karras", value="DPM++ 2M SDE Karras", summary="DPM++ 2M SDE Karras"),
     *     ),
     *     @OA\Parameter(
     *         description="steps",
     *         in="query",
     *         name="steps",
     *         required=false,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="30", value="30", summary="30"),
     *     ),
     *     @OA\Parameter(
     *         description="seed",
     *         in="query",
     *         name="seed",
     *         required=false,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="-1", value="-1", summary="-1"),
     *     ),
     *     @OA\Parameter(
     *         description="image_cfg_scale",
     *         in="query",
     *         name="image_cfg_scale",
     *         required=false,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="7", value="7", summary="7"),
     *     ),
     *     @OA\Parameter(
     *         description="denoising_strength",
     *         in="query",
     *         name="denoising_strength",
     *         required=false,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="0.75", value="0.75", summary="0.75"),
     *     ),
     *     @OA\Parameter(
     *         description="lora",
     *         in="query",
     *         name="lora",
     *         required=false,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="1", value="1", summary="1"),
     *     ),
     *     @OA\Parameter(
     *         description="aged",
     *         in="query",
     *         name="aged",
     *         required=false,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="100", value="100", summary="100"),
     *     ),
     *     @OA\Parameter(
     *         description="friendly",
     *         in="query",
     *         name="friendly",
     *         required=false,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="100", value="100", summary="100"),
     *     ),
     *     @OA\Parameter(
     *         description="alwayson_scripts",
     *         in="query",
     *         name="alwayson_scripts",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     * )
     */
    public function queue(ImageGenerateRequest $request)
    {
        $validated = $request->validated();
        return $this->transaction(function () use ($validated) {
            $validated['prompt'] = $this->convertPrompt($validated);
            $validated['negative'] = config('image-generate.negative');
            $request = $this->imageGenerateService->createRequest($validated);
            if (RequestTypeEnum::from($validated['type']) === RequestTypeEnum::Stock) {
                StockImageGenerateRequestEvent::dispatch($request->getKey());
            } else {
                ImageGenerateRequestEvent::dispatch($request->getKey());
            }
            return ResponseTemplate::toJson(null, 'register in queue');
        });
    }

    public function queueFromPrompt(ImageGeneratePromptRequest $request)
    {
        $validated = $request->validated();
        return $this->transaction(function () use ($validated) {
            $validated['negative'] = config('image-generate.negative');
            $request = $this->imageGenerateService->createRequest($validated);
            if (RequestTypeEnum::from($validated['type']) === RequestTypeEnum::Stock) {
                StockImageGenerateRequestEvent::dispatch($request->getKey());
            } else {
                ImageGenerateRequestEvent::dispatch($request->getKey());
            }
            return ResponseTemplate::toJson(null, 'register in queue');
        });
    }

    public function queueCustom(ImageGenerateCustomRequest $request)
    {
        $validated = $request->validated();
        return $this->transaction(function () use ($validated) {
            $request = $this->imageGenerateService->createRequest($validated);
            if (RequestTypeEnum::from($validated['type']) === RequestTypeEnum::Stock) {
                StockImageGenerateRequestEvent::dispatch($request->getKey());
            } else {
                ImageGenerateRequestEvent::dispatch($request->getKey());
            }
            return ResponseTemplate::toJson(null, 'register in queue');
        });
    }

    private function convertPrompt(array $validated)
    {
        $replace = [
            '$lora'   => $validated['lora'],
            '$people' => $validated['people'],
            '$gender' => $validated['gender'],
            '$race'   => $validated['race'],
            '$prompt' => $validated['prompt'],
        ];
        return str_replace(array_keys($replace), array_values($replace), config('image-generate.prompt'));
    }
}
