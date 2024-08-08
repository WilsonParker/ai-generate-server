<?php

use App\Models\Images\Enums\ServerStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('image_generate_server_statuses', function (Blueprint $table) {
            $status = collect(ServerStatusEnum::cases())
                ->map(fn($status) => $status->value)
                ->toArray();
            $table->id();
            $table->enum('status', $status)->default(ServerStatusEnum::Ready->value);
            $table->dateTime('status_changed_at')->default(now());
            $table->foreignIdFor(\App\Models\Images\ImageGenerateServer::class)
                  ->constrained()
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->unique(['image_generate_server_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('image_generate_server_statuses', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Images\ImageGenerateServer::class);
            $table->dropIfExists();
        });
    }
};
