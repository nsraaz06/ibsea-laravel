<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Chapter;
use App\Models\Council;
use App\Models\MemberRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\MediaOptimizerService;

class MemberController extends Controller
{
    protected $optimizer;

    public function __construct(MediaOptimizerService $optimizer)
    {
        $this->optimizer = $optimizer;
    }
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        $query = Member::with(['chapter', 'council', 'memberRole', 'membershipPlan']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        if ($request->filled('chapter_id')) {
            $query->where('chapter_id', $request->chapter_id);
        }

        if ($request->filled('state')) {
            $query->where('state_country', $request->state);
        }

        $members = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.members.index', [
            'members' => $members,
            'title' => 'Member Directory | IBSEA Admin',
            'roles' => MemberRole::all(),
            'chapters' => Chapter::all(),
            'states' => Member::select('state_country')
                            ->distinct()
                            ->whereNotNull('state_country')
                            ->where('state_country', '!=', '')
                            ->orderBy('state_country')
                            ->pluck('state_country')
        ]);
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        return view('admin.members.create', [
            'chapters' => Chapter::all(),
            'councils' => Council::all(),
            'roles' => MemberRole::all(),
            'plans' => \App\Models\MembershipPlan::all(),
            'title' => 'Add New Member | IBSEA Admin'
        ]);
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'password' => 'required|string|min:8',
            'status' => 'required|in:Pending,Vetted,Active,Suspended',
            'membership_plan_id' => 'nullable|exists:membership_plans,id',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $this->optimizer->optimizeImage($request->profile_image, 'uploads/profiles');
        }

        Member::create($data);

        return redirect()->route('admin.members.index')->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified member.
     */
    public function show(Member $member)
    {
        return view('admin.members.show', [
            'member' => $member->load(['chapter', 'council', 'memberRole']),
            'title' => 'Member Details | ' . $member->name
        ]);
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(Member $member)
    {
        return view('admin.members.edit', [
            'member' => $member,
            'chapters' => Chapter::all(),
            'councils' => Council::all(),
            'roles' => MemberRole::all(),
            'plans' => \App\Models\MembershipPlan::all(),
            'title' => 'Edit Member | ' . $member->name
        ]);
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members,email,' . $member->id,
            'status' => 'required|in:Pending,Vetted,Active,Suspended',
            'membership_plan_id' => 'nullable|exists:membership_plans,id',
        ]);

        $data = $request->only([
            'name', 'email', 'leadership_email', 'mobile', 'whatsapp_no', 'dob',
            'business_name', 'industry', 'profession', 'business_category',
            'website_url', 'linkedin_url', 'role_id', 'role', 'membership_plan_id',
            'chapter_id', 'council_id', 'alliance_name', 'address_line', 'city',
            'state_country', 'pincode', 'membership_start', 'membership_end',
            'short_description', 'bio', 'status'
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($member->profile_image && file_exists(public_path($member->profile_image))) {
                @unlink(public_path($member->profile_image));
            }
            $data['profile_image'] = $this->optimizer->optimizeImage($request->profile_image, 'uploads/profiles');
        }

        $member->update($data);

        return redirect()->route('admin.members.index')->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(Member $member)
    {
        if ($member->profile_image) {
            Storage::disk('public')->delete($member->profile_image);
        }
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Member deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:members,id',
        ]);

        $count = 0;
        foreach ($request->ids as $id) {
            $member = Member::find($id);
            if ($member) {
                if ($member->profile_image) {
                    Storage::disk('public')->delete($member->profile_image);
                }
                $member->delete();
                $count++;
            }
        }

        return redirect()->route('admin.members.index')->with('success', "$count members deleted successfully.");
    }

    public function bulkUpdateRole(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:members,id',
            'role_id' => 'required|exists:member_roles,id',
        ]);

        $role = MemberRole::find($request->role_id);
        
        Member::whereIn('id', $request->ids)->update([
            'role_id' => $request->role_id,
            // Optionally update the text role to match the system role name for consistency
            'role' => $role->role_name 
        ]);

        return redirect()->route('admin.members.index')->with('success', "Roles updated successfully.");
    }
}
