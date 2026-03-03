<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $exists = Illuminate\Support\Facades\Schema::hasTable('coupons');
    echo "Coupons table exists: " . ($exists ? 'YES' : 'NO') . "\n";
    if ($exists) {
        $count = App\Models\Coupon::count();
        echo "Coupon count: " . $count . "\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
