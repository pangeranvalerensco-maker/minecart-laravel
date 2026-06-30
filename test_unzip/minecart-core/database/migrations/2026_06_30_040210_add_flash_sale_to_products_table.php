<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_flash_sale')->default(false);
            $table->bigInteger('flash_sale_price')->nullable();
            $table->dateTime('flash_sale_start')->nullable();
            $table->dateTime('flash_sale_end')->nullable();
            $table->integer('flash_sale_stock')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_flash_sale', 
                'flash_sale_price', 
                'flash_sale_start', 
                'flash_sale_end', 
                'flash_sale_stock'
            ]);
        });
    }
};
