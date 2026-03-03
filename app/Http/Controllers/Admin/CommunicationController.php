<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    public function index()
    {
        $roles = \App\Models\MemberRole::orderBy('role_name')->get();
        $plans = \App\Models\MembershipPlan::all();
        $chapters = \App\Models\Chapter::orderBy('name')->get();
        $councils = \App\Models\Council::orderBy('name')->get();
        $recentNotifications = \App\Models\Notification::latest()->take(5)->get();
        
        return view('admin.communication.index', compact('roles', 'plans', 'chapters', 'councils', 'recentNotifications'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target' => 'required|string',
            'type' => 'required|string'
        ]);

        $userIds = [];
        $target = $request->target;

        if ($target === 'all') {
            $userIds = \App\Models\Member::pluck('id')->toArray();
        } elseif (strpos($target, 'role:') === 0) {
            $roleId = substr($target, 5);
            $userIds = \App\Models\Member::where('role_id', $roleId)->pluck('id')->toArray();
        } elseif (strpos($target, 'plan:') === 0) {
            $planId = substr($target, 5);
            $userIds = \App\Models\Member::where('membership_plan_id', $planId)->pluck('id')->toArray();
        } elseif (strpos($target, 'chapter:') === 0) {
            $chapterId = substr($target, 8);
            $userIds = \App\Models\Member::where('chapter_id', $chapterId)->pluck('id')->toArray();
        } elseif (strpos($target, 'council:') === 0) {
            $councilId = substr($target, 8);
            $userIds = \App\Models\Member::where('council_id', $councilId)->pluck('id')->toArray();
        }

        foreach ($userIds as $uid) {
            \App\Models\Notification::create([
                'user_id' => $uid,
                'title' => $request->title,
                'message' => $request->message,
                'type' => $request->type,
                'target' => $target,
                'is_read' => false
            ]);
        }

        return back()->with('success', 'Intelligence dispatch recorded and distributed to ' . count($userIds) . ' recipients.');
    }
}
