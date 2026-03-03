@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <main class="flex-1 overflow-y-auto p-4 md:p-12">
        <div class="max-w-4xl mx-auto space-y-12">
            <header>
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">
                    <span class="material-icons text-xs">settings</span>
                    Command Center
                </div>
                <h1 class="text-4xl font-black text-slate-800 dark:text-white uppercase tracking-tight">Account Settings</h1>
                <p class="text-slate-500 font-medium mt-2">Manage your passcodes, contact information and mission preferences.</p>
            </header>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-[1.5rem] relative mb-6 font-bold text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl overflow-hidden p-8 md:p-12">
                <form action="{{ route('user.settings.update') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Identity Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all dark:text-white" required>
                            @error('name') <p class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Secure Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all dark:text-white" required>
                            @error('email') <p class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">New Passcode (Leave blank if unchanged)</label>
                            <input type="password" name="password" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                            @error('password') <p class="text-red-500 text-[10px] font-bold ml-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm New Passcode</label>
                            <input type="password" name="password_confirmation" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-50 dark:border-slate-800 flex justify-end">
                        <button type="submit" class="bg-primary text-white px-10 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-lg shadow-primary/25">
                            Commit Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50 dark:bg-red-900/10 rounded-[2.5rem] border border-red-100 dark:border-red-900/20 p-8 md:p-12">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h2 class="text-lg font-black text-red-600 uppercase tracking-tight">Mission Termination</h2>
                        <p class="text-red-500/70 text-sm font-medium mt-1">If you wish to deactivate your IBSEA identity, please contact support.</p>
                    </div>
                    <button class="bg-white dark:bg-slate-900 text-red-500 border border-red-100 dark:border-red-900/20 px-8 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-red-50 transition-all">
                        Contact Command
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
