<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlignSchemaWithBackup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('membership_id', 50)->nullable();
            $table->string('business_name', 150)->nullable();
            $table->string('industry', 100)->nullable();
            $table->string('profession', 100)->nullable();
            $table->string('business_category', 100)->nullable();
            $table->string('image_path', 255)->nullable();
            $table->enum('chapter_type', ['National', 'International'])->default('National');
            $table->tinyInteger('id_card_status')->default(0);
            $table->tinyInteger('certificate_status')->default(0);
            $table->tinyInteger('ticket_status')->default(1);
            $table->text('address_line_1')->nullable();
            $table->string('location_detail', 100)->nullable();
            $table->string('website_url', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('reset_token', 255)->nullable();
            $table->dateTime('reset_expiry')->nullable();
            $table->date('join_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('chapter_change_count')->default(0);
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->string('state_code', 10)->nullable();
            $table->integer('total_members_count')->default(0);
            $table->enum('status', ['Healthy', 'At-Risk', 'Inactive'])->default('Inactive');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('organizer', 150)->default('IBSEA');
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
            $table->dropColumn([
                'membership_id', 'business_name', 'industry', 'profession', 'business_category',
                'image_path', 'chapter_type', 'id_card_status', 'certificate_status', 'ticket_status',
                'address_line_1', 'location_detail', 'website_url', 'address', 'reset_token',
                'reset_expiry', 'join_date', 'expiry_date', 'chapter_change_count'
            ]);
        });

        Schema::table('chapters', function (Blueprint $table) {
           $table->dropColumn(['state_code', 'total_members_count', 'status']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('organizer');
        });
    }
}
