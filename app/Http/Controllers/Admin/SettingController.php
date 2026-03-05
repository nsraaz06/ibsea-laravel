<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $optimizer;

    public function __construct(\App\Services\MediaOptimizerService $optimizer)
    {
        $this->optimizer = $optimizer;
    }

    public function index()
    {
        $settings = \App\Models\SiteSetting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function payment()
    {
        $settings = \App\Models\SiteSetting::all()->pluck('value', 'key');
        return view('admin.settings.payment', compact('settings'));
    }

    public function update(Request $request)
    {
        $featureKeys = ['allow_id_card_download', 'allow_certificate_download', 'allow_ticket_download', 'allow_referral_program', 'allow_course_cms'];
        $data = $request->except('_token');
        
        // Handle Favicon Upload
        if ($request->hasFile('favicon')) {
            $path = $this->optimizer->optimizeImage($request->file('favicon'), 'uploads/settings'); 
            \App\Models\SiteSetting::updateOrCreate(
                ['key' => 'favicon'],
                ['value' => $path]
            );
            unset($data['favicon']);
        }

        // Ensure feature keys are set to 0 if not present in request (unchecked)
        foreach ($featureKeys as $key) {
            if (!$request->has($key)) {
                $data[$key] = '0';
            }
        }
        
        foreach ($data as $key => $value) {
            \App\Models\SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        \Cache::forget('site_settings');

        return redirect()->back()->with('success', 'Portal settings updated successfully.');
    }
}
