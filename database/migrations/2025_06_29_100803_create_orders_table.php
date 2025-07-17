<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Nullable pour les commandes anonymes

            // Prix et réductions
            $table->decimal('total_price', 10, 2)->default(0);
            $table->decimal('shipping_price', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('status')->default('pending'); // pending, paid, shipped, cancelled...

            // Informations d'adresse de livraison
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email'); // Email pour les commandes (obligatoire même si utilisateur connecté)
            $table->string('street');
            $table->string('apartment')->nullable();
            $table->string('city');
            $table->string('country');
            $table->string('postal_code');

            // Informations de livraison et coupon
            $table->string('shipping_method'); // ups_standard, ups_premium
            $table->string('coupon_code')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

