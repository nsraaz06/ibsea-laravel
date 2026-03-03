<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image_path');
            $table->unsignedBigInteger('event_id')->nullable();
            $table->string('category')->default('General');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('galleries');
    }
};
