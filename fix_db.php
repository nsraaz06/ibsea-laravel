<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$pdo = Illuminate\Support\Facades\DB::getPdo();

try {
    // Create coupons table
    $pdo->exec("CREATE TABLE IF NOT EXISTS coupons (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        code varchar(50) NOT NULL,
        type enum('fixed','percent') NOT NULL,
        value decimal(10,2) NOT NULL,
        expiry_date datetime DEFAULT NULL,
        usage_limit int(11) DEFAULT NULL,
        used_count int(11) NOT NULL DEFAULT 0,
        min_amount decimal(10,2) NOT NULL DEFAULT 0.00,
        status enum('Active','Inactive') NOT NULL DEFAULT 'Active',
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY coupons_code_unique (code)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    echo "Coupons table checked/created.\n";
} catch (Exception $e) {
    echo "Error creating coupons table: " . $e->getMessage() . "\n";
}

try {
    // Add columns to payments
    @$pdo->exec("ALTER TABLE payments ADD COLUMN coupon_id bigint(20) unsigned DEFAULT NULL AFTER item_id");
    @$pdo->exec("ALTER TABLE payments ADD COLUMN discount_amount decimal(10,2) NOT NULL DEFAULT 0.00 AFTER coupon_id");
    @$pdo->exec("ALTER TABLE payments ADD CONSTRAINT payments_coupon_id_foreign FOREIGN KEY (coupon_id) REFERENCES coupons (id) ON DELETE SET NULL");
    echo "Payments table updates attempted.\n";
} catch (Exception $e) {
    echo "Error updating payments table: " . $e->getMessage() . "\n";
}
