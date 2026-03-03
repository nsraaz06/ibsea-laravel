@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-slate-900 pt-48 pb-20 px-6 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500 rounded-full -mr-48 -mt-48 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500 rounded-full -ml-32 -mb-32 blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto relative z-10 text-center">
        <div class="inline-flex items-center gap-3 mb-6">
            <span class="h-[1px] w-8 bg-orange-500"></span>
            <span class="text-orange-500 font-bold uppercase tracking-[0.3em] text-[10px]">Institutional Tier Details</span>
            <span class="h-[1px] w-8 bg-orange-500"></span>
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-white mb-6 uppercase tracking-tight">{{ $plan->title }}</h1>
        <p class="text-slate-400 max-w-2xl mx-auto text-lg font-medium leading-relaxed">
            {{ $plan->tagline ?? 'Comprehensive ecosystem integration for professional scaling.' }}
        </p>
    </div>
</section>

<main class="py-24 px-6 bg-gray-50 dark:bg-background-dark">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-3 gap-16">
            
            <!-- Left: Strategic Breakdown -->
            <div class="lg:col-span-2 space-y-12">
                <div class="bg-white dark:bg-slate-800 p-10 md:p-16 rounded-[2.5rem] shadow-premium border border-slate-100 dark:border-slate-700">
                    <h2 class="text-3xl font-black text-slate-800 dark:text-white mb-10 flex items-center gap-4 uppercase tracking-tight">
                        <span class="w-2 h-10 bg-orange-500 rounded-full"></span>
                        Executive Summary & Mission
                    </h2>
                    
                    <div class="grid md:grid-cols-2 gap-8 mb-16">
                        @foreach($plan->highlights_json ?? [] as $highlight)
                        <div class="p-8 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border border-slate-100 dark:border-slate-700">
                            <span class="material-icons text-orange-500 mb-4">stars</span>
                            <p class="text-slate-700 dark:text-slate-300 font-bold leading-relaxed">{{ $highlight }}</p>
                        </div>
                        @endforeach
                    </div>

                    <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-8 uppercase tracking-tight">Deep-Dive Benefits</h3>
                    <div class="space-y-6">
                        @foreach($plan->detailed_benefits_json ?? [] as $benefit)
                        <div class="flex items-start gap-4 p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 hover:border-orange-500/30 transition-all group">
                            <span class="material-icons text-green-500 group-hover:scale-110 transition-transform">verified_user</span>
                            <div class="text-slate-600 dark:text-slate-400 font-medium leading-relaxed">{{ $benefit }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Statistics / Impact -->
                @if($plan->stats_json)
                <div class="bg-slate-900 p-10 md:p-16 rounded-[2.5rem] shadow-premium text-white border border-white/5">
                    <h4 class="text-[10px] font-black text-orange-500 uppercase tracking-[0.2em] mb-12">Ecosystem Impact Metrics</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-12 gap-x-8">
                        @foreach($plan->stats_json as $stat)
                        @php
                            $val = is_array($stat) ? ($stat['value'] ?? '') : $stat;
                            $lbl = is_array($stat) ? ($stat['label'] ?? '') : '';
                            $icn = is_array($stat) ? ($stat['icon'] ?? 'rocket_launch') : 'stars';
                        @endphp
                        <div class="flex flex-col items-start gap-4">
                            <div class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center">
                                <span class="material-icons text-orange-500 text-2xl">{{ $icn }}</span>
                            </div>
                            <div>
                                <div class="text-xl font-bold text-white leading-none mb-2">{{ $val }}</div>
                                @if($lbl)
                                <div class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.15em] leading-relaxed">{{ $lbl }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Premium Features Grid -->
                <div class="space-y-8">
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white px-4 uppercase tracking-tight">Ecosystem Advantages</h3>
                    <div class="grid md:grid-cols-2 gap-8">
                        @foreach($plan->premium_features_json ?? [] as $feature)
                        <div class="bg-slate-900 p-10 rounded-[2.5rem] text-white shadow-premium relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full -mr-16 -mt-16 blur-2xl group-hover:bg-orange-500/20 transition-all"></div>
                            <span class="material-icons text-orange-500 text-4xl mb-6">rocket_launch</span>
                            <p class="text-white font-bold leading-relaxed relative z-10">{{ $feature }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right: Commercial Summary -->
            <div class="lg:col-span-1">
                <div class="sticky top-32 space-y-8">
                    <div class="bg-white dark:bg-slate-800 p-10 rounded-[2.5rem] shadow-premium border-t-8 border-orange-500 text-center">
                        <div class="mb-8 text-center flex flex-col items-center">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Institutional Fee</div>
                            <div class="flex items-baseline justify-center gap-1">
                                <span class="text-5xl font-black text-slate-900 dark:text-white">₹{{ number_format($plan->fee_numeric) }}</span>
                                <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">
                                    / {{ str_contains(strtolower($plan->title), 'lifetime') ? 'Lifetime' : ($plan->validity_days >= 365 ? 'Annual' : 'Cycle') }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4 mb-10">
                            @foreach(array_slice($plan->benefits_json ?? [], 0, 5) as $benefit)
                            <div class="flex items-center gap-3 text-xs font-bold text-slate-600 dark:text-slate-300 text-left">
                                <span class="material-icons text-orange-500 text-lg flex-shrink-0">check_circle</span>
                                {{ $benefit }}
                            </div>
                            @endforeach
                        </div>

                        <form action="{{ route('payment.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="Membership">
                            <input type="hidden" name="item_id" value="{{ $plan->id }}">
                            <button type="submit" class="block w-full text-center bg-slate-900 hover:bg-orange-500 text-white py-6 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-xl active:scale-95 flex items-center justify-center gap-2">
                                Authorize Join @if(auth('member')->check()) & Upgrade @endif
                                <span class="material-icons text-sm">arrow_forward</span>
                            </button>
                        </form>
                        
                        <p class="mt-6 text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed">
                            Secured via Institutional Gateway. <br> Instant Mission Activation upon verification.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
