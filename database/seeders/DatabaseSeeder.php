<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ChaptersSeeder::class,
            CouncilsSeeder::class,
            MemberRolesSeeder::class,
            MembershipPlansSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
