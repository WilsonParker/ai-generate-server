<?php

namespace App\Models\Images\Enums;

enum ServerTypeEnum: string
{
    case Crawler = 'crawler';
    case Generator = 'generator';
}
