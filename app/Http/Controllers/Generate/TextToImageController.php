<?php

namespace App\Http\Controllers\Generate;

use App\Events\TextGenerateRequestEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\TextToImageRequest;
use App\Http\Response\Facades\ResponseTemplate;
use App\Services\TextGenerate\Contracts\TextGenerateContract;

class TextToImageController extends Controller
{

    public function __construct(
        private readonly TextGenerateContract $textGenerateServiceContract,
    ) {}


    /**
     * text2image generate 요청을 받습니다.
     * @OA\Post(
     *     path="api/generate/text2image/queue",
     *     summary="text generate",
     *     tags={"text", "generate"},
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
     *     @OA\Parameter(
     *          description="prompt",
     *          in="query",
     *          name="prompt",
     *          required=true,
     *          @OA\Schema(type="string"),
     *      ),
     *     @OA\Parameter(
     *          description="negative",
     *          in="query",
     *          name="negative",
     *          required=true,
     *          @OA\Schema(type="string"),
     *      ),
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
     *         description="denoising_strength",
     *         in="query",
     *         name="denoising_strength",
     *         required=false,
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="0.75", value="0.75", summary="0.75"),
     *     ),
     *     @OA\Parameter(
     *          description="alwayson_scripts",
     *          in="query",
     *          name="alwayson_scripts",
     *          required=false,
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     * )
     */
    public function queue(TextToImageRequest $request)
    {
        $validated = $request->validated();
        return $this->transaction(function () use ($validated) {
            $request = $this->textGenerateServiceContract->createRequest($validated);
            TextGenerateRequestEvent::dispatch($request->getKey());
            return ResponseTemplate::toJson(null, 'register in queue');
        });
    }

}
