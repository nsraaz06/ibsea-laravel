<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\EventBooking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('member')->user();
        
        // --- Legacy Logic: Membership Context ---
        $hasMembership = !empty($user->membership_plan_id);
        $isRestricted = ($user->role == 'Member' && !$hasMembership);

        // --- Gamification Logic: Calculate Completion Percentage ---
        $points = 0;
        if ($user->profile_image) $points += 20;
        if ($user->bio || $user->full_description) $points += 20;
        if ($user->short_description) $points += 10;
        if ($user->achievements) $points += 20;
        if ($user->industry && $user->profession) $points += 10;
        if ($user->linkedin_url) $points += 10;
        if ($user->website_url) $points += 10;
        $completionPercentage = min(100, $points);

        // --- Regional Intelligence: Fetch Chapter Leaders ---
        $president = null;
        $vp = null;
        if ($user->chapter_id) {
            $leaders = \App\Models\Member::where('chapter_id', $user->chapter_id)
                ->whereIn('role', ['State President', 'Country President', 'Vice President'])
                ->get();
            foreach ($leaders as $l) {
                if ($l->role == 'Vice President') $vp = $l;
                else if (strpos($l->role, 'President') !== false) $president = $l;
            }
        }

        // --- Membership Validity ---
        $daysRemaining = 0;
        $validityPercent = 0;
        if ($user->membership_end) {
            $expiry = \Carbon\Carbon::parse($user->membership_end);
            $daysRemaining = max(0, now()->diffInDays($expiry, false));
            $validityPercent = min(100, max(0, ($daysRemaining / 365) * 100));
        }

        $upcomingEvents = \App\Models\Event::where('status', 'Upcoming')
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();

        $boosterPlan = \App\Models\MembershipPlan::find('booster');

        $latestNotifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();
            
        // --- Referral Intelligence: Network Stats ---
        $totalReferrals = \App\Models\Member::where('referrer_id', $user->id)->count();
        $strategicRank = $user->strategic_rank ?: 'Explorer';
            
        return view('user.dashboard', compact(
            'user', 
            'latestNotifications', 
            'completionPercentage', 
            'president', 
            'vp', 
            'daysRemaining', 
            'validityPercent',
            'hasMembership',
            'isRestricted',
            'upcomingEvents',
            'boosterPlan',
            'totalReferrals',
            'strategicRank'
        ), ['title' => 'Dashboard | IBSEA Member Hub']);
    }

    public function transactions()
    {
        $user = Auth::guard('member')->user();
        
        $payments = Payment::where('member_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('user.transactions', compact('user', 'payments'), ['title' => 'My Transactions | IBSEA Member Hub']);
    }

    public function tickets()
    {
        $user = Auth::guard('member')->user();
        
        $bookings = EventBooking::where('member_id', $user->id)
            ->with('event', 'ticket')
            ->latest()
            ->get();

        return view('user.tickets', compact('user', 'bookings'), ['title' => 'My Tickets | IBSEA Member Hub']);
    }

    public function settings()
    {
        $user = Auth::guard('member')->user();
        return view('user.settings', compact('user'), ['title' => 'Account Settings | IBSEA Member Hub']);
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::guard('member')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $user->save();

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function profile()
    {
        $user = Auth::guard('member')->user();
        return view('user.profile', compact('user'), ['title' => 'My Portfolio | IBSEA Member Hub']);
    }

    public function findEvents()
    {
        $user = Auth::guard('member')->user();
        $events = \App\Models\Event::where('status', 'Upcoming')
            ->orderBy('event_date', 'asc')
            ->paginate(9);

        return view('user.events.find', compact('user', 'events'), ['title' => 'Browse Events | IBSEA Member Hub']);
    }
}
