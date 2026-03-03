<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MemberRole;

class MemberRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['role_name' => 'Chairman', 'hierarchy_level' => 1],
            ['role_name' => 'Advisor', 'hierarchy_level' => 2],
            ['role_name' => 'Strategic Advisor', 'hierarchy_level' => 2],
            ['role_name' => 'Mentor', 'hierarchy_level' => 3],
            ['role_name' => 'Country President', 'hierarchy_level' => 4],
            ['role_name' => 'State President', 'hierarchy_level' => 5],
            ['role_name' => 'Vice President', 'hierarchy_level' => 6],
            ['role_name' => 'Alliance Head', 'hierarchy_level' => 7],
            ['role_name' => 'Investor', 'hierarchy_level' => 8],
            ['role_name' => 'Member', 'hierarchy_level' => 10],
        ];

        foreach ($roles as $r) {
            MemberRole::firstOrCreate(['role_name' => $r['role_name']], [
                'hierarchy_level' => $r['hierarchy_level'],
                'show_in_leadership' => true
            ]);
        }
    }
}
