<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Show the member registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register', ['title' => 'Join the Alliance | IBSEA Registration']);
    }

    /**
     * Handle a member registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' => ['required', 'string', 'max:20'],
            'referral_code' => ['nullable', 'string', 'exists:members,referral_code'],
        ]);

        $referrerId = null;
        if ($request->referral_code) {
            $referrer = Member::where('referral_code', $request->referral_code)->first();
            if ($referrer) {
                $referrerId = $referrer->id;
                $referrer->increment('referral_count');
            }
        }

        $member = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'status' => 'Active',
            'referrer_id' => $referrerId,
        ]);

        Auth::guard('member')->login($member);

        return redirect('/user/dashboard');
    }
}
