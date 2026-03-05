@extends('layouts.app')

@section('content')
<section class="relative pt-32 pb-24 overflow-hidden bg-slate-50 dark:bg-slate-900/50">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 lg:gap-20">
            
            <!-- Contact Info -->
            <div class="flex flex-col justify-center">
                <span class="w-fit px-4 py-1.5 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest mb-4">Get In Touch</span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white mb-8 leading-tight">Connect with the <span class="text-primary italic">IBSEA</span> Network.</h1>
                <p class="text-lg text-slate-500 dark:text-slate-400 font-medium mb-12 max-w-md">Whether you have a strategic inquiry, partnership proposal, or mission-related question, our team is ready to assist you.</p>
                
                <div class="space-y-8">
                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all transform group-hover:rotate-6">
                            <span class="material-icons">email</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Send an Email</p>
                            <a href="mailto:{{ $siteSettings['contact_email'] ?? 'contact@ibsea.in' }}" class="text-lg font-black text-slate-900 dark:text-white hover:text-primary transition-colors">{{ $siteSettings['contact_email'] ?? 'contact@ibsea.in' }}</a>
                        </div>
                    </div>

                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-all transform group-hover:-rotate-6">
                            <span class="material-icons">phone</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Call Our Desk</p>
                            <a href="tel:{{ $siteSettings['contact_phone'] ?? '+917651876071' }}" class="text-lg font-black text-slate-900 dark:text-white hover:text-orange-500 transition-colors">{{ $siteSettings['contact_phone'] ?? '+91 76518 76071' }}</a>
                        </div>
                    </div>

                    <div class="flex items-center gap-6 group">
                        <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all transform group-hover:rotate-6">
                            <span class="material-icons">location_on</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Visit Headquarters</p>
                            <p class="text-md font-bold text-slate-900 dark:text-white leading-tight">{!! nl2br(e($siteSettings['hq_address'] ?? "1/22, Asaf Ali Road,\nNew Delhi - 110001")) !!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form Card -->
            <div class="relative">
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-primary/10 rounded-full blur-3xl invisible md:visible"></div>
                <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700 p-8 md:p-12 relative z-10">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Message the Secretariat</h3>
                    <p class="text-slate-500 dark:text-slate-400 font-medium mb-8">We usually respond within 24 operational hours.</p>

                    @if(session('success'))
                        <div class="bg-green-500/10 text-green-500 p-4 rounded-2xl font-bold text-sm mb-6 border border-green-500/20 flex items-center gap-3">
                            <span class="material-icons">check_circle</span>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($contactForm)
                        <form action="{{ route('public.forms.submit', $contactForm->slug) }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Full Name</label>
                                    <input type="text" name="full_name" required class="w-full bg-slate-50 dark:bg-slate-900/50 border-none rounded-2xl px-6 py-4 outline-none focus:ring-2 ring-primary/20 text-slate-900 dark:text-white font-bold transition-all" placeholder="John Doe">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Mobile Number</label>
                                    <input type="text" name="mobile_number" required class="w-full bg-slate-50 dark:bg-slate-900/50 border-none rounded-2xl px-6 py-4 outline-none focus:ring-2 ring-primary/20 text-slate-900 dark:text-white font-bold transition-all" placeholder="+91 00000 00000">
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Email Address</label>
                                <input type="email" name="email_address" required class="w-full bg-slate-50 dark:bg-slate-900/50 border-none rounded-2xl px-6 py-4 outline-none focus:ring-2 ring-primary/20 text-slate-900 dark:text-white font-bold transition-all" placeholder="name@company.com">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Subject</label>
                                <input type="text" name="subject" required class="w-full bg-slate-50 dark:bg-slate-900/50 border-none rounded-2xl px-6 py-4 outline-none focus:ring-2 ring-primary/20 text-slate-900 dark:text-white font-bold transition-all" placeholder="Strategic Partnership Inquiry">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Message Body</label>
                                <textarea name="message" rows="4" required class="w-full bg-slate-50 dark:bg-slate-900/50 border-none rounded-2xl px-6 py-4 outline-none focus:ring-2 ring-primary/20 text-slate-900 dark:text-white font-bold transition-all" placeholder="Tell us more about your mission..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-primary text-white font-black py-5 rounded-2xl shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all text-xs uppercase tracking-[0.2em] flex items-center justify-center gap-3">
                                <span class="material-icons text-sm">send</span>
                                DISPATCH MESSAGE
                            </button>
                        </form>
                    @else
                        <!-- Simple Static Fallback if form not created yet -->
                        <div class="text-center py-10">
                            <p class="text-slate-400 font-bold mb-4 italic">Secretariat Form is being calibrated.</p>
                            <a href="mailto:{{ $siteSettings['contact_email'] ?? 'contact@ibsea.in' }}" class="inline-flex items-center gap-2 bg-primary text-white font-bold px-8 py-4 rounded-2xl shadow-xl shadow-primary/20">
                                <span class="material-icons">mail</span>
                                EMAIL SECRETARIAT
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Full Width Map Section -->
    <div class="w-full mt-24 mb-0 pb-0">
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.50377437395!2d77.22598909999999!3d28.6446309!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce783c0359839%3A0x18d119594d82143e!2sInternational%20Business%20Startup%20%26%20Entrepreneurs%20Association!5e0!3m2!1sen!2sin!4v1772358929423!5m2!1sen!2sin" width="100%" height="450" style="border:0; display: block;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>
@endsection

