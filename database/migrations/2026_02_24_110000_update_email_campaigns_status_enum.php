<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Alter ENUM to add 'queued' and 'sending' statuses needed for queue-based dispatch
        DB::statement("ALTER TABLE email_campaigns MODIFY COLUMN status ENUM('queued','sending','sent','partial','failed') NOT NULL DEFAULT 'sent'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE email_campaigns MODIFY COLUMN status ENUM('sent','partial','failed') NOT NULL DEFAULT 'sent'");
    }
};
