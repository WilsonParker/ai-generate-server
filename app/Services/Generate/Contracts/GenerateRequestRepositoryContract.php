<?php

namespace App\Services\Generate\Contracts;

use Illuminate\Database\Eloquent\Model;

interface GenerateRequestRepositoryContract
{
    public function storeWithRequest(GenerateRequestContract $request): GenerateRequestContract&Model;

}
