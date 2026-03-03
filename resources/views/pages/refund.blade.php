@extends('layouts.app')

@section('content')
<section class="relative pt-32 pb-24 overflow-hidden bg-slate-50 dark:bg-slate-900/50">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 pointer-events-none opacity-20">
        <div class="absolute top-0 right-0 w-72 h-72 bg-red-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary/20 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <div class="flex flex-col items-center mb-12 text-center">
            <span class="px-4 py-1.5 rounded-full bg-red-500/10 text-red-500 text-[10px] font-black uppercase tracking-widest mb-4">Payment Protection</span>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-6 leading-tight">Refund Policy</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Transparency & Trust in every transaction</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700/50 p-8 md:p-12">
            <div class="prose prose-slate dark:prose-invert max-w-none space-y-8 text-slate-600 dark:text-slate-300">
                
                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 text-sm font-black">01</span>
                        Membership Fees
                    </h2>
                    <p class="leading-relaxed">Membership fees paid to IBSEA (Booster, Corporate Booster, etc.) are generally non-refundable once the membership status is activated and digital resources are accessed. However, if a payment was made by mistake and activation hasn't occurred, you may request a refund within 24 hours.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 text-sm font-black">02</span>
                        Event Tickets
                    </h2>
                    <p class="leading-relaxed">Tickets for IBSEA conferences and summits are non-refundable but are transferable to another member. To transfer your ticket, please contact our support team at least 48 hours before the event start time.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 text-sm font-black">03</span>
                        Processing Refunds
                    </h2>
                    <p class="leading-relaxed">Approved refunds will be processed within 7-10 working days and will be credited back to the original payment method used (Bank Account, UPI, or Card).</p>
                </section>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-slate-500 font-medium">Questions about a specific transaction? <a href="{{ url('/contact') }}" class="text-red-500 font-black hover:underline underline-offset-4">Contact Billing Support</a></p>
        </div>
    </div>
</section>
@endsection
