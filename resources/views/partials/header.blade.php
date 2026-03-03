@php
    $is_logged_in = Auth::guard('member')->check();
    $member = Auth::guard('member')->user();
    $unread_count = $is_logged_in ? \App\Models\Notification::where('user_id', $member->id)->where('is_read', false)->count() : 0;
@endphp

<!-- Header -->
<header class="contact-info flex items-center justify-between bg-gray-800 z-[999] h-10 text-white px-5">
    <div class="flex gap-4 items-center text-sm">
        <p class="flex items-center gap-2">
            <i class="fa-solid fa-envelope"></i>
            <a href="mailto:{{ $siteSettings['site_email'] ?? 'contact@ibsea.in' }}" class="hover:text-orange-500 transition-colors">{{ $siteSettings['site_email'] ?? 'contact@ibsea.in' }}</a>
        </p>
        <p class="hidden md:flex items-center gap-2">
            <i class="fa-solid fa-phone"></i>
            <a href="tel:{{ $siteSettings['site_phone'] ?? '+917651876071' }}" class="hover:text-orange-500 transition-colors">{{ $siteSettings['site_phone'] ?? '+91 76518 76071' }}</a>
        </p>
    </div>
    <div class="flex gap-4 text-sm items-center">
        <a href="{{ $siteSettings['facebook_url'] ?? '#' }}" class="hover:text-orange-500 transition-all"><i class="fa-brands fa-facebook"></i></a>
        <a href="{{ $siteSettings['twitter_url'] ?? '#' }}" class="hover:text-orange-500 transition-all"><i class="fa-brands fa-twitter"></i></a>
        <a href="{{ $siteSettings['instagram_url'] ?? '#' }}" class="hover:text-orange-500 transition-all"><i class="fa-brands fa-instagram"></i></a>
        <a href="{{ $siteSettings['linkedin_url'] ?? '#' }}" class="hover:text-orange-500 transition-all"><i class="fa-brands fa-linkedin"></i></a>
        <button id="darkModeToggle" class="w-8 h-8 rounded-xl flex items-center justify-center bg-white/5 hover:bg-white/10 transition-all ml-2 border border-white/10">
            <span class="material-symbols-outlined text-sm">dark_mode</span>
        </button>
    </div>
</header>
<style>
    #darkModeToggle .material-symbols-outlined { font-size: 18px; }
</style>

