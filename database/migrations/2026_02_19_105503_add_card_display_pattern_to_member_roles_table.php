<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCardDisplayPatternToMemberRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_roles', function (Blueprint $table) {
            $table->string('card_display_pattern')->default('automatic')->after('show_in_leadership');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_roles', function (Blueprint $table) {
            $table->dropColumn('card_display_pattern');
        });
    }
}
