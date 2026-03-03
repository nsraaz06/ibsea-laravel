<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('email_templates')->cascadeOnDelete();
            $table->string('subject');                    // Snapshot of subject at send time
            $table->string('recipients_type');           // all_members | specific | form_submitters | custom
            $table->text('recipient_detail')->nullable(); // JSON: IDs or emails
            $table->integer('sent_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->enum('status', ['sent', 'partial', 'failed'])->default('sent');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_campaigns');
    }
};
