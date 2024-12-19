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
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedInteger('likes');
            $table->unsignedInteger('selling_count');

            $table->index('likes');
            $table->index('selling_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex(['likes']);
            $table->dropIndex(['selling_count']);

            $table->dropColumn('likes');
            $table->dropColumn('selling_count');
        });
    }
};
