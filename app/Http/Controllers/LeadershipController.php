<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Chapter;
use App\Models\Council;
use App\Models\MemberRole;
use Illuminate\Support\Facades\DB;

class LeadershipController extends Controller
{
    /**
     * Show the leadership hub page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $chapter_id = $request->get('chapter');
        $council_id = $request->get('council');
        $designation = $request->get('designation');
        $search = $request->get('search');

        $query = DB::table('members as m')
            ->leftJoin('chapters as c', 'm.chapter_id', '=', 'c.id')
            ->leftJoin('councils as co', 'm.council_id', '=', 'co.id')
            ->leftJoin('member_roles as r', 'm.role_id', '=', 'r.id')
            ->select('m.*', 'c.name as chapter_name', 'co.name as council_name', 'r.role_name as dynamic_role_name', 'r.hierarchy_level', 'r.card_display_pattern')
            ->whereIn('m.status', ['Vetted', 'Active']);

        if ($chapter_id) {
            $query->where('m.chapter_id', $chapter_id);
        }
        if ($council_id) {
            $query->where('m.council_id', $council_id);
        }
        if ($designation) {
            $query->where(function($q) use ($designation) {
                $q->where('m.role', $designation)
                  ->orWhere('r.role_name', $designation);
            });
        }
        if ($search) {
            $query->where('m.name', 'LIKE', '%' . $search . '%');
        }

        $leaders = $query->orderBy(DB::raw('CASE WHEN r.hierarchy_level IS NOT NULL THEN r.hierarchy_level ELSE 999 END'), 'ASC')
            ->orderBy('m.strategic_rank', 'ASC')
            ->orderBy('m.name', 'ASC')
            ->get();

        $chapters = Chapter::orderBy('name', 'asc')->get();
        $councils = Council::orderBy('name', 'asc')->get();
        $filter_roles = MemberRole::where('role_name', '!=', 'Member')
            ->orderBy('hierarchy_level', 'asc')
            ->pluck('role_name')
            ->toArray();

        // Fallback roles if DB is empty
        if (empty($filter_roles)) {
            $filter_roles = ['Chairman', 'Strategic Advisor', 'Advisor', 'State President', 'Vice President', 'Country President', 'Alliance Head', 'Mentor', 'Investor'];
        }

        return view('leadership', [
            'title' => 'Leadership Hub | IBSEA Visionaries',
            'leaders' => $leaders,
            'chapters' => $chapters,
            'councils' => $councils,
            'filter_roles' => $filter_roles,
            'filters' => [
                'chapter' => $chapter_id,
                'council' => $council_id,
                'designation' => $designation,
                'search' => $search
            ]
        ]);
    }
}
