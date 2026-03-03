@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-slate-900 pt-32 pb-20 px-6 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500 rounded-full -mr-48 -mt-48 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500 rounded-full -ml-32 -mb-32 blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto relative z-10 text-center">
        <div class="inline-flex items-center gap-3 mb-6">
            <span class="h-[1px] w-8 bg-orange-500"></span>
            <span class="text-orange-500 font-bold uppercase tracking-[0.3em] text-[10px]">Join the Inner Circle</span>
            <span class="h-[1px] w-8 bg-orange-500"></span>
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-white mb-6 uppercase tracking-tight">Become an <span class="text-orange-500">IBSEA Member</span></h1>
        <p class="text-slate-400 max-w-2xl mx-auto text-lg font-medium leading-relaxed">
            Select a plan that aligns with your professional journey and unlock exclusive ecosystem benefits within the IBSEA Alliance.
        </p>
    </div>
</section>

<!-- Membership Plans Grid -->
<section class="py-24 px-6 bg-gray-50 dark:bg-background-dark">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($plans as $plan)
                <div id="{{ $plan->id }}" class="bg-white dark:bg-slate-800 rounded-3xl p-10 border border-slate-100 dark:border-slate-700 shadow-xl hover:shadow-2xl transition-all group relative overflow-hidden flex flex-col">
                    @if($plan->is_featured)
                        <div class="absolute top-0 right-0 bg-orange-500 text-white text-[10px] font-black uppercase px-4 py-1.5 rounded-bl-xl tracking-widest shadow-lg">Most Popular</div>
                    @endif
                    <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase mb-2">{{ $plan->title }}</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">{{ $plan->tagline ?? 'Professional Tier' }}</p>
                    
                    <div class="flex items-baseline gap-1 mb-8">
                        <span class="text-4xl font-black text-orange-500">{{ $plan->currency_symbol ?? '₹' }}{{ number_format($plan->fee_numeric) }}</span>
                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                            / {{ str_contains(strtolower($plan->title), 'lifetime') ? 'Lifetime' : ($plan->validity_days >= 365 ? 'Annual' : 'Cycle') }}
                        </span>
                    </div>
                    
                    <ul class="space-y-4 mb-10 flex-grow">
                        @foreach($plan->benefits_json ?? [] as $benefit)
                            <li class="flex items-start gap-3 text-sm text-slate-600 dark:text-slate-400 font-medium">
                                <span class="material-icons text-orange-500 text-lg flex-shrink-0">check_circle</span>
                                <span class="leading-tight">{{ $benefit }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-auto space-y-3">
                        <a href="{{ route('membership.show', $plan->id) }}" class="block w-full text-center border-2 border-slate-100 dark:border-slate-700 text-slate-500 dark:text-slate-400 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center justify-center gap-2">
                             Know More <span class="material-icons text-sm">visibility</span>
                        </a>

                        <form action="{{ route('payment.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="Membership">
                            <input type="hidden" name="item_id" value="{{ $plan->id }}">
                            <button type="submit" class="block w-full text-center bg-slate-900 group-hover:bg-orange-500 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-slate-900/10 active:scale-95 flex items-center justify-center gap-2">
                                @if(auth('member')->check()) Upgrade Now @else Get Started @endif
                                <span class="material-icons text-sm">arrow_forward</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
