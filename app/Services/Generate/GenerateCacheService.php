<?php

namespace App\Services\Generate;

use App\Services\Generate\Contracts\GenerateApiContract;
use App\Services\Generate\Contracts\GenerateContract;
use App\Services\Generate\Contracts\GenerateRequestContract;
use App\Services\Generate\Contracts\GenerateServerContract;
use App\Services\Generate\Contracts\GenerateServerRepositoryContract;
use App\Services\Generate\Enums\ServerStatusEnum;
use App\Services\Generate\Exceptions\AvailableServerNotFoundException;
use App\Services\Generate\Exceptions\GenerateException;
use App\Services\Generate\Http\GenerateRequest;
use App\Services\Generate\Repositories\GenerateRequestRepository;
use App\Services\Generate\Repositories\GenerateResponseRepository;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GenerateCacheService implements GenerateContract
{
    public function __construct(
        private readonly GenerateServerRepositoryContract $imageGenerateServerRepository,
        private readonly GenerateRequestRepository $imageGenerateRequestRepository,
        private readonly GenerateResponseRepository $imageGenerateResponseRepository,
        private readonly GenerateApiContract $imageGenerateApiContract,
    ) {}

    /**
     * @throws \Throwable
     */
    public function getAvailableServer(): GenerateServerContract
    {
        $server = $this->imageGenerateServerRepository->getServerByGeneratorAndReady();
        throw_if($server == null, AvailableServerNotFoundException::class);
        return $server;
    }

    public function createRequest(array $params): Model
    {
        $request = new GenerateRequest();
        $request->fill($params);
        return $this->imageGenerateRequestRepository->storeWithRequest($request);
    }

    public function showRequest(int $id): GenerateRequestContract
    {
        return $this->imageGenerateRequestRepository->show($id);
    }

    /**
     * @throws \Throwable
     */
    public function generate(GenerateServerContract $server, GenerateRequestContract $request): array
    {
        throw_if(!$server->isAvailable(), AvailableServerNotFoundException::class);
        $this->updateServerStatus($server, ServerStatusEnum::Running);
        $response = $this->callGenerate($server, $request);
        return $response->images->map(fn($image) => $image->getUrl())->toArray();
    }

    public function updateServerStatus(GenerateServerContract $server, ServerStatusEnum $status): void
    {
        $this->imageGenerateServerRepository->updateServerStatus($server, $status);
    }

    /**
     * @throws \Throwable
     */
    public function generateWithLock(GenerateRequestContract $request): array
    {
        try {
            // Attempt to acquire a lock named "resource-lock" with a timeout of 10 seconds.
            $lock = Cache::lock('resource-lock', 10);
            $lock->block(3);
            $server = $this->imageGenerateServerRepository->getServerByGeneratorAndReady();
            throw_if($server == null || !$server->isAvailable(), AvailableServerNotFoundException::class);
            $this->updateServerStatus($server, ServerStatusEnum::Running);
            $lock->release();

            $response = $this->callGenerate($server, $request);
            return $response->images->map(fn($image) => $image->getUrl())->toArray();
        } catch (LockTimeoutException $e) {
            // Handle the case where the lock acquisition times out.
            throw $e;
        } finally {
            // Release the lock (whether it was acquired or not).
            $lock?->release();
        }
    }

    /**
     * @throws \Throwable
     */
    private function callGenerate(GenerateServerContract $server, GenerateRequestContract $request)
    {
        try {
            $response = $this->imageGenerateApiContract->generate($server, $request);
            $this->updateServerStatus($server, ServerStatusEnum::Complete);
        } catch (\Throwable $throwable) {
            $this->updateServerStatus($server, ServerStatusEnum::Error);
            throw $throwable;
        } finally {
            $this->updateServerStatus($server, ServerStatusEnum::Ready);
        }
        throw_if(isset($response->error), new GenerateException(json_encode($response->detail)));
        return $this->imageGenerateResponseRepository->storeWithResponse($response, $request, $response->getImages());
    }

}
