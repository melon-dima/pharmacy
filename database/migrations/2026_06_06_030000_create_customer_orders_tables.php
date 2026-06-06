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
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pharmacy_id')->nullable()->constrained()->nullOnDelete();
            $table->string('delivery_type');
            $table->string('status')->default('pending');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('delivery_address')->nullable();
            $table->unsignedInteger('total_cents')->default(0);
            $table->char('currency', 3)->default('RUB');
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        Schema::create('customer_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medicine_id')->constrained()->restrictOnDelete();
            $table->string('medicine_name');
            $table->string('medicine_sku')->nullable();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('unit_price_cents')->default(0);
            $table->char('currency', 3)->default('RUB');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_order_items');
        Schema::dropIfExists('customer_orders');
    }
};
