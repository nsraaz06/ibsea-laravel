<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forms', function (Blueprint $row) {
            $row->id();
            $row->string('title');
            $row->string('slug')->unique();
            $row->text('description')->nullable();
            $row->json('fields')->nullable();
            $row->json('settings')->nullable();
            $row->boolean('is_active')->default(true);
            $row->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('forms');
    }
};
