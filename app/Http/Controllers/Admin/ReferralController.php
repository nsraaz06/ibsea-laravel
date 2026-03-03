<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::where('referral_count', '>', 0);

        // Filter by Chapter
        if ($request->filled('chapter_id')) {
            $query->where('chapter_id', $request->chapter_id);
        }

        // Filter by Month
        if ($request->filled('month')) {
            $monthDate = \Carbon\Carbon::parse($request->month);
            $query->whereHas('referrals', function($q) use ($monthDate) {
                $q->whereYear('created_at', $monthDate->year)
                  ->whereMonth('created_at', $monthDate->month);
            });
        }

        // Filter by Date Range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $end = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereHas('referrals', function($q) use ($start, $end) {
                $q->whereBetween('created_at', [$start, $end]);
            });
        }

        $topReferrers = $query->orderByDesc('referral_count')->paginate(15);

        // Stats
        $totalReferrals = Member::whereNotNull('referrer_id')->count();
        $topReferrer = Member::orderByDesc('referral_count')->first();
        
        $chapters = \App\Models\Chapter::orderBy('name')->get();

        return view('admin.referrals.index', compact('topReferrers', 'totalReferrals', 'topReferrer', 'chapters'));
    }

    public function show(Member $member)
    {
        $referrals = $member->referrals()->with(['chapter', 'membershipPlan'])->latest()->paginate(20);
        return view('admin.referrals.show', compact('member', 'referrals'));
    }
}
