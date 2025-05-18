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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->nullable(false);
            $table->string('species')->index()->nullable(false);
            $table->string('breed')->index()->nullable(false);
            $table->decimal('age')->nullable(false);
            $table->timestamps();

            $table->foreignId('person_id')->constrained(table: 'people');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
