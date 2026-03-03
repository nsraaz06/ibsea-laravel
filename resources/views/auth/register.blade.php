@extends('layouts.app')

@push('styles')
<style>
    .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    .auth-bg { background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #7c2d12 100%); }
</style>
@endpush

@section('content')
<main class="auth-bg min-h-[calc(100vh-160px)] flex items-center justify-center p-6 bg-slate-100 dark:bg-slate-950">
    <div class="glass w-full max-w-2xl p-10 rounded-[2.5rem] shadow-2xl border border-white/20" data-aos="zoom-in">
        <div class="text-center mb-10">
            <div class="w-40 h-auto mx-auto mb-6">
                <img src="{{ asset('ibsea-text-33w-600x83.png.webp') }}" alt="IBSEA Logo" class="w-full h-auto">
            </div>
            <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight uppercase">Join <span class="text-orange-500">IBSEA</span></h1>
            <p class="text-slate-500 font-semibold text-sm">Become part of IBSEA — the world's most powerful startup ecosystem.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 border border-red-100 flex items-center gap-3 text-sm font-bold">
                <span class="material-icons">error_outline</span>
                <ul class="list-none p-0 m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Full Name</label>
                <div class="relative">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">person_outline</span>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe" 
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-4 py-4 font-bold text-slate-700 focus:border-orange-500 focus:bg-white outline-none transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Email Address</label>
                <div class="relative">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">alternate_email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com" 
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-4 py-4 font-bold text-slate-700 focus:border-orange-500 focus:bg-white outline-none transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Mobile Number</label>
                <div class="relative">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">call</span>
                    <input type="text" name="mobile" value="{{ old('mobile') }}" required placeholder="+91 00000 00000" 
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-4 py-4 font-bold text-slate-700 focus:border-orange-500 focus:bg-white outline-none transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Password</label>
                <div class="relative group">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-orange-500 transition-colors">lock</span>
                    <input type="password" name="password" id="password" required placeholder="••••••••" 
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-12 py-4 font-bold text-slate-700 focus:border-orange-500 focus:bg-white outline-none transition-all">
                    <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-orange-500 transition-colors">
                        <span class="material-icons text-lg" id="password-icon">visibility</span>
                    </button>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Confirm Password</label>
                <div class="relative group">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-orange-500 transition-colors">verified_user</span>
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••" 
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-12 py-4 font-bold text-slate-700 focus:border-orange-500 focus:bg-white outline-none transition-all">
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-orange-500 transition-colors">
                        <span class="material-icons text-lg" id="password_confirmation-icon">visibility</span>
                    </button>
                </div>
            </div>

            <div class="md:col-span-2 space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Referral Code (Optional)</label>
                <div class="relative group">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-orange-500 transition-colors">stars</span>
                    <input type="text" name="referral_code" value="{{ request('referral_code') ?? old('referral_code') }}" placeholder="IBS-XXXX" 
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-4 py-4 font-bold text-slate-700 focus:border-orange-500 focus:bg-white outline-none transition-all uppercase">
                </div>
            </div>

            <div class="md:col-span-2 space-y-4 pt-4">
                <button type="submit" class="w-full bg-slate-900 text-white font-black py-5 rounded-2xl shadow-xl hover:bg-slate-800 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 active:scale-95">
                    Create IBSEA Account <span class="material-icons text-xl">person_add</span>
                </button>
            </div>
        </form>

        <div class="mt-8 pt-8 border-t border-slate-100">
            <p class="text-center text-slate-500 font-bold text-sm">
                Already a part of IBSEA? <a href="{{ route('login') }}" class="text-orange-500 hover:underline">Login Now</a>
            </p>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById(id + '-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
</script>
@endpush
