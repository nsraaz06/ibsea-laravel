<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('whatsapp_no', 15)->nullable();
            $table->date('dob')->nullable();
            $table->string('profile_image')->nullable();
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->onDelete('set null');
            $table->foreignId('council_id')->nullable()->constrained('councils')->onDelete('set null');
            $table->string('role', 100)->default('Member');
            $table->string('membership_plan_id')->nullable();
            $table->foreign('membership_plan_id')->references('id')->on('membership_plans')->onDelete('set null');
            $table->date('membership_start')->nullable();
            $table->date('membership_end')->nullable();
            $table->text('address_line')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state_country', 100)->nullable();
            $table->string('pincode', 10)->nullable();
            $table->enum('status', ['Pending', 'Active', 'Vetted'])->default('Pending');
            $table->integer('strategic_rank')->default(0);
            $table->string('alliance_name', 150)->nullable();
            $table->text('bio')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('short_description')->nullable();
            $table->text('full_description')->nullable();
            $table->text('achievements')->nullable();
            $table->boolean('profile_completed')->default(false);
            $table->string('setup_token', 64)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
