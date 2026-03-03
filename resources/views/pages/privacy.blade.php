@extends('layouts.app')

@section('content')
<section class="relative pt-32 pb-24 overflow-hidden bg-slate-50 dark:bg-slate-900/50">
    <!-- Header Decor -->
    <div class="absolute top-0 left-1/2 -translate_x_1/2 w-full max-w-7xl h-96 pointer-events-none opacity-20">
        <div class="absolute top-0 left-0 w-72 h-72 bg-primary/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-orange-500/20 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <!-- Breadcrumb & Badge -->
        <div class="flex flex-col items-center mb-12 text-center">
            <span class="px-4 py-1.5 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest mb-4">Legal Compliance</span>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-6 leading-tight">Privacy Policy</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Last Updated: March 2026</p>
        </div>

        <!-- Content Card -->
        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700/50 p-8 md:p-12">
            <div class="prose prose-slate dark:prose-invert max-w-none space-y-8 text-slate-600 dark:text-slate-300">
                
                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary text-sm font-black">01</span>
                        Information We Collect
                    </h2>
                    <p class="leading-relaxed">IBSEA collects information to provide better services to our members. This includes personal identification information (name, email, mobile, address), business details for MSME strategy, and payment information processed through secure gateways like Razorpay or Cashfree.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary text-sm font-black">02</span>
                        How We Use Your Data
                    </h2>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>To manage your membership and provide access to exclusive resources.</li>
                        <li>To process event registrations and issue digital tickets.</li>
                        <li>To send periodic newsletters, strategic updates, and mission alerts.</li>
                        <li>To improve our platform features and user experience.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary text-sm font-black">03</span>
                        Data Protection & Security
                    </h2>
                    <p class="leading-relaxed">We implement a variety of security measures to maintain the safety of your personal information. Your sensitive data is encrypted using Secure Socket Layer (SSL) technology. We never sell, trade, or otherwise transfer your personally identifiable information to outside parties.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary text-sm font-black">04</span>
                        Cookies Policy
                    </h2>
                    <p class="leading-relaxed">Our platform uses cookies to understand and save your preferences for future visits and compile aggregate data about site traffic and interaction so that we can offer better site experiences and tools in the future.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-4 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary text-sm font-black">05</span>
                        Contact Privacy Officer
                    </h2>
                    <p class="leading-relaxed">If there are any questions regarding this privacy policy, you may contact our data protection team at <strong>privacy@ibsea.in</strong>.</p>
                </section>
            </div>
        </div>

        <!-- Quick Help -->
        <div class="mt-12 text-center">
            <p class="text-slate-500 font-medium">Need more clarification? <a href="{{ url('/contact') }}" class="text-primary font-black hover:underline underline-offset-4">Read our Terms or Contact Support</a></p>
        </div>
    </div>
</section>
@endsection
