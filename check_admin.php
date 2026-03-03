<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

$admin = Admin::where('email', 'admin@ibsea.org')->orWhere('username', 'admin')->first();

if ($admin) {
    echo "Admin found:\n";
    echo "ID: " . $admin->id . "\n";
    echo "Username: " . $admin->username . "\n";
    echo "Email: " . $admin->email . "\n";
    echo "Password Hash: " . $admin->password . "\n";
    
    if (Hash::check('ibsea2047', $admin->password)) {
        echo "Password matches!\n";
    } else {
        echo "Password does NOT match.\n";
    }
} else {
    echo "Admin not found.\n";
    
    echo "\nAll Admins:\n";
    foreach (Admin::all() as $a) {
        echo "- " . $a->username . " (" . $a->email . ")\n";
    }
}
