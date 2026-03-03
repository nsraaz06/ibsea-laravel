<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Payment::query()->where('status', 'Success')->with('member.membershipPlan');

        // Apply Time Range Filter
        if ($request->filled('time_range')) {
            $range = $request->time_range;
            if ($range === 'today') {
                $query->whereDate('created_at', now()->today());
            } elseif ($range === 'yesterday') {
                $query->whereDate('created_at', now()->yesterday());
            } elseif ($range === '7_days') {
                $query->where('created_at', '>=', now()->subDays(7));
            } elseif ($range === '15_days') {
                $query->where('created_at', '>=', now()->subDays(15));
            } elseif ($range === '1_month') {
                $query->where('created_at', '>=', now()->subMonth());
            } elseif ($range === '3_month') {
                $query->where('created_at', '>=', now()->subMonths(3));
            } elseif ($range === 'custom' && $request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
            }
        }

        // Apply Purpose Filter
        if ($request->filled('purpose')) {
            $query->where('payment_type', $request->purpose);
        }

        // Apply Plan Filter
        if ($request->filled('plan')) {
            $query->whereHas('member', function($q) use ($request) {
                $q->where('membership_plan_id', $request->plan);
            });
        }

        $payments = $query->latest()->get();
        
        $totalRevenue = $payments->sum('amount');
        $totalTransactions = $payments->count();
        
        // Secondary Stats (Still showing overall context unless filtered)
        $totalMembers = \App\Models\Member::count();
        $newMembersThisMonth = \App\Models\Member::whereMonth('created_at', now()->month)->count();
        
        $purposes = \App\Models\Payment::distinct()->pluck('payment_type');
        $plans = \App\Models\MembershipPlan::all();

        return view('admin.analytics.index', compact(
            'totalRevenue', 
            'totalTransactions',
            'totalMembers', 
            'newMembersThisMonth',
            'payments',
            'purposes',
            'plans'
        ));
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (!empty($ids)) {
            \App\Models\Payment::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Institutional intelligence archived successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'No dispatches selected for archive.'], 400);
    }
}
