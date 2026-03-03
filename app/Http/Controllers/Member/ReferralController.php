<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

class ReferralController extends Controller
{
    public function index()
    {
        $user = Auth::guard('member')->user();
        
        // Fetch direct referrals
        $directReferrals = $user->referrals()->latest()->paginate(10);
        
        // Calculate network stats
        $totalReferrals = $user->referral_count;
        $activeReferrals = $user->referrals()->where('status', 'Active')->count();
        $pendingReferrals = $user->referrals()->where('status', 'Pending')->count();

        // Rank is managed automatically by the Member model
        $rank = $user->strategic_rank ?? 'Member';

        return view('user.referral.index', compact(
            'user', 
            'directReferrals', 
            'totalReferrals', 
            'activeReferrals', 
            'pendingReferrals',
            'rank'
        ), ['title' => 'Referral Hub | IBSEA Member Network']);
    }

    public function networkData()
    {
        $user = Auth::guard('member')->user();
        
        // Build a simple 2-level tree for visualization
        // Logic can be expanded for deeper levels later
        $data = [
            'name' => $user->name,
            'role' => 'You',
            'image' => $user->profile_image ? asset($user->profile_image) : asset('image/default-user.png'),
            'children' => []
        ];

        foreach ($user->referrals as $referral) {
            $childNode = [
                'name' => $referral->name,
                'role' => $referral->profession ?? 'Member',
                 'image' => $referral->profile_image ? asset($referral->profile_image) : asset('image/default-user.png'),
                'children' => []
            ];
            
            // Fetch 2nd level (Grandchildren)
            foreach ($referral->referrals as $subReferral) {
                $childNode['children'][] = [
                    'name' => $subReferral->name,
                    'role' => $subReferral->profession ?? 'Member',
                    'image' => $subReferral->profile_image ? asset($subReferral->profile_image) : asset('image/default-user.png'),
                ];
            }
            
            $data['children'][] = $childNode;
        }

        return response()->json($data);
    }
}
