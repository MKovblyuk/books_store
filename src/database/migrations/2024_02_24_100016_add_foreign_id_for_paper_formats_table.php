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
        Schema::table('paper_formats', function (Blueprint $table) {
            $table->foreignId('book_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paper_formats', function (Blueprint $table) {
            $table->dropForeign('paper_formats_book_id_foreign');
            $table->dropColumn('book_id');
        });
    }
};
