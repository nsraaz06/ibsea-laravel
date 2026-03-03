<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyToMembershipPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('membership_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('membership_plans', 'currency')) {
                $table->string('currency', 10)->default('INR')->after('fee_numeric');
            }
            if (!Schema::hasColumn('membership_plans', 'currency_symbol')) {
                $table->string('currency_symbol', 10)->default('₹')->after('currency');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membership_plans', function (Blueprint $table) {
            $table->dropColumn(['currency', 'currency_symbol']);
        });
    }
}
