@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Membership Architecture</h2>
            <p class="text-slate-500 font-semibold italic">Configure institutional tiers and value propositions.</p>
        </div>
        <a href="{{ route('admin.plans.create') }}" class="bg-accent text-white px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-primary shadow-lg shadow-accent/20 transition-all flex items-center gap-3">
            <span class="material-icons text-sm">add_circle</span> Design New Tier
        </a>
    </header>

    @if(session('success'))
    <div class="mb-8 bg-ibsea-green/10 border border-ibsea-green/20 text-ibsea-green p-4 rounded-2xl font-bold text-xs uppercase tracking-widest flex items-center gap-3">
        <span class="material-icons text-sm">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
        @forelse($plans as $plan)
        <div class="bg-white rounded-[2.5rem] shadow-premium border-t-8 border-primary overflow-hidden hover:-translate-y-2 transition-all group flex flex-col h-full">
            <div class="p-8 flex-grow">
                <div class="text-xs font-black text-accent uppercase tracking-[0.2em] mb-4">{{ $plan->tagline }}</div>
                <h3 class="text-2xl font-bold text-slate-800 mb-6">{{ $plan->title }}</h3>
                
                <div class="mb-8 p-6 bg-slate-50 rounded-3xl">
                    <div class="text-[10px] font-bold text-slate-400 uppercase mb-1">Fee Strategy</div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-3xl font-black text-primary">₹{{ number_format($plan->fee_numeric, 0) }}</span>
                        <span class="text-xs text-slate-400 font-bold">/ Cycle</span>
                    </div>
                </div>

                <ul class="space-y-4 mb-8">
                    @if($plan->benefits_json)
                        @foreach(array_slice($plan->benefits_json, 0, 3) as $benefit)
                        <li class="flex items-start gap-3">
                            <span class="material-icons text-ibsea-green text-lg">check_circle</span>
                            <span class="text-xs font-semibold text-slate-600 leading-tight">{{ $benefit }}</span>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="p-8 pt-0 flex flex-col gap-3">
                <a href="{{ route('admin.plans.edit', $plan->id) }}" class="w-full py-4 rounded-2xl border-2 border-primary/10 text-primary font-bold text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-primary hover:text-white transition-all">
                    Refine Intelligence <span class="material-icons text-sm">settings</span>
                </a>
                <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Decommission this tier permanently?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-4 rounded-2xl bg-slate-50 text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-red-500 hover:text-white transition-all">
                        Decommission <span class="material-icons text-sm">delete</span>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-24 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-200">
            <span class="material-icons text-6xl text-slate-200 mb-4">workspace_premium</span>
            <h3 class="text-xl font-bold text-slate-400">No Membership Plans Defined</h3>
        </div>
        @endforelse
    </div>
</div>
@endsection
