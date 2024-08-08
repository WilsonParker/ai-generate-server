<?php

namespace App\Models\Images;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ImageGenerateResponse extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $guarded = [];

    public function request(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ImageGenerateRequest::class, 'image_generate_request_id', 'id');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Media::class, 'gallery', 'model_type', 'model_id', 'id');
    }

    public function thumbnail(): MorphOne
    {
        return $this->morphOne(Media::class, 'gallery-thumbnail', 'model_type', 'model_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
             ->useFallbackUrl(config('image-generate.default'))
             ->registerMediaConversions(function (Media $media) {
                 $this
                     ->addMediaConversion('gallery-thumbnail')
                     ->format(Manipulations::FORMAT_WEBP)
                     ->width(368)
                     ->height(232);
             });
    }
}
