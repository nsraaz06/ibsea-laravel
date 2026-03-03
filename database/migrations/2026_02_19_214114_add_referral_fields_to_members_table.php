<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferralFieldsToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('referral_code', 8)->unique()->nullable()->after('id');
            $table->unsignedBigInteger('referrer_id')->nullable()->after('referral_code');
            $table->integer('referral_count')->default(0)->after('referrer_id');
            
            // Add index for performance
            $table->index('referral_code');
            $table->index('referrer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['referral_code', 'referrer_id', 'referral_count']);
        });
    }
}
