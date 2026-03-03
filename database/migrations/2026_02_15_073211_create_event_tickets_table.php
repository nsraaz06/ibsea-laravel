<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('ticket_name', 100);
            $table->text('benefits')->nullable();
            $table->decimal('original_price', 10, 2);
            $table->decimal('offer_price', 10, 2)->nullable();
            $table->datetime('last_date_to_buy')->nullable();
            $table->integer('ticket_quantity')->default(0);
            $table->datetime('expiry_date')->nullable();
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
        Schema::dropIfExists('event_tickets');
    }
}
