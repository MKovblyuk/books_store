<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_address_id_foreign'); 
            $table->dropForeign('orders_shipping_method_id_foreign'); 

            $table->dropIndex('orders_address_id_foreign');
            $table->dropIndex('orders_shipping_method_id_foreign');

            $table->dropColumn(['address_id', 'shipping_method_id']);

            $table->foreignId('delivery_place_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_delivery_place_id_foreign'); 
            $table->dropIndex('orders_delivery_place_id_foreign');
            $table->dropColumn('delivery_place_id');
            
            $table->foreignId('address_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('shipping_method_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }
};
