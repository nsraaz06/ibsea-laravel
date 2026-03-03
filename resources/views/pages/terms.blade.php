@extends('layouts.app')

@section('content')
<section class="relative pt-32 pb-24 overflow-hidden bg-slate-50 dark:bg-slate-900/50">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 pointer-events-none opacity-20">
        <div class="absolute top-0 right-0 w-72 h-72 bg-orange-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary/20 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <div class="flex flex-col items-center mb-12 text-center">
            <span class="px-4 py-1.5 rounded-full bg-orange-500/10 text-orange-500 text-[10px] font-black uppercase tracking-widest mb-4">User Agreement</span>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-6 leading-tight">Terms & Conditions</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Agreement Version 2.0 | Effective March 2026</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700/50 p-8 md:p-12">
            <div class="prose prose-slate dark:prose-invert max-w-none space-y-8 text-slate-600 dark:text-slate-300">
                
                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 text-sm font-black">01</span>
                        Acceptance of Terms
                    </h2>
                    <p class="leading-relaxed">By accessing the IBSEA portal and using our services, you agree to be bound by these terms and conditions. These terms apply to all visitors, registered members, and others who access or use the Service.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 text-sm font-black">02</span>
                        Membership & Conduct
                    </h2>
                    <p class="leading-relaxed">Members must provide accurate information during registration. Sharing account credentials is strictly prohibited. IBSEA reserves the right to terminate membership if a member is found engaging in unethical business practices or behavior that damages the association's reputation.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 text-sm font-black">03</span>
                        Intellectual Property
                    </h2>
                    <p class="leading-relaxed">All content, resources, training materials, and digital assets provided by IBSEA are protected by copyright law. No part of these materials may be reproduced or shared outside the membership portal without explicit written permission.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 text-sm font-black">04</span>
                        Limitation of Liability
                    </h2>
                    <p class="leading-relaxed">IBSEA serves as a networking and strategic growth platform. While we provide business leads and training, we are not liable for individual business decisions or outcomes resulting from the use of our services.</p>
                </section>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-slate-500 font-medium">Looking for Refund details? <a href="{{ url('/refund-policy') }}" class="text-orange-500 font-black hover:underline underline-offset-4">Check Refund Policy</a></p>
        </div>
    </div>
</section>
@endsection
