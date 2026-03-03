<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('form_submissions', function (Blueprint $row) {
            $row->id();
            $row->foreignId('form_id')->constrained()->onDelete('cascade');
            $row->unsignedBigInteger('member_id')->nullable();
            $row->json('data');
            $row->string('ip_address')->nullable();
            $row->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_submissions');
    }
};
