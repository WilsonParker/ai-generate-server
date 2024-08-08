<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('image_generate_requests', function (Blueprint $table) {
            $table->unsignedTinyInteger('aged')->nullable(true)->change();
            $table->unsignedTinyInteger('friendly')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('image_generate_requests', function (Blueprint $table) {
            $table->unsignedTinyInteger('aged')->nullable(false)->change();
            $table->unsignedTinyInteger('friendly')->nullable(false)->change();
        });
    }
};
