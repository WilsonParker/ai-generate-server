<?php

namespace App\Services\Generate\Enums;

enum ServerTypeEnum: string
{
    case Crawler = 'crawler';
    case Generator = 'generator';
}
