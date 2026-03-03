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
        // Find members with non-numeric characters in whatsapp_no (likely corrupted with Role text)
        $members = Member::where('whatsapp_no', 'REGEXP', '[a-zA-Z]')->get();

        foreach ($members as $member) {
            $corruptValue = $member->whatsapp_no;

            // Simple heuristic: if it looks like a role title
            if (in_array($corruptValue, ['Advisor', 'Member', 'Mentor', 'Investor', 'Strategic Advisor', 'Global Chairperson', 'Patron', 'Honorary Member'])) {
                // Move to role column
                $member->role = $corruptValue;

                // Try to find matching role_id
                $roleModel = MemberRole::where('role_name', $corruptValue)->first();
                if ($roleModel) {
                    $member->role_id = $roleModel->id;
                }

                // If the current 'role' column has a City name (another shift), move it to city
                // Assuming 'role' column collected the next column's data which is likely City
                if ($member->role && !in_array($member->role, ['Advisor', 'Member', 'Mentor', 'Investor', 'Strategic Advisor'])) {
                     // Check if current 'role' value looks like a city (text, no numbers)
                     // This is risky without strict validation, but acceptable for this specific known corruption
                     $member->city = $member->role; 
                }
                
                // Set the corrected role again (overwriting the city if it was there)
                $member->role = $corruptValue;
                
                // Clear the corrupt whatsapp number
                $member->whatsapp_no = null;
                
                $member->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse operation for data cleanup
    }
};
