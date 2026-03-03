<?php

/**
 * IBSEA Emergency DB Repair Script
 * This script automatically fixes the referral_code column length.
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    echo "<h1>IBSEA Emergency DB Repair</h1>";
    
    echo "<p>Checking 'referral_code' column...</p>";
    
    DB::statement("ALTER TABLE members MODIFY COLUMN referral_code VARCHAR(20)");
    
    echo "<h3 style='color: green;'>Success! The column length has been increased to 20 characters.</h3>";
    echo "<p>You can now use either 'IBSEA-' or 'IBS-' codes without errors.</p>";
    echo "<p style='color: red;'><strong>SECURITY ACTION: Please DELETE this file (db_repair.php) from your public folder right now!</strong></p>";

} catch (\Exception $e) {
    echo "<h3 style='color: red;'>Error: " . $e->getMessage() . "</h3>";
    echo "<p>It's possible the column was already fixed or your database user lacks ALTER permissions.</p>";
}
