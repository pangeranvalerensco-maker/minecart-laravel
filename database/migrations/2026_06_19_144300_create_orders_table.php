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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('fullname');
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code', 10);
            $table->text('courier_note')->nullable();
            $table->bigInteger('subtotal');
            $table->bigInteger('shipping_cost');
            $table->bigInteger('total');
            $table->string('payment_method');
            $table->string('payment_status')->default('paid');
            $table->string('status')->default('processing');
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
