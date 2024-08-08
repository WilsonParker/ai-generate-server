<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('image_generate_server_types', function (Blueprint $table) {
            $table->string('code', 24)->primary();
            $table->string('description', 256);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image_generate_server_types');
    }
};
