@extends('layouts.app')

@push('styles')
<style>
    .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    .admin-auth-bg { background: radial-gradient(circle at top right, #0f172a, #1e293b); }
</style>
@endpush

@section('content')
<main class="admin-auth-bg min-h-[calc(100vh-160px)] flex items-center justify-center p-6 bg-slate-900 border-t border-white/5">
    <div class="glass w-full max-w-md p-10 rounded-[2.5rem] shadow-2xl border border-white/10" data-aos="flip-left">
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 bg-slate-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] mb-6">
                <span class="material-icons text-xs text-primary">security</span>
                IBSEA Control
            </div>
            <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">IBSEA Admin Login</h1>
            <p class="text-slate-500 font-semibold text-sm">Secure administrative access only.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 border border-red-100 flex items-center gap-3 text-sm font-bold">
                <span class="material-icons">gpp_maybe</span>
                <ul class="list-none p-0 m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Admin Identity</label>
                <div class="relative">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">admin_panel_settings</span>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="commander@ibsea.org" 
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-4 py-4 font-bold text-slate-700 focus:border-primary focus:bg-white outline-none transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Access Key</label>
                <div class="relative group">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-primary transition-colors">key</span>
                    <input type="password" name="password" id="password" required placeholder="••••••••" 
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-12 pr-12 py-4 font-bold text-slate-700 focus:border-primary focus:bg-white outline-none transition-all">
                    <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition-colors">
                        <span class="material-icons text-lg" id="password-icon">visibility</span>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-black py-5 rounded-2xl shadow-xl hover:bg-black hover:-translate-y-1 transition-all flex items-center justify-center gap-3 active:scale-95">
                Authorize Access <span class="material-icons text-xl">verified_user</span>
            </button>
        </form>

        <div class="mt-8 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
            Identity verification required for all operations.
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
