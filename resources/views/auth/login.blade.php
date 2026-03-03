@extends('layouts.app')

@push('styles')
<style>
    .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    .auth-bg { background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #7c2d12 100%); }
</style>
@endpush

@section('content')
<main class="auth-bg min-h-[calc(100vh-160px)] flex items-center justify-center p-6 bg-slate-100 dark:bg-slate-950">
    <div class="glass w-full max-w-md p-10 rounded-[2.5rem] shadow-2xl border border-white/20" data-aos="zoom-in">
        <div class="text-center mb-10">
            <div class="w-32 h-auto mx-auto mb-6">
                <img src="{{ asset('ibsea-text-33w-600x83.png.webp') }}" alt="IBSEA Logo" class="w-full h-auto">
            </div>
            <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">One Stop Solution for Entrepreneurs</h1>
            <p class="text-slate-500 font-semibold text-sm">Empowering 1M+ Entrepreneurs</p>
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

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Email Address</label>
                <div class="relative">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">person_outline</span>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com" 
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

            <div class="flex items-center justify-between px-1">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-orange-500 border-slate-300 rounded focus:ring-orange-500">
                    <label for="remember" class="ml-2 text-xs font-bold text-slate-500">Remember Me</label>
                </div>
                <a href="{{ url('/password/reset') }}" class="text-xs font-bold text-blue-500 hover:text-orange-500 transition-all">Forgot Password?</a>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-black py-5 rounded-2xl shadow-xl hover:bg-slate-800 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 active:scale-95">
                Enter Dashboard <span class="material-icons text-xl">east</span>
            </button>
        </form>

        <div class="mt-8 flex flex-col gap-3">
            <div class="h-[1px] bg-slate-100 w-full my-2"></div>
            <p class="text-center text-slate-500 font-bold text-sm">
                New at IBSEA? <a href="{{ route('register') }}" class="text-orange-500 hover:underline">Register Now</a>
            </p>
        </div>

        <div class="mt-10 text-center">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest px-6">Vocal for Local, Local to Global</p>
            <div class="flex justify-center gap-4 mt-4 grayscale opacity-50">
                <span class="material-icons text-lg">public</span>
                <span class="material-icons text-lg">security</span>
                <span class="material-icons text-lg">trending_up</span>
            </div>
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
