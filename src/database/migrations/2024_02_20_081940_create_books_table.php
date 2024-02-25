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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name', 75);
            $table->string('description', 1200);
            $table->year('publication_year');
            $table->string('language', 50);
            $table->string('cover_image_url')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->foreignId('publisher_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
                
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
