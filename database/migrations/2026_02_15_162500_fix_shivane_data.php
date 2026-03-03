<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Member;
use App\Models\MemberRole;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Specific fix for Lt. Gen. AB Shivane and others where role might be in whatsapp_no
        // and current role might be city
        
        $members = Member::where('whatsapp_no', 'LIKE', '%Advisor%')
                        ->orWhere('whatsapp_no', 'LIKE', '%Member%')
                        ->orWhere('whatsapp_no', 'LIKE', '%Mentor%')
                        ->orWhere('whatsapp_no', 'LIKE', '%Chairperson%')
                         ->get();

        foreach ($members as $member) {
            $corruptValue = trim($member->whatsapp_no);

            // Move whatsapp_no content to role (e.g. "Advisor")
            $member->role = $corruptValue;

            // If the current role looks like a city (e.g. "Delhi", "Noida"), move it to city
            // This is a manual heuristic based on the user's report
            $currentRole = $member->getOriginal('role'); 
            if ($currentRole && !in_array($currentRole, ['Advisor', 'Member', 'Mentor', 'Investor', 'Strategic Advisor', 'Global Chairperson'])) {
                 $member->city = $currentRole;
            }

            // Sync role_id if possible
            $roleModel = MemberRole::where('role_name', 'LIKE', '%' . $corruptValue . '%')->first();
            if ($roleModel) {
                $member->role_id = $roleModel->id;
            }

            // Clear whatsapp_no
            $member->whatsapp_no = null;

            $member->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse
    }
};
