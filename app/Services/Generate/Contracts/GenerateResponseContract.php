<?php

namespace App\Services\Generate\Contracts;

interface GenerateResponseContract
{
    public function getImages(): array;

    public function getInfo(): string;

    public function getParameters(): array;

    public function getError(): ?string;

}
