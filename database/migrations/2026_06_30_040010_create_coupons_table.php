<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['percent', 'fixed']); // percent (persentase) atau fixed (potongan rupiah tetap)
            $table->bigInteger('value'); // Nilai diskon (misal: 10 untuk 10%, 50000 untuk Rp 50.000)
            $table->bigInteger('min_purchase')->default(0); // Minimal belanja agar kupon bisa dipakai
            $table->bigInteger('max_discount')->nullable(); // Maksimal diskon (berguna untuk tipe persen)
            $table->integer('usage_limit')->nullable(); // Batas kuota penggunaan (berapa kali bisa dipakai)
            $table->integer('used_count')->default(0); // Berapa kali sudah dipakai
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
