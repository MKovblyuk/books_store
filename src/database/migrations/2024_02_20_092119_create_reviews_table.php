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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('rating');
            $table->string('review');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            
            $table->foreignId('book_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('parent_review_id')
                ->constrained('reviews')
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
        Schema::dropIfExists('reviews');
    }
};
