<?php

namespace App\Listeners;

use App\Http\Traits\TransactionTraits;
use App\Services\Generate\Contracts\GenerateRequestContract;
use App\Services\Generate\Exceptions\AvailableServerNotFoundException;
use App\Services\Generate\Exceptions\GenerateLockException;
use App\Services\ImageGenerate\Contracts\ImageGenerateContract;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class ImageGenerateListener implements ShouldQueue
{
    use InteractsWithQueue, TransactionTraits;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'ai-generate-image-generate';
    public $tries = 3;
    public $afterCommit = true;

    public $end;
    // minutes
    public $time = 10;


    public function __construct(private readonly ImageGenerateContract $service) {}

    #[NoReturn]
    public function handle($event): void
    {
        $this->end = now()->addMinutes($this->time);
        $this->run($this->service->showRequest($event->id), $event->id);
    }

    /**
     * @throws \Throwable
     * @throws \App\Services\Generate\Exceptions\AvailableServerNotFoundException
     */
    protected function run(GenerateRequestContract $request, int $id)
    {
        try {
            $this->generate($request);
        } catch (Throwable $throwable) {
            if (now()->greaterThan($this->end)) {
                Http::post(
                    $request->getCallbackUrl(),
                    [
                        'status'  => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                        'message' => $throwable->getMessage(),
                    ],
                );

                throw $throwable;
            }
            if ($throwable instanceof AvailableServerNotFoundException
                || $throwable instanceof ConnectException
                || $throwable instanceof ConnectionException
                || $throwable instanceof GenerateLockException
                || $throwable instanceof LockTimeoutException
            ) {
                sleep(2);
                $this->run($request, $id);
            } else {
                throw $throwable;
            }
        }
    }

    protected function generate(GenerateRequestContract $request)
    {
        $result = $this->service->generateWithLock($request);
        Http::post(
            $request->getCallbackUrl(),
            [
                'status' => ResponseAlias::HTTP_OK,
                'data'   => [
                    'result'  => $result,
                    'payload' => $request->getPayload(),
                ],
            ],
        );
        return;
        /*$server = $this->service->getAvailableServer();
        $result = $this->service->generate($server, $request);
        Http::post(
            $request->getCallbackUrl(),
            [
                'status' => ResponseAlias::HTTP_OK,
                'data' => [
                    'result' => $result,
                    'payload' => $request->getPayload(),
                ],
            ]
        );*/
    }

}
