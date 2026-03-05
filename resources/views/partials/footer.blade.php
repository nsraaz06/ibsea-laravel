
<footer class="bg-slate-900 border-t border-slate-800 text-slate-400 text-sm py-20 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-4 gap-16 mb-20">
            <div class="space-y-6">
                <img src="{{ asset('ibsea-text-33w-600x83.png.webp') }}" class="h-10" alt="IBSEA Logo" />
                <p class="font-medium leading-relaxed">The leading voice for international business and startups, driving growth through policy, partnership, and innovation.</p>
                <div class="flex gap-4">
                    <a href="{{ $siteSettings['facebook_link'] ?? '#' }}" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all"><i class="fa-brands fa-facebook"></i></a>
                    <a href="{{ $siteSettings['twitter_link'] ?? '#' }}" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all"><i class="fa-brands fa-twitter"></i></a>
                    <a href="{{ $siteSettings['linkedin_link'] ?? '#' }}" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-black uppercase tracking-widest text-[10px] mb-8">Quick Links</h4>
                <ul class="space-y-4 font-bold">
                    <li><a href="{{ url('/about') }}" class="hover:text-orange-500 transition-all">About Us</a></li>
                    <li><a href="{{ url('/leadership') }}" class="hover:text-orange-500 transition-all">Institutional Leadership</a></li>
                    <li><a href="{{ url('/events') }}" class="hover:text-orange-500 transition-all">Mission Events</a></li>
                    <li><a href="{{ route('public.verify-ticket') }}" class="hover:text-orange-500 transition-all">Verify Ticket</a></li>
                    <li><a href="{{ url('/membership') }}" class="hover:text-orange-500 transition-all">Membership Plans</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-black uppercase tracking-widest text-[10px] mb-8">Strategic Councils</h4>
                <ul class="space-y-4 font-bold">
                    <li><a href="#" class="hover:text-orange-500 transition-all">Tech & AI Mission</a></li>
                    <li><a href="#" class="hover:text-orange-500 transition-all">Women Empowerment</a></li>
                    <li><a href="#" class="hover:text-orange-500 transition-all">MSME Strategy</a></li>
                    <li><a href="#" class="hover:text-orange-500 transition-all">Global Trade Hub</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-black uppercase tracking-widest text-[10px] mb-8">Headquarters</h4>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <span class="material-icons text-orange-500">location_on</span>
                        <p class="font-bold">{!! nl2br(e($siteSettings['hq_address'] ?? "1/22,Asaf Ali Road,\nNew Delhi - 110001")) !!}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="material-icons text-orange-500">phone</span>
                        <p class="font-bold">{{ $siteSettings['contact_phone'] ?? '+91 76518 76071' }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="material-icons text-orange-500">email</span>
                        <p class="font-bold">{{ $siteSettings['contact_email'] ?? 'contact@ibsea.in' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-12 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-8">
            <p class="font-bold">© 2026 International Business Startup and Entrepreneurs Association. <span class="text-orange-500/50">IBSEA</span></p>
            <div class="flex flex-wrap gap-8 font-black uppercase text-[10px] tracking-[0.2em] mt-4 md:mt-0">
                <a href="{{ route('privacy') }}" class="hover:text-white transition-all">Privacy</a>
                <a href="{{ route('terms') }}" class="hover:text-white transition-all">Terms</a>
                <a href="{{ route('refund') }}" class="hover:text-white transition-all">Refunds</a>
                <a href="#" class="hover:text-white transition-all">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
