<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class SetupDefaultSuperadmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Try to find the existing admin
        $admin = Admin::where('email', 'hello@ibsea.in')->first();

        if ($admin) {
            $admin->is_superadmin = true;
            $admin->save();
        } else {
            // Create a default superadmin if it doesn't exist
            Admin::create([
                'username' => 'Superadmin',
                'email' => 'hello@ibsea.in',
                'password' => Hash::make('password123!'), // Required for creation; user should update this later
                'is_superadmin' => true,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $admin = Admin::where('email', 'hello@ibsea.in')->first();
        if ($admin) {
            $admin->is_superadmin = false;
            $admin->save();
        }
    }
}
