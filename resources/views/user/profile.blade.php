@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <main class="flex-1 overflow-y-auto p-4 md:p-12">
        <div class="max-w-5xl mx-auto space-y-12">
            <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">
                        <span class="material-icons text-xs">account_circle</span>
                        Public Identity
                    </div>
                    <h1 class="text-4xl font-black text-slate-800 dark:text-white uppercase tracking-tight">Professional Portfolio</h1>
                    <p class="text-slate-500 font-medium mt-2">How you appear to the IBSEA Global Network.</p>
                </div>
                <a href="{{ route('user.onboarding') }}" class="bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 px-6 py-3 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                    <span class="material-icons text-lg">edit</span>
                    Refine Identity
                </a>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Profile Card -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl overflow-hidden text-center p-12">
                        <div class="relative inline-block mb-8">
                            <div class="w-40 h-40 rounded-[2rem] overflow-hidden border-4 border-primary/10 mx-auto bg-slate-100 flex items-center justify-center">
                                @php
                                    $profilePath = $user->profile_image;
                                    $profileUrl = null;
                                    if ($profilePath) {
                                        if (str_starts_with($profilePath, 'uploads/') || str_starts_with($profilePath, '/uploads/')) {
                                            $profileUrl = asset($profilePath);
                                        } else {
                                            // Fallback to uploads/members which we confirmed exists
                                            $profileUrl = asset('uploads/members/' . $profilePath);
                                        }
                                    }
                                @endphp
                                @if($profileUrl)
                                    <img src="{{ $profileUrl }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-icons text-6xl text-slate-300">person</span>
                                @endif
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary/30">
                                <span class="material-icons text-xl">verified</span>
                            </div>
                        </div>

                        <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase leading-tight">{{ $user->name }}</h2>
                        <p class="text-primary font-black text-xs uppercase tracking-widest mt-2">{{ $user->profession }}</p>
                        
                        <div class="mt-8 pt-8 border-t border-slate-50 dark:border-slate-800 space-y-4">
                            <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400 font-bold text-sm">
                                <span class="material-icons text-primary/40">business</span>
                                {{ $user->industry }}
                            </div>
                            <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400 font-bold text-sm">
                                <span class="material-icons text-primary/40">place</span>
                                {{ $user->city }}, {{ $user->state_country }}
                            </div>
                        </div>

                        <div class="mt-8 flex justify-center gap-4">
                            @if($user->linkedin_url)
                                <a href="{{ $user->linkedin_url }}" target="_blank" class="w-10 h-10 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400 hover:text-primary transition-all">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            @endif
                            @if($user->website_url)
                                <a href="{{ $user->website_url }}" target="_blank" class="w-10 h-10 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400 hover:text-primary transition-all">
                                    <span class="material-icons text-base">language</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Membership Status -->
                    <div class="bg-primary rounded-[2.5rem] p-8 text-white shadow-xl shadow-primary/20">
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-2">ID: {{ $user->membership_id }}</p>
                        <h3 class="text-xl font-black uppercase tracking-tight mb-6">{{ $user->membershipPlan->title ?? 'IBSEA Associate' }}</h3>
                        <div class="bg-white/10 rounded-2xl p-4 flex items-center justify-between">
                            <div class="text-[10px] font-black uppercase tracking-widest opacity-80">Since {{ $user->created_at->format('M Y') }}</div>
                            <span class="material-icons text-xl">military_tech</span>
                        </div>
                    </div>
                </div>

                <!-- Biography & Data -->
                <div class="lg:col-span-2 space-y-12">
                    <section class="space-y-6">
                        <div class="flex items-center gap-4">
                            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Abridged Narrative</h3>
                            <div class="flex-1 h-px bg-slate-100 dark:bg-slate-800"></div>
                        </div>
                        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-10 prose dark:prose-invert max-w-none shadow-lg">
                            <p class="text-slate-600 dark:text-slate-400 font-medium leading-relaxed italic text-lg whitespace-pre-line">{{ $user->bio ?? 'No biography data provided.' }}</p>
                        </div>
                    </section>

                    <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Business Matrix</h3>
                                <div class="flex-1 h-px bg-slate-100 dark:bg-slate-800"></div>
                            </div>
                            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border border-slate-100 dark:border-slate-800 space-y-6 shadow-md">
                                <div>
                                    <p class="text-[9px] font-black uppercase tracking-widest text-primary mb-1">Entity Name</p>
                                    <p class="text-slate-800 dark:text-white font-black uppercase">{{ $user->business_name }}</p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black uppercase tracking-widest text-primary mb-1">Niche Category</p>
                                    <div class="inline-block px-3 py-1 bg-slate-100 dark:bg-slate-800 rounded-lg text-[10px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">
                                        {{ $user->business_category }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Elite Achievements</h3>
                                <div class="flex-1 h-px bg-slate-100 dark:bg-slate-800"></div>
                            </div>
                            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border border-slate-100 dark:border-slate-800 shadow-md">
                                <p class="text-slate-600 dark:text-slate-300 font-bold text-sm leading-relaxed">{{ $user->achievements ?? 'Establishing milestones...' }}</p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
