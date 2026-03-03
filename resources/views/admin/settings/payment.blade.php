@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Payment Gateway Configuration</h2>
            <p class="text-slate-500 font-semibold italic">Manage your financial connectors and processing protocols.</p>
        </div>
    </header>

    @if(session('success'))
        <div class="bg-ibsea-green/10 text-ibsea-green p-8 rounded-[2.5rem] mb-10 border border-ibsea-green/20 flex items-center gap-4">
            <div class="w-10 h-10 bg-ibsea-green/20 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-icons">verified</span>
            </div>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white p-10 md:p-16 rounded-[2.5rem] shadow-premium border-t-8 border-accent relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
        
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-12 relative">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Gateway Selection -->
                <div class="md:col-span-2 space-y-8">
                    <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-accent"></span> Active Protocol
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <label class="flex items-center gap-4 p-6 rounded-3xl border-2 {{ ($settings['active_payment_gateway'] ?? 'cashfree') == 'cashfree' ? 'border-accent bg-orange-50/30' : 'border-slate-100 bg-white hover:border-slate-200' }} cursor-pointer transition-all group">
                            <input type="radio" name="active_payment_gateway" value="cashfree" {{ ($settings['active_payment_gateway'] ?? 'cashfree') == 'cashfree' ? 'checked' : '' }} class="hidden">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm border border-slate-100 group-hover:scale-110 transition-transform">
                                <span class="material-icons text-primary">account_balance_wallet</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight">Cashfree Payments</h4>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">Standard Indian Gateway</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-6 rounded-3xl border-2 {{ ($settings['active_payment_gateway'] ?? '') == 'razorpay' ? 'border-accent bg-orange-50/30' : 'border-slate-100 bg-white hover:border-slate-200' }} cursor-pointer transition-all group">
                            <input type="radio" name="active_payment_gateway" value="razorpay" {{ ($settings['active_payment_gateway'] ?? '') == 'razorpay' ? 'checked' : '' }} class="hidden">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm border border-slate-100 group-hover:scale-110 transition-transform">
                                <span class="material-icons text-primary" style="color: #3395FF;">bolt</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight">Razorpay</h4>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">Institutional High Speed</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-6 rounded-3xl border-2 {{ ($settings['active_payment_gateway'] ?? '') == 'manual' ? 'border-accent bg-orange-50/30' : 'border-slate-100 bg-white hover:border-slate-200' }} cursor-pointer transition-all group">
                            <input type="radio" name="active_payment_gateway" value="manual" {{ ($settings['active_payment_gateway'] ?? 'manual') == 'manual' ? 'checked' : '' }} class="hidden">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm border border-slate-100 group-hover:scale-110 transition-transform">
                                <span class="material-icons text-primary" style="color: #64748b;">contact_support</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight">Inquiry / Manual</h4>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">Direct Team Support</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Cashfree Configuration -->
                <div class="space-y-8 p-10 bg-slate-50/50 rounded-[2.5rem] border border-slate-100">
                    <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-primary/20"></span> Cashfree Intelligence
                    </h3>
                    
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">App ID</label>
                        <input type="text" name="cashfree_app_id" value="{{ $settings['cashfree_app_id'] ?? '' }}" class="w-full bg-white border border-slate-100 rounded-xl px-6 py-4 text-xs font-bold text-slate-800 focus:ring-4 focus:ring-primary/10 transition-all shadow-sm">
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Secret Key</label>
                        <input type="password" name="cashfree_secret_key" value="{{ $settings['cashfree_secret_key'] ?? '' }}" class="w-full bg-white border border-slate-100 rounded-xl px-6 py-4 text-xs font-bold text-slate-800 focus:ring-4 focus:ring-primary/10 transition-all shadow-sm">
                    </div>
                </div>

                <!-- Razorpay Configuration -->
                <div class="space-y-8 p-10 bg-blue-50/30 rounded-[2.5rem] border border-blue-100">
                    <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-blue-500/20"></span> Razorpay Intelligence
                    </h3>
                    
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">API Key ID</label>
                        <input type="text" name="razorpay_key_id" value="{{ $settings['razorpay_key_id'] ?? '' }}" class="w-full bg-white border border-slate-100 rounded-xl px-6 py-4 text-xs font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/10 transition-all shadow-sm">
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Key Secret</label>
                        <input type="password" name="razorpay_key_secret" value="{{ $settings['razorpay_key_secret'] ?? '' }}" class="w-full bg-white border border-slate-100 rounded-xl px-6 py-4 text-xs font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/10 transition-all shadow-sm">
                    </div>
                </div>

                <!-- Environment Control -->
                <div class="md:col-span-2 space-y-8 pt-6 border-t border-slate-50 text-center">
                    <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] flex items-center justify-center gap-3">
                        <span class="w-8 h-[2px] bg-accent"></span> Production Environment
                    </h3>
                    
                    <div class="flex justify-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="payment_mode" value="PRODUCTION" class="sr-only peer" {{ ($settings['payment_mode'] ?? 'SANDBOX') == 'PRODUCTION' ? 'checked' : '' }}>
                            <div class="w-24 h-10 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-[56px] peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-8 after:w-8 after:transition-all peer-checked:bg-ibsea-green flex items-center justify-between px-4">
                                <span class="text-[9px] font-black text-slate-400 uppercase">SBX</span>
                                <span class="text-[9px] font-black text-white uppercase opacity-0 peer-checked:opacity-100">PRD</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-10 flex justify-end">
                <button type="submit" class="bg-primary text-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:bg-accent hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-4">
                    Commit Protocol Changes <span class="material-icons text-sm">save_as</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Reset all labels in the grid
            document.querySelectorAll('label.cursor-pointer').forEach(l => {
                l.classList.remove('border-accent', 'bg-orange-50/30');
                l.classList.add('border-slate-100', 'bg-white');
            });
            // Highlight selected
            if (this.checked) {
                const label = this.closest('label');
                label.classList.add('border-accent', 'bg-orange-50/30');
                label.classList.remove('border-slate-100', 'bg-white');
            }
        });
    });
</script>
@endsection
