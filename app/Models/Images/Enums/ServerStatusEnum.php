<?php

namespace App\Models\Images\Enums;

enum ServerStatusEnum: string
{
    case Ready = 'ready';
    case Running = 'running';
    case Complete = 'complete';
    case Error = 'error';
}
