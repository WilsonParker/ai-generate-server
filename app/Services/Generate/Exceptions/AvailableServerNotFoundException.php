<?php

namespace App\Services\Generate\Exceptions;

class AvailableServerNotFoundException extends \Exception
{
    protected $message = 'Available server not found';

}
