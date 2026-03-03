<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Member;
use Illuminate\Support\Facades\File;

echo "Checking for missing member images...\n";

$members = Member::whereNotNull('profile_image')->get();
$missingCount = 0;

foreach ($members as $member) {
    if (empty($member->profile_image)) continue;

    // Handle both 'uploads/members/...' and 'profiles/...' paths
    $path = public_path($member->profile_image);
    
    // Also check if it's stored in storage/app/public link
    $storagePath = public_path('storage/' . $member->profile_image);

    if (!File::exists($path) && !File::exists($storagePath)) {
        echo "Missing Image for Member ID {$member->id} ({$member->name}): {$member->profile_image}\n";
        $missingCount++;
    }
}

if ($missingCount === 0) {
    echo "All member images found.\n";
} else {
    echo "Total missing images: $missingCount\n";
}
