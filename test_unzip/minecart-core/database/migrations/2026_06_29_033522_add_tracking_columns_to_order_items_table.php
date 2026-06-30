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
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('subtotal');
            $table->string('shipping_courier')->nullable()->after('tracking_number');
            $table->string('status')->default('processing')->after('shipping_courier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['tracking_number', 'shipping_courier', 'status']);
        });
    }
};