<nav class="primary_nav sticky top-0 z-[998] bg-white backdrop-blur-md border-b border-slate-100 dark:bg-slate-900/95 dark:border-slate-800 transition-all duration-300">
    <div class="mx-auto flex items-center justify-between px-4 md:px-6 py-4">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('ibsea-text-33w-600x83.png.webp') }}" class="h-8 md:h-12" alt="IBSEA Logo" />
        </a>

        <div class="flex items-center md:order-2 gap-2 md:gap-4 shrink-0">
            @if ($is_logged_in)
                <div class="flex items-center gap-1 md:gap-6">

                    
                    <a href="{{ url('/user/notifications') }}" class="relative p-2 text-slate-400 hover:text-orange-500 transition-colors">
                        <span class="material-icons">notifications</span>
                        @if($unread_count > 0)
                            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                        @endif
                    </a>

                    <div class="relative flex items-center gap-1 md:gap-3">

                        <div class="relative group/profile dropdown-container">
                            <button id="profileDropdownBtn" class="flex items-center gap-2 group relative">
                                @if(!empty($member->profile_image))
                                    <img src="{{ asset($member->profile_image) }}" class="w-10 h-10 rounded-full border-2 border-primary object-cover group-hover:scale-105 transition-transform" />
                                @else
                                    <div class="w-10 h-10 rounded-full border-2 border-primary bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-primary font-bold group-hover:scale-105 transition-transform">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 bg-green-500 w-4 h-4 rounded-full border-2 border-white dark:border-slate-900"></div>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="profileDropdown" class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700 p-2 hidden z-[1001] animate-in fade-in slide-in-from-top-2 duration-200">
                                <div class="px-3 py-3 border-b border-slate-100 dark:border-slate-700/50 mb-1">
                                    <p class="text-[11px] font-bold text-slate-800 dark:text-white mb-0.5 truncate">{{ $member->name }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold tracking-widest uppercase">ID: {{ $member->membership_id ?? '#'.str_pad($member->id, 6, '0', STR_PAD_LEFT) }}</p>
                                </div>
                                <a href="{{ url('/user/dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 font-bold text-[11px] uppercase tracking-wide transition-all group/item">
                                    <span class="material-icons text-primary text-lg group-hover/item:scale-110 transition-transform">dashboard</span>
                                    Visit Dashboard
                                </a>
                                <a href="{{ url('/user/transactions') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 font-bold text-[11px] uppercase tracking-wide transition-all group/item">
                                    <span class="material-icons text-primary text-lg group-hover/item:scale-110 transition-transform">receipt_long</span>
                                    Transaction History
                                </a>
                                <a href="{{ url('/user/settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-200 font-bold text-[11px] uppercase tracking-wide transition-all group/item">
                                    <span class="material-icons text-slate-400 group-hover/item:text-primary text-lg transition-colors">settings</span>
                                    Account Settings
                                </a>
                                <div class="h-px bg-slate-100 dark:bg-slate-700/50 my-1"></div>
                                <form method="POST" action="{{ route('member.logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-50 dark:hover:bg-red-500/10 text-red-500 font-bold text-[11px] uppercase tracking-wide transition-all group/item">
                                        <span class="material-icons text-red-400 group-hover/item:text-red-600 text-lg transition-colors">logout</span>
                                        Logout IBSEA
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ url('/login') }}" class="hidden md:flex items-center gap-2 text-slate-700 dark:text-slate-300 font-black px-4 py-2 hover:text-orange-500 transition-all text-[11px] uppercase tracking-[0.2em]">
                    Login
                </a>
                <a href="{{ url('/register') }}" class="hidden md:block">
                    <img src="{{ asset('button-registration-1.gif.webp') }}" class="h-10 md:h-12 hover:scale-110 transition-transform duration-300" alt="Register" />
                </a>
            @endif

            <button id="mobile-menu-toggle" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-slate-500 rounded-lg md:hidden hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                <span class="sr-only">Open main menu</span>
                <span class="material-icons">menu</span>
            </button>
        </div>

        <div id="mega-menu" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col mt-4 font-bold md:flex-row md:mt-0 md:space-x-8 text-[11px] uppercase tracking-[0.1em]">
                <li><a href="{{ url('/') }}" class="block py-2 text-slate-700 dark:text-slate-300 hover:text-orange-500 transition-all">Home</a></li>
                <li><a href="{{ url('/about') }}" class="block py-2 text-slate-700 dark:text-slate-300 hover:text-orange-500 transition-all">About</a></li>
                
                <!-- Initiatives Dropdown -->
                <li class="relative group">
                    <a href="{{ route('public.initiatives.index') }}" class="flex items-center gap-1 py-2 text-slate-700 dark:text-slate-300 hover:text-orange-500 transition-all w-full md:w-auto text-left uppercase tracking-wide font-bold">
                        Initiatives <span class="material-icons text-sm">expand_more</span>
                    </a>
                    <div class="absolute left-0 mt-2 w-72 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 p-4 z-50">
                        <ul class="space-y-1">
                            @foreach($activeInitiatives as $init)
                            <li>
                                <a href="{{ route('public.initiatives.show', $init->slug) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all group/init">
                                    <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary group-hover/init:bg-primary group-hover/init:text-white transition-all">
                                        <span class="material-icons text-sm">{{ $init->icon }}</span>
                                    </div>
                                    <span class="text-[10px] text-slate-700 dark:text-slate-300 font-black uppercase tracking-widest">{{ $init->title }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>

                <li><a href="{{ url('/leadership') }}" class="block py-2 text-slate-700 dark:text-slate-300 hover:text-orange-500 transition-all">Leadership</a></li>
                
                <!-- Media Room Dropdown -->
                <li class="relative group">
                    <button class="flex items-center gap-1 py-2 text-slate-700 dark:text-slate-300 hover:text-orange-500 transition-all w-full md:w-auto text-left uppercase tracking-wide font-bold">
                        Media Room <span class="material-icons text-sm">expand_more</span>
                    </button>
                    <div class="absolute left-0 mt-2 w-64 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 p-4 z-50">
                        <ul class="space-y-2">
                            <li><a href="{{ url('/news?category=Blog') }}" class="block p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 text-[10px] text-slate-700 dark:text-slate-300 hover:text-orange-500 font-black uppercase tracking-widest">Blogs</a></li>
                            <li><a href="{{ url('/news?category=News') }}" class="block p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 text-[10px] text-slate-700 dark:text-slate-300 hover:text-orange-500 font-black uppercase tracking-widest">News</a></li>
                            <li><a href="{{ url('/news?category=Press Release') }}" class="block p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 text-[10px] text-slate-700 dark:text-slate-300 hover:text-orange-500 font-black uppercase tracking-widest">Press Releases</a></li>
                            <li><a href="{{ url('/#gallery') }}" class="block p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 text-[10px] text-slate-700 dark:text-slate-300 hover:text-orange-500 font-black uppercase tracking-widest">Gallery</a></li>
                        </ul>
                    </div>
                </li>

                <li><a href="{{ url('/events') }}" class="block py-2 text-slate-700 dark:text-slate-300 hover:text-orange-500 transition-all">Events</a></li>
                <li><a href="{{ url('/membership') }}" class="block py-2 text-slate-700 dark:text-slate-300 hover:text-orange-500 transition-all">Membership</a></li>
                
                <li><a href="{{ route('public.resources.index') }}" class="block py-2 text-slate-700 dark:text-slate-300 hover:text-orange-500 transition-all font-black text-primary">Resources</a></li>
                <li><a href="{{ url('/contact') }}" class="block py-2 text-slate-700 dark:text-slate-300 hover:text-orange-500 transition-all">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Mobile Menu (Overlay) -->
<div id="mobile-menu-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[999] hidden flex justify-end">
    <div id="mobile-menu-container" class="bg-white dark:bg-slate-900 w-[85%] max-w-sm h-full shadow-2xl overflow-y-auto transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center sticky top-0 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md z-10">
            <img src="{{ asset('ibsea-text-33w-600x83.png.webp') }}" class="h-8 md:h-12" alt="Logo" />
            <button id="mobile-menu-close" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-white/5 text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center justify-center">
                <span class="material-icons text-2xl">close</span>
            </button>
        </div>

        <div class="p-6 flex-1">
            <ul class="space-y-4">
                <li><a href="{{ url('/') }}" class="text-md font-black text-slate-800 dark:text-white flex items-center gap-4 hover:text-orange-500 transition-all uppercase tracking-wider"><span class="material-icons text-orange-500">home</span> Home</a></li>
                <li><a href="{{ url('/about') }}" class="text-md font-black text-slate-800 dark:text-white flex items-center gap-4 hover:text-orange-500 transition-all uppercase tracking-wider"><span class="material-icons text-orange-500">info</span> About IBSEA</a></li>
                
                <!-- Initiatives Mobile -->
                <li class="border-t border-slate-100 dark:border-slate-800 pt-4">
                    <button onclick="toggleMobileSubmenu('initiatives-submenu')" class="w-full text-md font-black text-slate-800 dark:text-white flex items-center justify-between hover:text-orange-500 transition-all uppercase tracking-wider">
                        <span class="flex items-center gap-4"><span class="material-icons text-primary">flag</span> Initiatives</span>
                        <span class="material-icons">expand_more</span>
                    </button>
                    <ul id="initiatives-submenu" class="hidden pl-12 mt-4 space-y-4 border-l-2 border-primary/20 ml-2">
                        <li><a href="{{ route('public.initiatives.index') }}" class="text-sm font-black text-primary hover:text-orange-500 block uppercase tracking-widest">View All Initiatives</a></li>
                        @foreach($activeInitiatives as $init)
                        <li><a href="{{ route('public.initiatives.show', $init->slug) }}" class="text-sm font-bold text-slate-800 dark:text-white hover:text-orange-500 block">{{ $init->title }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <li><a href="{{ url('/leadership') }}" class="text-md font-black text-slate-800 dark:text-white flex items-center gap-4 hover:text-orange-500 transition-all uppercase tracking-wider"><span class="material-icons text-orange-500">groups</span> Leadership</a></li>
                
                <!-- Media Room Mobile -->
                <li class="border-t border-slate-100 dark:border-slate-800 pt-4">
                    <button onclick="toggleMobileSubmenu('media-submenu')" class="w-full text-md font-black text-slate-800 dark:text-white flex items-center justify-between hover:text-orange-500 transition-all uppercase tracking-wider">
                        <span class="flex items-center gap-4"><span class="material-icons text-orange-500">perm_media</span> Media Room</span>
                        <span class="material-icons">expand_more</span>
                    </button>
                    <ul id="media-submenu" class="hidden pl-12 mt-4 space-y-4 border-l-2 border-orange-500/20 ml-2">
                        <li><a href="{{ url('/news?category=Blog') }}" class="text-sm font-bold text-slate-800 dark:text-white hover:text-orange-500 block">Blogs</a></li>
                        <li><a href="{{ url('/news?category=News') }}" class="text-sm font-bold text-slate-800 dark:text-white hover:text-orange-500 block">News</a></li>
                        <li><a href="{{ url('/news?category=Press Release') }}" class="text-sm font-bold text-slate-800 dark:text-white hover:text-orange-500 block">Press Releases</a></li>
                        <li><a href="{{ url('/#gallery') }}" class="text-sm font-bold text-slate-800 dark:text-white hover:text-orange-500 block">Gallery</a></li>
                    </ul>
                </li>

                <li><a href="{{ url('/events') }}" class="text-md font-black text-slate-800 dark:text-white flex items-center gap-4 hover:text-orange-500 transition-all uppercase tracking-wider"><span class="material-icons text-orange-500">event</span> Events Hub</a></li>
                <li><a href="{{ url('/membership') }}" class="text-md font-black text-slate-800 dark:text-white flex items-center gap-4 hover:text-orange-500 transition-all uppercase tracking-wider"><span class="material-icons text-orange-500">card_membership</span> Membership</a></li>
                <li><a href="{{ route('public.resources.index') }}" class="text-md font-black text-slate-800 dark:text-white flex items-center gap-4 hover:text-orange-500 transition-all uppercase tracking-wider"><span class="material-icons text-primary">auto_stories</span> Resources</a></li>
                <li><a href="{{ url('/contact') }}" class="text-md font-black text-slate-800 dark:text-white flex items-center gap-4 hover:text-orange-500 transition-all uppercase tracking-wider"><span class="material-icons text-orange-500">contact_support</span> Contact Us</a></li>

                <div class="pt-8 border-t border-slate-100 dark:border-slate-800">
                    @if ($is_logged_in)
                        
                        <div class="pt-6 mt-6 border-t border-slate-100 dark:border-slate-800">
                             <form method="POST" action="{{ route('member.logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left text-md font-black text-red-500 flex items-center gap-4 hover:text-red-600 transition-all uppercase tracking-wider">
                                    <span class="material-icons text-red-500">logout</span> Logout IBSEA
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="space-y-4">
                            <a href="{{ url('/login') }}" class="block w-full bg-orange-500 text-white text-center font-black py-4 rounded-2xl shadow-xl shadow-orange-500/20 active:scale-95 transition-all text-xs uppercase tracking-widest leading-none">LOGIN IBSEA</a>
                            <a href="{{ url('/register') }}" class="block w-full border-2 border-slate-100 dark:border-slate-800 text-center font-black py-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-slate-700 dark:text-slate-300 text-xs uppercase tracking-widest leading-none">JOIN IBSEA</a>
                        </div>
                    @endif
                </div>
            </ul>
        </div>
    </div>
</div>

<script>
    function toggleMobileSubmenu(id) {
        const submenu = document.getElementById(id);
        if (submenu) {
            submenu.classList.toggle('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('darkModeToggle');
        const html = document.documentElement;
        
        if (toggleBtn) {
            const updateIcon = (isDark) => {
                toggleBtn.innerHTML = `<span class="material-symbols-outlined text-sm font-bold">${isDark ? 'light_mode' : 'dark_mode'}</span>`;
            };
            
            updateIcon(html.classList.contains('dark'));

            toggleBtn.addEventListener('click', () => {
                const isDark = html.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateIcon(isDark);
            });
        }

        // Mobile Menu Logic
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const mobileOverlay = document.getElementById('mobile-menu-overlay');
        const mobileContainer = document.getElementById('mobile-menu-container');
        const mobileClose = document.getElementById('mobile-menu-close');

        if (mobileToggle && mobileOverlay && mobileContainer) {
            const openMenu = () => {
                mobileOverlay.classList.remove('hidden');
                setTimeout(() => {
                    mobileContainer.classList.remove('translate-x-full');
                }, 10);
                document.body.style.overflow = 'hidden';
            };

            const closeMenu = () => {
                mobileContainer.classList.add('translate-x-full');
                setTimeout(() => {
                    mobileOverlay.classList.add('hidden');
                }, 300);
                document.body.style.overflow = '';
            };

            mobileToggle.addEventListener('click', openMenu);
            if (mobileClose) mobileClose.addEventListener('click', closeMenu);

            mobileOverlay.addEventListener('click', (e) => {
                if (e.target === mobileOverlay) closeMenu();
            });
        }

        // Submenu Toggle Logic
        const submenuToggles = document.querySelectorAll('.submenu-toggle');
        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const targetId = toggle.getAttribute('data-target');
                const submenu = document.getElementById(targetId);
                const arrow = toggle.querySelector('.arrow-icon');
                
                if (submenu) {
                    const isHidden = submenu.classList.toggle('hidden');
                    if (arrow) {
                        arrow.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
                    }
                }
            });
        });

        // Dropdown Toggle Logic
        const profileBtn = document.getElementById('profileDropdownBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
