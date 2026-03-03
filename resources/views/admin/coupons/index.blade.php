@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Coupon Hub</h2>
            <p class="text-slate-500 font-semibold italic">Manage discount strategies and promotional codes.</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="bg-accent text-white px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-primary shadow-lg shadow-accent/20 transition-all flex items-center gap-3">
            <span class="material-icons text-sm">add_circle</span> Generate New Code
        </a>
    </header>

    @if(session('success'))
    <div class="mb-8 bg-ibsea-green/10 border border-ibsea-green/20 text-ibsea-green p-4 rounded-2xl font-bold text-xs uppercase tracking-widest flex items-center gap-3">
        <span class="material-icons text-sm">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
        @forelse($coupons as $coupon)
        <div class="bg-white rounded-[2.5rem] shadow-premium border-t-8 {{ $coupon->status == 'Active' ? 'border-ibsea-green' : 'border-slate-300' }} overflow-hidden hover:-translate-y-2 transition-all group flex flex-col h-full">
            <div class="p-8 flex-grow">
                <div class="flex justify-between items-start mb-4">
                    <div class="text-xs font-black text-accent uppercase tracking-[0.2em]">{{ $coupon->type == 'percent' ? 'Percentage' : 'Fixed' }} Discount</div>
                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $coupon->status == 'Active' ? 'bg-ibsea-green/10 text-ibsea-green' : 'bg-slate-100 text-slate-400' }}">
                        {{ $coupon->status }}
                    </span>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-6 font-mono">{{ $coupon->code }}</h3>
                
                <div class="mb-8 p-6 bg-slate-50 rounded-3xl">
                    <div class="text-[10px] font-bold text-slate-400 uppercase mb-1">Value Proposition</div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-3xl font-black text-primary">{{ $coupon->type == 'percent' ? $coupon->value . '%' : '₹' . number_format($coupon->value) }}</span>
                    </div>
                    <div class="mt-2 text-[10px] font-bold text-slate-500 uppercase tracking-tight">Min Order: ₹{{ number_format($coupon->min_amount) }}</div>
                </div>

                <div class="space-y-3 mb-4">
                    <div class="flex items-center gap-2 text-[10px] font-bold text-slate-500 uppercase">
                        <span class="material-icons text-sm">history</span>
                        Used: {{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}
                    </div>
                    @if($coupon->expiry_date)
                    <div class="flex items-center gap-2 text-[10px] font-bold {{ $coupon->expiry_date < now() ? 'text-red-500' : 'text-slate-500' }} uppercase">
                        <span class="material-icons text-sm">event_busy</span>
                        Expires: {{ $coupon->expiry_date->format('M d, Y') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="p-8 pt-0 flex flex-col gap-3">
                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="w-full py-4 rounded-2xl border-2 border-primary/10 text-primary font-bold text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-primary hover:text-white transition-all">
                    Refine Strategy <span class="material-icons text-sm">settings</span>
                </a>
                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Decommission this coupon permanently?')">
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
            <span class="material-icons text-6xl text-slate-200 mb-4">confirmation_number</span>
            <h3 class="text-xl font-bold text-slate-400">No Active Coupons in System</h3>
        </div>
        @endforelse
    </div>
</div>
@endsection
