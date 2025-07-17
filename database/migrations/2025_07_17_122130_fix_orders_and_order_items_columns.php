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
        // Ajouter coupon_discount à la table orders
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('coupon_discount', 8, 2)->nullable()->after('coupon_code');
        });

        // Renommer unit_price en price dans order_items
        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('unit_price', 'price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('coupon_discount');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('price', 'unit_price');
        });
    }
};
