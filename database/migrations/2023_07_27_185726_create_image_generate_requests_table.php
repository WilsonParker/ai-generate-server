<?php

use App\Http\Requests\Enums\RequestTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('image_generate_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('type', collect(RequestTypeEnum::cases())->map(fn($type) => $type->value)->toArray())
                ->nullable(false)
                ->comment('request type');
            $table->string('callback_url', 512)->nullable(false)->comment('callback url');
            $table->text('payload')->nullable(false)->comment('payload');
            $table->unsignedTinyInteger('size')->nullable(false)->default(1)->comment('generate image count');
            $table->string('image', 512)->nullable(true)->comment('image url');
            $table->text('prompt')->nullable(false);
            $table->text('negative')->nullable(false);
            $table->unsignedSmallInteger('width')->nullable(false);
            $table->unsignedSmallInteger('height')->nullable(false);
            $table->string('sampler', 32)->nullable(false);
            $table->unsignedTinyInteger('steps')->nullable(false);
            $table->double('image_cfg_scale', 10, 2, true)->nullable(false);
            $table->double('denoising_strength', 10, 2, true)->nullable(false);
            $table->integer('seed')->nullable(false);
            $table->unsignedTinyInteger('aged')->nullable(false)->comment('높을 수록 점, 주름 등이 선명해진다');
            $table->unsignedTinyInteger('friendly')->nullable(false)->comment('낮을수록 원본의 표정이나 자세와 비슷해진다');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image_generate_requests');
    }
};
