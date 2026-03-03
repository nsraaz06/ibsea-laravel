<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateIdsToEventsAndPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('certificate_template_id')->nullable()->after('status');
            $table->unsignedBigInteger('ticket_template_id')->nullable()->after('certificate_template_id');
        });

        Schema::table('membership_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('id_card_template_id')->nullable()->after('theme');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['certificate_template_id', 'ticket_template_id']);
        });

        Schema::table('membership_plans', function (Blueprint $table) {
            $table->dropColumn('id_card_template_id');
        });
    }
}
