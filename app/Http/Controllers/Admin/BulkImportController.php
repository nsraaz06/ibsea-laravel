<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Chapter;
use App\Models\MembershipPlan;
use App\Models\MemberRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BulkImportController extends Controller
{
    /**
     * Show the bulk import interface.
     */
    public function index()
    {
        return view('admin.bulk-import', ['title' => 'Bulk Onboarding | IBSEA Admin']);
    }

    /**
     * Download the CSV template for bulk import.
     */
    public function downloadTemplate()
    {
        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');
            
            // Define Headers
            fputcsv($handle, [
                'Name', 'Email', 'Password', 'Mobile', 'Whatsapp', 'DOB (YYYY-MM-DD)', 
                'Role Title (Display)', 'Institutional Role (System)', 'Chapter Name', 
                'Membership Plan Title', 'Address', 'City', 'State/Country', 'Pincode',
                'LinkedIn URL', 'Website URL', 'Business Name', 'Industry', 'Profession', 'Business Category', 'Alliance Name'
            ]);

            // Define Sample Row
            fputcsv($handle, [
                'John Doe', 'john@example.com', 'customPass123', '9876543210', '9876543210', '1990-01-01', 
                'Advisor', 'Member', 'Global', 
                'Platinum Membership', '123 Mission St', 'Mumbai', 'Maharashtra', '400001',
                'https://linkedin.com/in/johndoe', 'https://johndoe.com', 'Doe Enterprises', 'Tech', 'CEO', 'IT Services', 'Global Tech Alliance'
            ]);
            
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="ibsea_members_template_v2.csv"');

        return $response;
    }

    /**
     * Handle the CSV import process.
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        // Skip header
        fgetcsv($handle);

        $successCount = 0;
        $skipCount = 0;
        $errors = [];

        // Pre-fetch maps
        $chapters = Chapter::pluck('id', 'name')->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])->toArray();
        $roles = MemberRole::pluck('id', 'role_name')->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])->toArray();
        $plans = MembershipPlan::all()->mapWithKeys(fn($p) => [strtolower(trim($p->title)) => ['id' => $p->id, 'validity' => $p->validity_days]])->toArray();

        DB::beginTransaction();

        try {
            while (($data = fgetcsv($handle, 2000, ',')) !== false) {
                if (count($data) < 2) continue;

                $email = trim($data[1]);

                // Check for existing
                if (Member::where('email', $email)->exists()) {
                    $skipCount++;
                    continue;
                }

                // Indices based on new template:
                // 0:Name, 1:Email, 2:Pass, 3:Mobile, 4:WA, 5:DOB, 
                // 6:Role(Display), 7:Role(System), 8:Chapter, 9:Plan, 
                // 10:Addr, 11:City, 12:State, 13:Pin,
                // 14:LinkedIn, 15:Web, 16:BizName, 17:Ind, 18:Prof, 19:BizCat, 20:Alliance

                $roleNameDisplay = trim($data[6] ?? 'Member');
                $roleNameSystem = strtolower(trim($data[7] ?? 'Member'));
                $chapterName = strtolower(trim($data[8] ?? ''));
                $planTitle = strtolower(trim($data[9] ?? ''));

                $roleId = $roles[$roleNameSystem] ?? $roles['member'] ?? null;
                $chapterId = $chapters[$chapterName] ?? null;
                $planData = $plans[$planTitle] ?? null;

                $startDate = now();
                $endDate = $planData ? $startDate->copy()->addDays($planData['validity']) : null;

                $rawPass = !empty($data[2]) ? $data[2] : 'ibsea2047';

                Member::create([
                    'name' => trim($data[0]),
                    'email' => $email,
                    'password' => Hash::make($rawPass),
                    'mobile' => trim($data[3] ?? ''),
                    'whatsapp_no' => trim($data[4] ?? ''),
                    'dob' => !empty($data[5]) ? $data[5] : null,
                    'role' => $roleNameDisplay, // Save to display column
                    'role_id' => $roleId,     // Save to relationship column
                    'chapter_id' => $chapterId,
                    'membership_plan_id' => $planData['id'] ?? null,
                    'status' => 'Active',
                    'membership_start' => $startDate,
                    'membership_end' => $endDate,
                    'address_line' => trim($data[10] ?? ''),
                    'city' => trim($data[11] ?? ''),
                    'state_country' => trim($data[12] ?? ''),
                    'pincode' => trim($data[13] ?? ''),
                    // New Fields
                    'linkedin_url' => trim($data[14] ?? ''),
                    'website_url' => trim($data[15] ?? ''),
                    'business_name' => trim($data[16] ?? ''),
                    'industry' => trim($data[17] ?? ''),
                    'profession' => trim($data[18] ?? ''),
                    'business_category' => trim($data[19] ?? ''),
                    'alliance_name' => trim($data[20] ?? ''),
                ]);

                $successCount++;
            }

            DB::commit();
            fclose($handle);

            return redirect()->route('admin.members.index')->with('success', "Import Successful: {$successCount} members added, {$skipCount} skipped.");

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->withErrors(['csv_file' => 'Critical error during import: ' . $e->getMessage()]);
        }
    }
}
