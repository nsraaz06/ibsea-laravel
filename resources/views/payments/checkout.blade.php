@extends('layouts.app')

@section('content')
<div class="bg-slate-50 dark:bg-slate-950 min-h-screen pt-32 pb-20 px-6">
    <div class="max-w-5xl mx-auto">
        <div class="mb-12 text-center" data-aos="fade-up">
            <h1 class="text-4xl font-black text-slate-900 dark:text-white mb-4 uppercase tracking-tight">Secure <span class="text-orange-500">Checkout</span></h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium tracking-wide">Confirm your details and verify your mission investment.</p>
        </div>

        <div class="grid lg:grid-cols-5 gap-10 items-start">
            <!-- Order Summary -->
            <div class="lg:col-span-2 space-y-6" data-aos="fade-right">
                <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                    
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-500 mb-8">Initiative Summary</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Item / Plan</p>
                            <p class="text-xl font-black leading-tight uppercase">{{ $item_name }}</p>
                        </div>

                        <div class="pt-6 border-t border-white/10">
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Investment</p>
                                    <p class="text-3xl font-black text-orange-500">{{ $currency_symbol ?? '₹' }}{{ number_format($amount) }}</p>
                                </div>
                                <div class="bg-white/5 px-3 py-1 rounded-lg border border-white/5">
                                    <span class="text-[10px] font-black uppercase tracking-widest opacity-60">Verified</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex items-center gap-3 text-[10px] font-black text-slate-500 uppercase tracking-[0.15em]">
                        <span class="material-icons text-sm text-green-500">verified_user</span>
                        Secure SSL Encrypted Checkout
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900/50 p-8 rounded-3xl border border-slate-100 dark:border-slate-800">
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                        <span class="font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">Notice:</span> 
                        By proceeding, you agree to IBSEA's terms of service. All payments are processed securely via Cashfree Gateway.
                    </p>
                </div>
            </div>

            <!-- Verification Form -->
            <div class="lg:col-span-3" data-aos="fade-left">
                <form action="{{ route('payment.initiate') }}" method="POST" class="bg-white dark:bg-slate-900 p-10 md:p-14 rounded-[3rem] shadow-premium border border-slate-100 dark:border-slate-800 space-y-8">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="item_id" value="{{ $item_id }}">

                    <div class="space-y-8">
                        @if($type === 'Event' && $user && ($remaining_passes > 0 || $pass_error))
                            <div class="p-6 rounded-3xl border {{ $can_use_pass ? 'bg-primary/5 border-primary/20' : 'bg-red-50 dark:bg-red-900/10 border-red-100 dark:border-red-900/20' }} space-y-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 {{ $can_use_pass ? 'bg-primary text-white' : 'bg-red-100 text-red-500' }} rounded-2xl flex items-center justify-center shadow-lg">
                                        <span class="material-icons">{{ $can_use_pass ? 'auto_awesome' : 'block' }}</span>
                                    </div>
                                    <div>
                                        <h4 class="text-[11px] font-black {{ $can_use_pass ? 'text-primary' : 'text-red-500' }} uppercase tracking-[0.2em]">Membership Pass Eligibility</h4>
                                        <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400">
                                            @if($can_use_pass)
                                                You have <b>{{ $remaining_passes }}</b> free event passes remaining this cycle.
                                            @else
                                                {{ $pass_error }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                @if($can_use_pass)
                                    <label class="flex items-center justify-between cursor-pointer group bg-white dark:bg-slate-950 p-5 rounded-2xl border border-primary/20 hover:border-primary transition-all shadow-sm mt-4">
                                        <div class="flex items-center gap-4">
                                            <div class="relative inline-flex items-center">
                                                <input type="checkbox" name="use_membership_pass" id="use_membership_pass" value="1" class="sr-only peer">
                                                <div class="w-12 h-7 bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-primary after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all shadow-inner"></div>
                                            </div>
                                            <div>
                                                <div class="text-[11px] font-black text-slate-800 dark:text-white uppercase tracking-widest">Redeem Free Pass</div>
                                                <div class="text-[10px] font-semibold text-slate-500">Apply one pass for this session</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-black text-primary uppercase tracking-widest">Free Booking</span>
                                        </div>
                                    </label>
                                @endif
                            </div>
                        @endif

                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-1">Billing Name</label>
                            <div class="relative group">
                                <span class="material-icons absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors">person</span>
                                <input type="text" name="name" required value="{{ old('name', $user->name ?? '') }}" 
                                       placeholder="Full Name as per records"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-14 py-5 font-bold text-slate-800 dark:text-white focus:border-orange-500 focus:bg-white dark:focus:bg-slate-950 outline-none transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 shadow-sm">
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-1">Active Email</label>
                            <div class="relative group">
                                <span class="material-icons absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors">email</span>
                                <input type="email" name="email" required value="{{ old('email', $user->email ?? '') }}" 
                                       placeholder="you@example.com"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-14 py-5 font-bold text-slate-800 dark:text-white focus:border-orange-500 focus:bg-white dark:focus:bg-slate-950 outline-none transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 shadow-sm">
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-1">Primary Mobile</label>
                            <div class="relative group">
                                <span class="material-icons absolute left-5 top-1/2 -translate-y-1/2 text language-400 group-focus-within:text-orange-500 transition-colors">phone</span>
                                <input type="tel" name="mobile" required pattern="[0-9]{10,15}" title="Enter valid mobile with 10-15 digits" 
                                       value="{{ old('mobile', $user->mobile ?? '') }}" 
                                       placeholder="919876543210"
                                       class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-14 py-5 font-bold text-slate-800 dark:text-white focus:border-orange-500 focus:bg-white dark:focus:bg-slate-950 outline-none transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 shadow-sm">
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 px-1 italic">Include country code without +</p>
                        </div>

                        <!-- Referral Attribution -->
                        <div class="space-y-6 pt-4 border-t border-slate-50 dark:border-slate-800/50">
                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-1">Referral ID (Optional)</label>
                                <div class="relative group">
                                    <span class="material-icons absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors">redeem</span>
                                    <input type="text" name="referral_code" value="{{ old('referral_code') }}" 
                                           placeholder="IBS-XXXX"
                                           class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-14 py-5 font-bold text-slate-800 dark:text-white focus:border-orange-500 focus:bg-white dark:focus:bg-slate-950 outline-none transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 shadow-sm uppercase">
                                </div>
                            </div>

                            <!-- Coupon System Section -->
                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-1">Coupon Code</label>
                                <div class="flex gap-3">
                                    <div class="relative group flex-1">
                                        <span class="material-icons absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors">confirmation_number</span>
                                        <input type="text" id="coupon_code_input" name="coupon_code" value="{{ old('coupon_code') }}" 
                                               placeholder="Enter code"
                                               class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-100 dark:border-slate-800 rounded-2xl px-14 py-5 font-bold text-slate-800 dark:text-white focus:border-orange-500 focus:bg-white dark:focus:bg-slate-950 outline-none transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 shadow-sm uppercase">
                                    </div>
                                    <button type="button" id="apply_coupon_btn" class="bg-slate-900 text-white px-8 py-5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition-all active:scale-95 disabled:opacity-50">
                                        Apply
                                    </button>
                                </div>
                                <div id="coupon_message" class="text-[10px] font-bold px-1 hidden"></div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-6 rounded-2xl shadow-xl shadow-orange-500/20 transition-all flex items-center justify-center gap-4 text-xs uppercase tracking-[0.2em] active:scale-95 group">
                            Finalize and Pay Securely
                            <span class="material-icons group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const applyBtn = document.getElementById('apply_coupon_btn');
    const couponInput = document.getElementById('coupon_code_input');
    const messageDiv = document.getElementById('coupon_message');
    const amountDisplay = document.querySelector('.text-3xl.font-black.text-orange-500');
    
    const passToggle = document.getElementById('use_membership_pass');
    const originalAmount = {{ $amount }};
    const currencySymbol = '{{ $currency_symbol ?? '₹' }}';

    if (passToggle) {
        passToggle.addEventListener('change', function() {
            if (this.checked) {
                amountDisplay.innerText = currencySymbol + '0';
                couponInput.value = '';
                couponInput.disabled = true;
                applyBtn.disabled = true;
                messageDiv.classList.add('hidden');
                const badge = document.getElementById('discount_badge');
                if (badge) badge.remove();

                const passBadge = document.createElement('p');
                passBadge.id = 'pass_applied_badge';
                passBadge.className = 'text-[10px] font-black text-primary uppercase tracking-widest mt-1';
                passBadge.innerText = 'Redeeming Membership Pass';
                amountDisplay.parentNode.appendChild(passBadge);
            } else {
                amountDisplay.innerText = currencySymbol + new Intl.NumberFormat().format(originalAmount);
                couponInput.disabled = false;
                applyBtn.disabled = false;
                const passBadge = document.getElementById('pass_applied_badge');
                if (passBadge) passBadge.remove();
            }
        });
    }

    applyBtn.addEventListener('click', async function() {
        const code = couponInput.value.trim();
        if (!code) return;

        applyBtn.disabled = true;
        applyBtn.innerText = 'Checking...';
        messageDiv.classList.add('hidden');

        try {
            const response = await fetch('{{ route('coupon.apply') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    code: code,
                    type: '{{ $type }}',
                    item_id: '{{ $item_id }}'
                })
            });

            const data = await response.json();

            if (data.success) {
                messageDiv.innerText = data.message;
                messageDiv.classList.remove('hidden', 'text-red-500');
                messageDiv.classList.add('text-green-500');
                
                // Update Amount Display
                amountDisplay.innerText = currencySymbol + new Intl.NumberFormat().format(data.final_amount);
                
                // Optional: Add a "Discount Applied" badge
                if (!document.getElementById('discount_badge')) {
                    const badge = document.createElement('p');
                    badge.id = 'discount_badge';
                    badge.className = 'text-[10px] font-black text-green-500 uppercase tracking-widest mt-1';
                    badge.innerText = `- ${currencySymbol}${new Intl.NumberFormat().format(data.discount)} Discount Applied`;
                    amountDisplay.parentNode.appendChild(badge);
                } else {
                    document.getElementById('discount_badge').innerText = `- ${currencySymbol}${new Intl.NumberFormat().format(data.discount)} Discount Applied`;
                }

                applyBtn.innerText = 'Applied';
                couponInput.readOnly = true;
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            messageDiv.innerText = error.message || 'Something went wrong.';
            messageDiv.classList.remove('hidden', 'text-green-500');
            messageDiv.classList.add('text-red-500');
            applyBtn.innerText = 'Apply';
        } finally {
            applyBtn.disabled = false;
        }
    });

    // Reset if user clears input
    couponInput.addEventListener('input', function() {
        if (!this.value.trim() && !this.readOnly) {
            messageDiv.classList.add('hidden');
            amountDisplay.innerText = currencySymbol + new Intl.NumberFormat().format(originalAmount);
            const badge = document.getElementById('discount_badge');
            if (badge) badge.remove();
        }
    });
});
</script>
@endpush
