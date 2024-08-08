<?php

namespace App\Services\Generate\Contracts;

interface GenerateRequestContract
{
    public function getId(): int;

    public function getPayload(): string;

    public function getCallbackUrl(): string;

    public function getType(): string;

    public function getSize(): int;

    public function getImage(): string;

    public function getPrompt(): string;

    public function getNegative(): string;

    public function getWidth(): int;

    public function getHeight(): int;

    public function getSampler(): string;

    public function getSteps(): int;

    public function getSeed(): int;

    public function getDenoisingStrength(): float;

    public function getImageCFGScale(): float;

    public function getAged();

    public function getFriendly();

    public function getAlwaysonScripts();

}
