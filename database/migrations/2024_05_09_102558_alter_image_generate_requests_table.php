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
            $table->json('alwayson_scripts')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('image_generate_requests', function (Blueprint $table) {
            $table->dropColumn('alwayson_scripts');
        });
    }
};
