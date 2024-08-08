<?php

namespace App\Models\Images;

use Illuminate\Database\Eloquent\Model;

class ImageGenerateServerType extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    protected $guarded = [];
}
