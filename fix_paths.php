<?php

/**
 * IBSEA Database Path Repair Script
 * This script fixes profile image paths that contain backslashes,
 * converting them to forward slashes for cross-platform compatibility.
 */

// Load Laravel (adjust path if needed for Hostinger)
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "<h1>IBSEA Database Path Repair</h1>";
    echo "<p>Checking for paths with backslashes...</p>";

    $members = DB::table('members')
        ->where('profile_image', 'LIKE', '%\\\\%')
        ->get();

    $count = 0;
    foreach ($members as $member) {
        $oldPath = $member->profile_image;
        $newPath = str_replace('\\', '/', $oldPath);
        
        DB::table('members')
            ->where('id', $member->id)
            ->update(['profile_image' => $newPath]);
            
        echo "Fixed Member ID: {$member->id} | '{$oldPath}' -> '{$newPath}'<br>";
        $count++;
    }

    echo "<h3>Success! Modified {$count} records.</h3>";
    echo "<p style='color: red;'><strong>SECURITY ACTION: Please delete this file (fix_paths.php) from your server now.</strong></p>";

} catch (\Exception $e) {
    echo "<h3 style='color: red;'>Error: " . $e->getMessage() . "</h3>";
}
