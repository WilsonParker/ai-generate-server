<?php

namespace App\Models\Images;

use App\Models\Images\Enums\ServerStatusEnum;
use App\Services\Generate\Contracts\GenerateServerContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageGenerateServer extends Model implements GenerateServerContract
{
    use SoftDeletes;

    protected $fillable = [
        'host',
        'enabled',
    ];

    public function status(): HasOne
    {
        return $this->hasOne(ImageGenerateServerStatus::class);
    }

    public function types(): HasManyThrough
    {
        return $this->hasManyThrough(
            ImageGenerateServerType::class,
            ImageGenerateServerTypePivot::class,
            'image_generate_server_id',
            'code',
            'id',
            'image_generate_server_type_code'
        );
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getId(): int
    {
        return $this->getKey();
    }

    public function isAvailable(): bool
    {
        return $this->status === ServerStatusEnum::Ready->value;
    }
}
