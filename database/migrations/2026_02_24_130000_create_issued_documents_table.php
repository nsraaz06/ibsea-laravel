<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuedDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issued_documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_no')->unique()->index();
            $table->unsignedBigInteger('member_id')->index();
            $table->unsignedBigInteger('event_booking_id')->nullable()->index();
            $table->string('document_type'); // certificate, id_card, ticket
            $table->integer('year');
            $table->integer('sequence_number');
            $table->timestamp('issued_at')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issued_documents');
    }
}
