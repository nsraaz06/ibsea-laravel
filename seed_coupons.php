<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    App\Models\Coupon::updateOrCreate(
        ['code' => 'SAVE50'], 
        ['type' => 'fixed', 'value' => 50, 'status' => 'Active', 'min_amount' => 100]
    );
    App\Models\Coupon::updateOrCreate(
        ['code' => 'DISCOUNT10'], 
        ['type' => 'percent', 'value' => 10, 'status' => 'Active']
    );
    echo "Test coupons created successfully.\n";
} catch (Exception $e) {
    echo "Error creating coupons: " . $e->getMessage() . "\n";
}
