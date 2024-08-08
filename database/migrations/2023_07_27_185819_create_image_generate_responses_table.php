<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('image_generate_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Images\ImageGenerateRequest::class)
                  ->constrained()
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->json('parameters')->nullable(true);
            $table->json('info')->nullable(true);
            $table->string('errors', 512)->nullable(true);
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['image_generate_request_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image_generate_responses');
    }
};
