<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::firstOrCreate(['username' => 'admin'], [
            'email' => 'admin@ibsea.org',
            'password' => Hash::make('ibsea2047')
        ]);
    }
}
