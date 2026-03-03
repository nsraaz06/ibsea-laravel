<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Event;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard mission overview.
     */
    public function index()
    {
        // 1. Total Active Members
        $totalMembers = Member::where('status', 'Active')->count();

        // 2. Members per Category
        $roleStats = Member::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role')
            ->toArray();

        // 3. Sales Matrix (This Month)
        $thisMonth = now()->format('Y-m');
        $salesThisMonth = Payment::where('status', 'Success')
            ->where('created_at', 'like', $thisMonth . '%')
            ->sum('amount');

        // 4. Monthly Membership Purchase Volume
        $membershipVol = Payment::where('payment_type', 'Membership')
            ->where('status', 'Success')
            ->where('created_at', 'like', $thisMonth . '%')
            ->count();

        // 5. Total Event Tickets Purchased
        $eventSalesCount = \App\Models\EventBooking::where('status', 'Confirmed')->count();

        // 6. Active Events
        $activeEvents = Event::where('status', 'Upcoming')->count();

        // 6. Recent Activity
        $recentActivity = Payment::with('member')
            ->where('status', 'Success')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'totalMembers' => $totalMembers,
            'roleStats' => $roleStats,
            'salesThisMonth' => $salesThisMonth,
            'membershipVol' => $membershipVol,
            'eventSalesCount' => $eventSalesCount,
            'activeEvents' => $activeEvents,
            'recentActivity' => $recentActivity,
            'title' => 'Admin Dashboard | IBSEA Mission Control'
        ]);
    }
}
