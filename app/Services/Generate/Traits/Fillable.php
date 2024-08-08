<?php

namespace App\Services\Generate\Traits;

trait Fillable
{
    public function fill(array $params)
    {
        foreach ($params as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
