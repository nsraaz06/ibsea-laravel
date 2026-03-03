<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // null for 'all' targeted or handled differently
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('General');
            $table->boolean('is_read')->default(false);
            $table->string('target')->nullable(); // To store 'all', 'role:X', etc.
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
