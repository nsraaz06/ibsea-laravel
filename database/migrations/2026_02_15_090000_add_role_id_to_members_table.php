<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddRoleIdToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable()->after('council_id');
            $table->foreign('role_id')->references('id')->on('member_roles')->onDelete('set null');
        });

        // Data Migration: Map existing 'role' string to 'role_id'
        $roles = DB::table('member_roles')->get();
        foreach ($roles as $role) {
            DB::table('members')
                ->where('role', $role->role_name)
                ->update(['role_id' => $role->id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
}
