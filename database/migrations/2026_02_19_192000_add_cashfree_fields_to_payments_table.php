<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashfreeFieldsToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('cashfree_order_id', 100)->nullable()->after('razorpay_order_id');
            $table->string('payment_session_id', 255)->nullable()->after('cashfree_order_id');
            $table->string('gateway', 20)->default('cashfree')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['cashfree_order_id', 'payment_session_id', 'gateway']);
        });
    }
}
