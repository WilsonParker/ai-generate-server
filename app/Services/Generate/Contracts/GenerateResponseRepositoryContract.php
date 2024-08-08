<?php

namespace App\Services\Generate\Contracts;

use Illuminate\Database\Eloquent\Model;

interface GenerateResponseRepositoryContract
{
    public function storeWithResponse(GenerateResponseContract $response, GenerateRequestContract $request, array $images): Model;
}
