<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Council;

class CouncilsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $councils = [
            "Tech & AI", "Women Empowerment", "Global Trade", "MSME Growth", 
            "Strategic Policy", "Education & Skill", "Healthcare Innovation"
        ];
        foreach ($councils as $c) {
            Council::firstOrCreate(['name' => $c]);
        }
    }
}
