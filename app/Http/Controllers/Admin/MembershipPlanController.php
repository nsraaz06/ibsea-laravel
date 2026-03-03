<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesignTemplate;
use Illuminate\Http\Request;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = \App\Models\MembershipPlan::all();
        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $idCardTemplates = DesignTemplate::where('type', 'id_card')->where('status', true)->get();
        $certificateTemplates = DesignTemplate::where('type', 'certificate')->where('status', true)->get();
        return view('admin.plans.create', compact('idCardTemplates', 'certificateTemplates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|unique:membership_plans,id',
            'title' => 'required|string|max:100',
            'fee_numeric' => 'required|numeric',
            'validity_days' => 'required|integer',
            'event_passes_limit' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        
        // Handle JSON fields
        $jsonFields = ['benefits_json', 'highlights_json', 'detailed_benefits_json', 'premium_features_json'];
        foreach ($jsonFields as $field) {
            if ($request->filled($field)) {
                $input = trim($request->input($field));
                // Handle complex JSON input
                if (str_starts_with($input, '[') || str_starts_with($input, '{')) {
                    $decoded = json_decode($input, true);
                    $data[$field] = is_array($decoded) ? $decoded : [];
                } else {
                    // Simple newline-separated list
                    $data[$field] = array_filter(array_map('trim', explode("\n", $input)));
                }
            } else {
                $data[$field] = [];
            }
        }

        // Dedicated Handling for Ecosystem Impact (stats_json)
        if ($request->filled('stats_json')) {
            $statsInput = array_filter(array_map('trim', explode("\n", $request->input('stats_json'))));
            $formattedStats = [];
            foreach ($statsInput as $line) {
                $parts = array_map('trim', explode('|', $line));
                $formattedStats[] = [
                    'value' => $parts[0] ?? '',
                    'label' => $parts[1] ?? ($parts[0] ?? ''),
                    'icon'  => $parts[2] ?? 'rocket_launch'
                ];
            }
            $data['stats_json'] = $formattedStats;
        } else {
            $data['stats_json'] = [];
        }

        \App\Models\MembershipPlan::create($data);

        return redirect()->route('admin.plans.index')->with('success', 'Membership plan designed successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = \App\Models\MembershipPlan::findOrFail($id);
        return view('admin.plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = \App\Models\MembershipPlan::findOrFail($id);
        $idCardTemplates = DesignTemplate::where('type', 'id_card')->where('status', true)->get();
        $certificateTemplates = DesignTemplate::where('type', 'certificate')->where('status', true)->get();
        
        // Prepare formatted strings for the form textareas
        $formData = [];
        $jsonFields = ['benefits_json', 'highlights_json', 'detailed_benefits_json', 'premium_features_json', 'stats_json'];
        foreach ($jsonFields as $field) {
            $value = $plan->$field;
            if (is_array($value)) {
                // Check if it's a complex array (containing other arrays)
                $isComplex = false;
                foreach ($value as $item) {
                    if (is_array($item)) { $isComplex = true; break; }
                }

                if ($isComplex) {
                    $formData[$field] = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                } else {
                    $formData[$field] = implode("\n", $value);
                }
            } else {
                $formData[$field] = '';
            }
        }

        return view('admin.plans.edit', compact('plan', 'formData', 'idCardTemplates', 'certificateTemplates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $plan = \App\Models\MembershipPlan::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:100',
            'fee_numeric' => 'required|numeric',
            'validity_days' => 'required|integer',
            'event_passes_limit' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        
        // Handle JSON fields
        $jsonFields = ['benefits_json', 'highlights_json', 'detailed_benefits_json', 'premium_features_json'];
        foreach ($jsonFields as $field) {
            if ($request->filled($field)) {
                $input = trim($request->input($field));
                // Handle complex JSON input
                if (str_starts_with($input, '[') || str_starts_with($input, '{')) {
                    $decoded = json_decode($input, true);
                    $data[$field] = is_array($decoded) ? $decoded : [];
                } else {
                    // Simple newline-separated list
                    $data[$field] = array_filter(array_map('trim', explode("\n", $input)));
                }
            } else {
                $data[$field] = [];
            }
        }

        // Dedicated Handling for Ecosystem Impact (stats_json)
        if ($request->filled('stats_json')) {
            $statsInput = array_filter(array_map('trim', explode("\n", $request->input('stats_json'))));
            $formattedStats = [];
            foreach ($statsInput as $line) {
                $parts = array_map('trim', explode('|', $line));
                $formattedStats[] = [
                    'value' => $parts[0] ?? '',
                    'label' => $parts[1] ?? ($parts[0] ?? ''),
                    'icon'  => $parts[2] ?? 'rocket_launch'
                ];
            }
            $data['stats_json'] = $formattedStats;
        } else {
            $data['stats_json'] = [];
        }

        $plan->update($data);

        return redirect()->route('admin.plans.index')->with('success', 'Membership plan refined successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = \App\Models\MembershipPlan::findOrFail($id);
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Membership plan decommissioned.');
    }
}
