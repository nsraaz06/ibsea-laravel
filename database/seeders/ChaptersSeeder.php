<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;

class ChaptersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = ["Maharashtra", "Delhi", "Karnataka", "Tamil Nadu", "Gujarat"];
        $countries = ["USA", "UK", "UAE", "Singapore"];
        
        foreach ($states as $s) {
            Chapter::firstOrCreate(['name' => $s, 'type' => 'National']);
        }
        
        foreach ($countries as $c) {
            Chapter::firstOrCreate(['name' => $c, 'type' => 'International']);
        }
    }
}
