<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseReferralCodeLengthInMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE members MODIFY referral_code VARCHAR(20)');
    }

    public function down()
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE members MODIFY referral_code VARCHAR(8)');
    }
}
