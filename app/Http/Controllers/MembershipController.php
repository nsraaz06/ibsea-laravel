<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPlan;

class MembershipController extends Controller
{
    /**
     * Show the membership plans page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $plans = MembershipPlan::orderBy('fee_numeric', 'asc')->get();

        return view('membership', [
            'title' => 'Membership Plans | IBSEA Alliance',
            'plans' => $plans
        ]);
    }

    /**
     * Show the detailed view for a specific membership plan.
     *
     * @param  string  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $plan = MembershipPlan::findOrFail($id);

        return view('membership_details', [
            'title' => $plan->title . ' | IBSEA Alliance',
            'plan' => $plan
        ]);
    }
}
