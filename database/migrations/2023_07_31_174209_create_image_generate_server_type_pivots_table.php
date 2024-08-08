<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('image_generate_server_type_pivots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Images\ImageGenerateServer::class)
                  ->constrained(null, 'id', 'image_generate_server_foreign')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Images\ImageGenerateServerType::class)
                  ->constrained(null, 'code', 'image_generate_server_type_foreign')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->unique([
                'image_generate_server_id',
                'image_generate_server_type_code'
            ], 'image_generate_server_pivot_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('image_generate_server_type_pivots', function (Blueprint $table) {
            $table->dropForeign('image_generate_server_foreign');
            $table->dropForeign('image_generate_server_type_foreign');
            $table->dropIfExists();
        });
    }
};
