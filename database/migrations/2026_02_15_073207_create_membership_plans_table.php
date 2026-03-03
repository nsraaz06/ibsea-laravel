<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_plans', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title', 100);
            $table->string('tagline')->nullable();
            $table->decimal('fee_numeric', 10, 2);
            $table->integer('validity_days');
            $table->json('benefits_json')->nullable();
            $table->json('highlights_json')->nullable();
            $table->json('detailed_benefits_json')->nullable();
            $table->json('premium_features_json')->nullable();
            $table->json('stats_json')->nullable();
            $table->string('theme', 50)->nullable();
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
        Schema::dropIfExists('membership_plans');
    }
}
