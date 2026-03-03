<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Show the about page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $strategic_advisors = \App\Models\Member::with('chapter')->where(function($q) {
                $q->where('role', 'Strategic Advisor')
                  ->orWhereHas('memberRole', function($inner) {
                      $inner->where('role_name', 'Strategic Advisor');
                  });
            })
            ->whereIn('status', ['Vetted', 'Active'])
            ->orderBy('strategic_rank', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $alliance_heads = \App\Models\Member::with('chapter')->where(function($q) {
                $q->where('role', 'Alliance Head')
                  ->orWhereHas('memberRole', function($inner) {
                      $inner->where('role_name', 'Alliance Head');
                  });
            })
            ->whereIn('status', ['Vetted', 'Active'])
            ->orderBy('name', 'asc')
            ->get();

        $state_presidents = \App\Models\Member::with('chapter')->where(function($q) {
                $q->where('role', 'State President')
                  ->orWhereHas('memberRole', function($inner) {
                      $inner->where('role_name', 'State President');
                  });
            })
            ->whereIn('status', ['Vetted', 'Active'])
            ->orderBy('name', 'asc')
            ->get();

        $vice_presidents = \App\Models\Member::with('chapter')->where(function($q) {
                $q->where('role', 'Vice President')
                  ->orWhereHas('memberRole', function($inner) {
                      $inner->where('role_name', 'Vice President');
                  });
            })
            ->whereIn('status', ['Vetted', 'Active'])
            ->orderBy('name', 'asc')
            ->get();

        $board_members = \App\Models\Member::with('chapter')->where(function($q) {
                $q->where('role', 'Board Members')
                  ->orWhereHas('memberRole', function($inner) {
                      $inner->where('role_name', 'Board Members');
                  });
            })
            ->whereIn('status', ['Vetted', 'Active'])
            ->orderBy('name', 'asc')
            ->get();

        $advisors = \App\Models\Member::with('chapter')->where(function($q) {
                $q->where('role', 'Advisor')
                  ->orWhereHas('memberRole', function($inner) {
                      $inner->where('role_name', 'Advisor');
                  });
            })
            ->whereIn('status', ['Vetted', 'Active'])
            ->orderBy('name', 'asc')
            ->get();

        return view('about', [
            'title' => 'About IBSEA | International Business and Startup Association',
            'strategic_advisors' => $strategic_advisors,
            'board_members' => $board_members,
            'advisors' => $advisors,
            'alliance_heads' => $alliance_heads,
            'state_presidents' => $state_presidents,
            'vice_presidents' => $vice_presidents
        ]);
    }
}
