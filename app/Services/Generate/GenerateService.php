<?php

namespace App\Services\Generate;

use App\Services\Generate\Contracts\GenerateApiContract;
use App\Services\Generate\Contracts\GenerateContract;
use App\Services\Generate\Contracts\GenerateRequestContract;
use App\Services\Generate\Contracts\GenerateRequestRepositoryContract;
use App\Services\Generate\Contracts\GenerateResponseRepositoryContract;
use App\Services\Generate\Contracts\GenerateServerContract;
use App\Services\Generate\Contracts\GenerateServerRepositoryContract;
use App\Services\Generate\Enums\ServerStatusEnum;
use App\Services\Generate\Exceptions\AvailableServerNotFoundException;
use App\Services\Generate\Exceptions\GenerateException;
use App\Services\Generate\Http\GenerateRequest;

class GenerateService implements GenerateContract
{
    public function __construct(
        private readonly GenerateServerRepositoryContract   $generateServerRepository,
        private readonly GenerateRequestRepositoryContract  $generateRequestRepository,
        private readonly GenerateResponseRepositoryContract $generateResponseRepository,
        private readonly GenerateApiContract                $generateApiContract,
    )
    {
    }

    /**
     * @throws \Throwable
     */
    public function getAvailableServer(): GenerateServerContract
    {
        $server = $this->generateServerRepository->getServerByGeneratorAndReady();
        throw_if($server == null, AvailableServerNotFoundException::class);
        return $server;
    }

    public function createRequest(array $params): GenerateRequestContract
    {
        $request = new GenerateRequest();
        $request->fill($params);
        return $this->generateRequestRepository->storeWithRequest($request);
    }

    public function showRequest(int $id): GenerateRequestContract
    {
        return $this->generateRequestRepository->show($id);
    }

    /**
     * @throws \Throwable
     */
    public function generate(GenerateServerContract $server, GenerateRequestContract $request): array
    {
        throw_if(!$server->isAvailable(), AvailableServerNotFoundException::class);
        $this->updateServerStatus($server, ServerStatusEnum::Running);
        try {
            $response = $this->generateApiContract->generate($server, $request);
            $this->updateServerStatus($server, ServerStatusEnum::Complete);
        } catch (\Throwable $throwable) {
            $this->updateServerStatus($server, ServerStatusEnum::Error);
            throw $throwable;
        } finally {
            $this->updateServerStatus($server, ServerStatusEnum::Ready);
        }

        throw_if(isset($result->error), new GenerateException($response->detail));
        $response = $this->generateResponseRepository->storeWithResponse($response, $request, $response->getImages());
        return $response->images->map(fn($image) => $image->getUrl())->toArray();
    }

    public function updateServerStatus(GenerateServerContract $server, ServerStatusEnum $status): void
    {
        $this->generateServerRepository->updateServerStatus($server, $status);
    }

}
