<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixOrphanedMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fix-orphans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Identify and nullify orphaned foreign key references in the members table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $constraints = [
            'chapter_id' => 'chapters',
            'council_id' => 'councils',
            'membership_plan_id' => 'membership_plans',
            'role_id' => 'member_roles',
        ];

        $this->info("Starting Orphaned Data Check...");

        foreach ($constraints as $column => $table) {
            $this->comment("Checking $column against $table...");
            
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
                $this->warn("Found " . $orphans->count() . " orphaned records in $column.");
                $this->line("Orphaned Member IDs: " . $orphans->implode(', '));
                
                if ($this->confirm("Do you want to nullify these $column references?", true)) {
                    $affected = DB::table('members')
                        ->whereIn('id', $orphans)
                        ->update([$column => null]);
                        
                    $this->info("Successfully nulled out $affected references in $column.");
                }
            } else {
                $this->info("No orphaned records found in $column.");
            }
        }

        $this->info("Check complete.");
        return 0;
    }
}
