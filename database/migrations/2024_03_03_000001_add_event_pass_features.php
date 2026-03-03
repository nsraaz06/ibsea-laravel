<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add event pass limit to membership plans
        if (Schema::hasTable('membership_plans') && !Schema::hasColumn('membership_plans', 'event_passes_limit')) {
            Schema::table('membership_plans', function (Blueprint $table) {
                $table->integer('event_passes_limit')->default(0)->after('fee_numeric');
            });
        }

        // Add pass usage toggle to event tickets
        if (Schema::hasTable('event_tickets') && !Schema::hasColumn('event_tickets', 'allow_membership_pass')) {
            Schema::table('event_tickets', function (Blueprint $table) {
                $table->boolean('allow_membership_pass')->default(true)->after('ticket_quantity');
            });
        }

        // Track pass usage in bookings
        if (Schema::hasTable('event_bookings')) {
            Schema::table('event_bookings', function (Blueprint $table) {
                if (!Schema::hasColumn('event_bookings', 'is_pass_usage')) {
                    $table->boolean('is_pass_usage')->default(false)->after('payment_id');
                }
                if (!Schema::hasColumn('event_bookings', 'pass_source')) {
                    $table->string('pass_source')->nullable()->after('is_pass_usage');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('membership_plans')) {
            Schema::table('membership_plans', function (Blueprint $table) {
                $table->dropColumn('event_passes_limit');
            });
        }

        if (Schema::hasTable('event_tickets')) {
            Schema::table('event_tickets', function (Blueprint $table) {
                $table->dropColumn('allow_membership_pass');
            });
        }

        if (Schema::hasTable('event_bookings')) {
            Schema::table('event_bookings', function (Blueprint $table) {
                $table->dropColumn(['is_pass_usage', 'pass_source']);
            });
        }
    }
};
