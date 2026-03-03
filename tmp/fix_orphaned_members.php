<?php

use Illuminate\Support\Facades\DB;
use App\Models\Member;

// Define the foreign key columns and their respective target tables
$constraints = [
    'chapter_id' => 'chapters',
    'council_id' => 'councils',
    'membership_plan_id' => 'membership_plans',
    'role_id' => 'member_roles',
];

echo "Starting Orphaned Data Check...\n";

foreach ($constraints as $column => $table) {
    echo "Checking $column against $table...\n";
    
    // Find member IDs where the referenced record does not exist
    $orphans = DB::table('members')
        ->whereNotNull($column)
        ->whereNotExists(function ($query) use ($table, $column) {
            $query->select(DB::raw(1))
                ->from($table)
                ->whereColumn("$table.id", "members.$column");
        })
        ->pluck('id');

    if ($orphans->count() > 0) {
        echo "Found " . $orphans->count() . " orphaned records in $column.\n";
        echo "Orphaned Member IDs: " . $orphans->implode(', ') . "\n";
        
        // Update those records to NULL
        $affected = DB::table('members')
            ->whereIn('id', $orphans)
            ->update([$column => null]);
            
        echo "Successfully nulled out $affected references in $column.\n";
    } else {
        echo "No orphaned records found in $column.\n";
    }
}

echo "Check complete. You can now safely re-enable foreign keys if they were disabled.\n";
echo "Run: SET FOREIGN_KEY_CHECKS = 1;\n";
