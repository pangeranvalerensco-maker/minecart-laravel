<?php
// Script Import Data dari JSON ke MySQL

require __DIR__.'/minecart-core/vendor/autoload.php';
$app = require_once __DIR__.'/minecart-core/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $json = file_get_contents(__DIR__.'/db_dump.json');
    if (!$json) {
        die("<h1>FILE db_dump.json TIDAK DITEMUKAN!</h1>");
    }

    $dump = json_decode($json, true);

    // Matikan Foreign Key check agar tidak bentrok saat insert
    \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    foreach ($dump as $table => $rows) {
        if (empty($rows)) continue;

        echo "Sedang memindahkan " . count($rows) . " data ke tabel <strong>{$table}</strong>...<br>";

        // Kosongkan tabel sebelum diisi
        \Illuminate\Support\Facades\DB::table($table)->truncate();

        // Bagi data menjadi chunk agar tidak memberatkan server MySQL
        $chunks = array_chunk($rows, 50);
        foreach ($chunks as $chunk) {
            \Illuminate\Support\Facades\DB::table($table)->insert($chunk);
        }
    }

    \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    echo "<h1>MIGRASI DATA SUPER BERHASIL! 100+ Produk Anda Telah Kembali!</h1>";
} catch (\Throwable $e) {
    echo "<h1>GAGAL IMPORT: " . $e->getMessage() . "</h1>";
}
