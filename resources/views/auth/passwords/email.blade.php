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
            <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">Access Recovery</h1>
            <p class="text-slate-500 font-semibold text-sm">Regain control of your mission dashboard</p>
        </div>

        @if (session('status'))
            <div class="bg-green-50 text-green-600 p-4 rounded-2xl mb-6 border border-green-100 flex items-center gap-3 text-sm font-bold">
                <span class="material-icons">check_circle</span>
                {{ session('status') }}
            </div>
        @endif

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

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Institutional Email</label>
                <div class="relative">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com" 
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-4 py-4 font-bold text-slate-700 focus:border-orange-500 focus:bg-white outline-none transition-all">
                </div>
                <p class="text-[10px] font-bold text-slate-400 px-1 italic">Enter the email associated with your IBSEA member account</p>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-black py-5 rounded-2xl shadow-xl hover:bg-slate-800 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 active:scale-95">
                Send Recovery Link <span class="material-icons text-xl">send</span>
            </button>
        </form>

        <div class="mt-8 flex flex-col gap-3">
            <div class="h-[1px] bg-slate-100 w-full my-2"></div>
            <p class="text-center text-slate-500 font-bold text-sm">
                Remember your password? <a href="{{ route('login') }}" class="text-orange-500 hover:underline">Back to Login</a>
            </p>
        </div>

        <div class="mt-10 text-center">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest px-6 italic">Secure Access Control Protocol</p>
        </div>
    </div>
</main>
@endsection
