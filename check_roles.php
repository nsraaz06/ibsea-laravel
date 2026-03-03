<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$roles = \App\Models\MemberRole::all();
foreach ($roles as $role) {
    echo "ID: {$role->id}, Name: {$role->role_name}\n";
}
