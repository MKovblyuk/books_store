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
        Schema::create('paper_formats', function (Blueprint $table) {
            $table->id();
            $table->decimal('price');
            $table->decimal('discount')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('page_count');
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
        Schema::dropIfExists('paper_formats');
    }
};
