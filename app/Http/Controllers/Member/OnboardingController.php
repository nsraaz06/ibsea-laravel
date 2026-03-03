<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Chapter;
use App\Services\MediaOptimizerService;

class OnboardingController extends Controller
{
    protected $optimizer;

    public function __construct(MediaOptimizerService $optimizer)
    {
        $this->optimizer = $optimizer;
    }
    public function show()
    {
        $user = Auth::guard('member')->user();
        $chapters = Chapter::orderBy('name')->get();
        return view('user.onboarding.wizard', compact('user', 'chapters'), ['title' => 'Profile Mission | Onboarding']);
    }

    public function update(Request $request)
    {
        $user = Auth::guard('member')->user();
        
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'dob' => 'nullable|date',
            'chapter_id' => 'nullable|exists:chapters,id',
            'short_description' => 'nullable|string|max:150',
            'bio' => 'nullable|string',
            'industry' => 'nullable|string',
            'profession' => 'nullable|string',
            'business_category' => 'nullable|string',
            'linkedin_url' => 'nullable|url',
            'website_url' => 'nullable|url',
            'achievements' => 'nullable|string',
            'city' => 'nullable|string',
            'state_country' => 'nullable|string',
            'address_line' => 'nullable|string',
        ]);

        $data = $request->except(['_token', 'profile_image', 'step']);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $this->optimizer->optimizeImage($request->profile_image, 'uploads/profiles');
        }

        // Calculate if profile is complete
        $isComplete = ($user->profile_image || isset($data['profile_image'])) &&
                      ($user->short_description || !empty($data['short_description'])) &&
                      ($user->bio || !empty($data['bio'])) &&
                      ($user->industry || !empty($data['industry'])) &&
                      ($user->profession || !empty($data['profession']));

        $data['profile_completed'] = $isComplete ? 1 : 0;
        $data['status'] = 'Active';

        \App\Models\Member::where('id', $user->id)->update($data);

        if ($request->step == 'final') {
            return redirect()->route('user.dashboard')->with('success', 'Mission Dossier Updated Successfully!');
        }

        return response()->json(['success' => true]);
    }
}
