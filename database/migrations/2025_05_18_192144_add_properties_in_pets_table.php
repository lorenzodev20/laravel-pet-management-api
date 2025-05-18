<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('image_url')->nullable();
            $table->string('life_span')->nullable();
            $table->integer('adaptability')->nullable();
            $table->string('reference_image_id')->index('reference_image_id_index')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropIndex('reference_image_id_index');
            $table->dropColumn(['image_url', 'life_span', 'adaptability', 'reference_image_id']);
        });
    }
};
