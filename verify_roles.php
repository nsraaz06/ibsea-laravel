<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\MemberRole;

echo "Checking MemberRole count...\n";
echo "Connected to Database: " . DB::connection()->getDatabaseName() . "\n";
$roles = MemberRole::all();
echo "Total Roles Found: " . $roles->count() . "\n";

foreach ($roles as $role) {
    echo "- ID: {$role->id}, Name: {$role->role_name}, Level: {$role->hierarchy_level}\n";
}
