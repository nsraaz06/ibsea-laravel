@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Refine Coupon</h2>
            <p class="text-slate-500 font-semibold italic">Strategic refinement of institutional discount code: <span class="text-accent underline decoration-2">{{ $coupon->code }}</span></p>
        </div>
        <a href="{{ route('admin.coupons.index') }}" class="bg-slate-100 text-slate-500 px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center gap-3">
            <span class="material-icons text-sm">arrow_back</span> Return to Hub
        </a>
    </header>

    <div class="max-w-4xl">
        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" class="bg-white rounded-[2.5rem] shadow-premium p-12 border border-slate-100">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Coupon Identity (Code)</label>
                    <input type="text" name="code" value="{{ old('code', $coupon->code) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-slate-700 focus:ring-2 focus:ring-accent transition-all uppercase" required>
                    @error('code') <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Discount Architecture</label>
                    <select name="type" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-slate-700 focus:ring-2 focus:ring-accent transition-all" required>
                        <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (INR)</option>
                        <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Value Magnitude</label>
                    <input type="number" name="value" value="{{ old('value', $coupon->value) }}" step="0.01" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-slate-700 focus:ring-2 focus:ring-accent transition-all" required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Minimum Commitment (Min Order)</label>
                    <input type="number" name="min_amount" value="{{ old('min_amount', $coupon->min_amount) }}" step="0.01" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-slate-700 focus:ring-2 focus:ring-accent transition-all" required>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Lifecycle Expiry</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date', $coupon->expiry_date ? $coupon->expiry_date->format('Y-m-d') : '') }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-slate-700 focus:ring-2 focus:ring-accent transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Usage Saturation (Limit)</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" placeholder="∞" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-slate-700 focus:ring-2 focus:ring-accent transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Operational Status</label>
                    <select name="status" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 font-bold text-slate-700 focus:ring-2 focus:ring-accent transition-all" required>
                        <option value="Active" {{ old('status', $coupon->status) == 'Active' ? 'selected' : '' }}>Active / Tactical</option>
                        <option value="Inactive" {{ old('status', $coupon->status) == 'Inactive' ? 'selected' : '' }}>Inactive / Suspended</option>
                    </select>
                </div>
            </div>

            <div class="mt-12 pt-10 border-t border-slate-50">
                <button type="submit" class="bg-primary text-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-accent shadow-premium transition-all flex items-center justify-center gap-3">
                    <span class="material-icons text-sm">save</span> Authorize Refinement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
