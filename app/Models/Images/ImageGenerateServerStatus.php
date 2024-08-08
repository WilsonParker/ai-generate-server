<?php

namespace App\Models\Images;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageGenerateServerStatus extends Model
{
    use SoftDeletes;

    protected $guarded = [];
}
