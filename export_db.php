<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = [
    'users',
    'categories', 
    'products',
    'orders',
    'order_items',
    'reviews',
    'wishlists',
    'coupons',
    'wallets',
    'settings'
];

$dump = [];
foreach ($tables as $table) {
    try {
        $dump[$table] = \Illuminate\Support\Facades\DB::table($table)->get()->toArray();
    } catch (\Exception $e) {
        // Table might not exist or be empty
    }
}

file_put_contents(__DIR__.'/db_dump.json', json_encode($dump));
echo "SUCCESS: Exported " . count($dump['products'] ?? []) . " products to db_dump.json\n";
