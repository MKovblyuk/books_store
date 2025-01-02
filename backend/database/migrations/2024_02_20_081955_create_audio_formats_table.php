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
        Schema::create('audio_formats', function (Blueprint $table) {
            $table->id();
            $table->decimal('price')->default(0)->unsigned();
            $table->decimal('discount')->default(0)->unsigned()->max(100);
            $table->integer('duration')->unsigned();
            $table->string('path')->nullable();

            $table->foreignId('book_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audio_formats');
    }
};
