@extends('layouts.app')

@push('styles')
<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    html {
        scroll-behavior: auto !important;
    }

    .marquee-container {
        overflow: hidden;
        white-space: nowrap;
    }

    .marquee-content {
        display: inline-block;
        padding-left: 100%;
        animation: marquee 20s linear infinite;
        color: #ffffff;
    }

    @keyframes marquee {
        0% { transform: translate(0, 0); }
        100% { transform: translate(-100%, 0); }
    }

    .vertical-ticker {
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .vertical-ticker-content {
        animation: vertical-scroll 8s linear infinite;
    }

    .vertical-ticker:hover .vertical-ticker-content {
        animation-play-state: paused;
    }

    @keyframes vertical-scroll {
        0% { transform: translateY(0); }
        100% { transform: translateY(-50%); }
    }
    @keyframes text-loop {
        0%, 25% { transform: translateY(0); }
        33%, 58% { transform: translateY(-25%); }
        66%, 91% { transform: translateY(-50%); }
        100% { transform: translateY(-75%); }
    }
    .animate-text-loop {
        animation: text-loop 9s cubic-bezier(0.645, 0.045, 0.355, 1) infinite;
    }
</style>
@endpush

@section('content')
<!-- News Ticker -->
<div class="bg-primary text-secondary font-bold text-sm py-2 overflow-hidden border-b-4 border-secondary dark:border-background-dark">
    <div class="container mx-auto flex items-center">
        <span class="bg-secondary text-white px-3 py-1 text-xs uppercase tracking-wider rounded-sm mr-4 shrink-0 shadow-sm">Latest News</span>
        <div class="marquee-container w-full">
            <div class="marquee-content shadow-sm flex gap-12 items-center">
                @if($ticker_posts->count() > 0)
                    @foreach($ticker_posts as $tp)
                        <span class="inline-flex items-center gap-2">
                            <span class="material-symbols-outlined text-[10px] text-secondary/70">fiber_manual_record</span>
                            <a href="{{ route('news.show', $tp->slug) }}" class="hover:underline hover:text-white transition">
                                {{ $tp->title }}
                            </a>
                        </span>
                    @endforeach
                    <!-- Duplicate for infinite scroll effect -->
                    @foreach($ticker_posts as $tp)
                        <span class="inline-flex items-center gap-2">
                            <span class="material-symbols-outlined text-[10px] text-secondary/70">fiber_manual_record</span>
                            <a href="{{ route('news.show', $tp->slug) }}" class="hover:underline hover:text-white transition">
                                {{ $tp->title }}
                            </a>
                        </span>
                    @endforeach
                @else
                    <span class="inline-flex items-center gap-2">
                        UNION BUDGET 2026-27 Announced: Key focus on Startup Ecosystem growth. | New Partnership with Global Trade Alliance signed.
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<section data-aos="fade" class="relative bg-secondary dark:bg-background-dark overflow-hidden flex flex-col lg:flex-row items-stretch">
    <div class="w-full lg:w-[70%] relative flex items-stretch group swiper hero-swiper aspect-video lg:aspect-auto lg:min-h-[600px]">
        <div class="swiper-wrapper">
            @if($slider_posts->isEmpty())
                <div class="swiper-slide relative flex items-end">
                    <div class="absolute inset-0 z-0">
                        <img alt="Corporate Conclave" class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBXxzFjK1MRn5dGDmmxShtl97tDLzyXUbqKqH-B6rH2l9qsMhluqclUeJFBaA5BqHnM6bs4ecLc3f1332ET-YbPXF3s5k8o5uYxCV20Brh9pgRX57ZLf0f0OLNSqw3sEMPRN5LwgZbdkuqZU8dq3uiWBfVlwTZ34nNxJa9kvQ8UR1gbUXREzGZUrgd333kmUZ-usO-jslBai9KEx55hpKtkYvS4VeGiMNHtBwt2jcU8zSrzx7o7zwskcqy6x8znulnVsll2OAZ092g" />
                        <div class="absolute inset-x-0 bottom-0 h-[40%] bg-gradient-to-t from-black/80 to-transparent"></div>
                    </div>
                    <div class="relative z-10 p-6 lg:px-16 lg:pb-24 w-full flex flex-col items-center lg:items-start text-center lg:text-left">
                        <div class="inline-block px-3 py-1 bg-primary/20 backdrop-blur-md text-primary text-[10px] font-bold uppercase tracking-widest mb-4 rounded-sm border border-primary/20">Viksit Bharat @2047</div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('register') }}" class="bg-primary hover:bg-amber-600 text-secondary font-bold px-4 py-2 rounded shadow-lg transition transform hover:-translate-y-1 flex items-center justify-center gap-2 text-md uppercase tracking-tight">
                                Join IBSEA - From Local Roots to Global Leadership
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                @foreach($slider_posts as $post)
                    <div class="swiper-slide relative flex items-end">
                        <div class="absolute inset-0 z-0">
                            <img alt="{{ $post->title }}" class="w-full h-full object-cover"
                                src="{{ $post->featured_image ? asset($post->featured_image) : 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop' }}" />
                            <div class="absolute inset-x-0 bottom-0 h-[40%] bg-gradient-to-t from-black/80 to-transparent"></div>
                        </div>
                        <div class="relative z-10 p-4 text-white lg:px-16 md:pb-5 lg:pb-5 w-full flex flex-col items-center lg:items-start text-center lg:text-left">
                            <div class="inline-block text-white px-3 py-1 bg-primary/90 backdrop-blur-md text-secondary text-[10px] font-black uppercase tracking-widest mb-4 rounded-sm border-l-4 border-secondary shadow-lg">
                                {{ $post->category }}
                            </div>
                            
                            <h2 class="text-[10px] md:text-md lg:text-xl font-display font-black leading-[2.2] lg:leading-[2.2] mb-6 max-w-4xl drop-shadow-lg uppercase group">
                                <a href="{{ route('news.show', $post->slug) }}" class="hover:text-primary transition-colors duration-300">
                                    {{ $post->title }}
                                </a>
                                <a href="{{ route('news.show', $post->slug) }}" class="inline-flex items-center gap-1 text-[#f26f21] ml-2 text-sm md:text-base align-middle hover:underline decoration-2 underline-offset-4 font-bold">
                                    Read More <span class="material-symbols-outlined text-sm font-bold">arrow_forward</span>
                                </a>
                            </h2>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <!-- Navigation -->
        <button class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-primary text-white p-2 rounded-full backdrop-blur-sm transition opacity-0 group-hover:opacity-100 hidden lg:block z-20 hero-next">
            <span class="material-symbols-outlined text-3xl">chevron_right</span>
        </button>
        <button class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-primary text-white p-2 rounded-full backdrop-blur-sm transition opacity-0 group-hover:opacity-100 hidden lg:block z-20 hero-prev">
            <span class="material-symbols-outlined text-3xl">chevron_left</span>
        </button>
    </div>
    <div class="flex w-full lg:w-[30%] bg-surface-light dark:bg-surface-dark border-t lg:border-t-0 lg:border-l border-amber-500/30 flex-col relative">
        <div class="absolute inset-y-0 left-0 w-[1px] bg-gradient-to-b from-transparent via-amber-500 to-transparent opacity-50"></div>
        <div class="p-6 bg-secondary border-b border-white/10">
            <h3 class="text-white font-display font-bold text-lg flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">hub</span>
                Latest at IBSEA
            </h3>
        </div>
        <div class="p-6 bg-white dark:bg-secondary flex-grow flex flex-col overflow-hidden">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Press &amp; Policy Updates</h4>
            <div class="vertical-ticker relative flex-grow mask-image-gradient">
                <div class="vertical-ticker-content space-y-6">
                    @forelse ($ticker_posts as $post)
                        <div class="border-l-2 border-primary pl-4">
                            <span class="text-[10px] font-bold text-slate-500 block mb-1 uppercase">{{ $post->published_at->diffForHumans() }}</span>
                            <a class="text-sm font-bold text-slate-800 dark:text-slate-200 hover:text-primary transition line-clamp-2 leading-[1.8]" 
                               href="{{ route('news.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </div>
                    @empty
                        <div class="border-l-2 border-slate-300 pl-4">
                            <span class="text-[10px] font-bold text-slate-500 block mb-1 uppercase">STAY TUNED</span>
                            <p class="text-sm font-bold text-slate-400">Latest mission updates loading soon...</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="p-6 bg-slate-100 dark:bg-black/20 mt-auto border-t border-slate-200 dark:border-slate-700">
            <div class="flex justify-between items-center mb-3">
                <span class="text-xs font-bold text-primary uppercase tracking-widest">Featured Event</span>
                <span class="bg-secondary text-white text-[10px] px-2 py-0.5 rounded uppercase">Upcoming</span>
            </div>
            
            @if($featured_events->count() > 0)
                <div class="swiper featured-event-swiper overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach($featured_events as $index => $fe)
                        @php
                            $colors = ['border-primary', 'border-blue-500', 'border-purple-500', 'border-emerald-500'];
                            $color = $colors[$index % 4];
                        @endphp
                        <div class="swiper-slide bg-white dark:bg-slate-800 rounded-lg p-4 shadow-md border-l-4 {{ $color }} group cursor-pointer hover:shadow-lg transition">
                            <a href="{{ route('public.events.show', $fe->id) }}" class="flex items-start gap-3 w-full h-full block">
                                <div class="bg-primary/10 rounded p-2 text-center min-w-[50px]">
                                    <span class="block text-xs font-bold text-slate-500 uppercase">{{ date('M', strtotime($fe->event_date)) }}</span>
                                    <span class="block text-xl font-bold text-secondary dark:text-white">{{ date('d', strtotime($fe->event_date)) }}</span>
                                </div>
                                <div class="w-full">
                                    <h5 class="text-sm font-bold text-secondary dark:text-white leading-snug mb-1 group-hover:text-primary transition line-clamp-2">
                                        {{ $fe->name }}
                                    </h5>
                                    <p class="text-xs text-slate-500 line-clamp-1">{{ $fe->city }}</p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-slate-800 rounded-lg p-4 shadow-md border-l-4 border-slate-300">
                    <p class="text-xs text-slate-500 font-bold uppercase">No featured events currently.</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- About Us Section -->
<section data-aos="fade-up" class="py-20 bg-white dark:bg-secondary overflow-hidden relative" id="about-us">
    <div class="container mx-auto px-4 lg:px-16">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <!-- Left: YouTube Video -->
            <div class="w-full lg:w-1/2 relative group">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-video bg-slate-200 dark:bg-slate-800 border-4 border-white dark:border-slate-700">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/zga-AnQO0PY?si=fnyek4p_qWxldih7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <!-- Decorative Element -->
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-primary/10 rounded-full blur-3xl -z-10 group-hover:bg-primary/20 transition-all duration-500"></div>
            </div>

            <!-- Right: Content -->
            <div class="w-full lg:w-1/2">
                <div class="inline-flex items-center gap-3 mb-4">
                    <span class="h-[2px] w-10 bg-primary"></span>
                    <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">About IBSEA</span>
                </div>
                
                <h2 class="text-3xl md:text-5xl font-display font-black text-secondary dark:text-white leading-tight mb-6 uppercase">
                    Driving India’s Entrepreneurial Growth toward 
                    <span class="text-primary">Viksit Bharat 2047</span>
                </h2>

                <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed mb-8 font-medium">
                    IBSEA (International Business Startup and Entrepreneurs Association) is a Section 8 not-for-profit organization dedicated to building a truly one-stop entrepreneurial ecosystem. From Tier 2 and Tier 3 regions, we empower founders through every stage—from ideation and incubation to market positioning and funding.
                </p>

                <!-- Stats / Mini Features -->
                <div class="grid grid-cols-2 gap-6 mb-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-secondary/5 flex items-center justify-center shrink-0 border border-secondary/10">
                            <span class="material-symbols-outlined text-secondary text-2xl">handshake</span>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-secondary dark:text-white leading-none">65+</h4>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-tighter">MoU Partners</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-primary/5 flex items-center justify-center shrink-0 border border-primary/10">
                            <span class="material-symbols-outlined text-primary text-2xl">school</span>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-secondary dark:text-white leading-none">100+</h4>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-tighter">Expert Mentors</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('about') }}" class="inline-flex items-center justify-center gap-2 bg-secondary hover:bg-black text-white px-8 py-4 rounded-none font-black text-sm uppercase tracking-widest transition-all shadow-xl hover:-translate-y-1">
                        Know More
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                    <a href="{{ route('membership') }}" class="inline-flex items-center justify-center gap-2 bg-white border-2 border-slate-200 text-secondary hover:border-primary hover:text-primary px-8 py-4 rounded-none font-black text-sm uppercase tracking-widest transition-all shadow-md hover:-translate-y-1">
                        Join Mission
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Animated Text CTA Section -->
<section class="py-16 bg-slate-50 dark:bg-slate-900 border-y border-slate-100 dark:border-slate-800 relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none">
        <svg class="w-full h-full font-bold" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="currentColor" class="text-primary"></path>
        </svg>
    </div>
    <div class="container mx-auto px-4 text-center relative z-10">
        <h2 class="text-2xl md:text-5xl font-display font-black text-secondary dark:text-white uppercase tracking-tight leading-tight">
            Become IBSEA Member Today to Expand Your<br class="hidden md:block">
            <span class="text-primary block mt-6 md:inline-block h-[1.1em] overflow-hidden align-bottom relative min-w-full md:min-w-[600px] text-5xl md:text-9xl transition-all duration-500">
                <span class="animate-text-loop flex flex-col items-center w-full">
                    <span class="h-[1.1em] flex items-center justify-center">Network</span>
                    <span class="h-[1.1em] flex items-center justify-center">Knowledge</span>
                    <span class="h-[1.1em] flex items-center justify-center">Sales</span>
                    <span class="h-[1.1em] flex items-center justify-center">Network</span>
                </span>
            </span>
        </h2>
    </div>
</section>

<section data-aos="fade-up" class="py-24 bg-white dark:bg-surface-dark relative overflow-hidden" id="schemes">
   
    <div class="container mx-auto px-4 lg:px-16">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-3 mb-4">
                <span class="h-[2px] w-10 bg-primary"></span>
                <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">Framework For Growth</span>
                <span class="h-[2px] w-10 bg-primary"></span>
            </div>
            <h2 class="text-3xl md:text-5xl font-display font-black text-secondary dark:text-white mb-6 uppercase tracking-tight">Strategic Growth & Expansion Framework</h2>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 relative">

        <!-- Ashoka Chakra -->
    <img src="{{ asset('image/Ashoka_Chakra (1).svg') }}"
         class="absolute -top-20 -left-20
         w-[200px] h-[200px]
    
         animate-[spin_30s_linear_infinite]
         pointer-events-none
         -z-10"
         alt="Ashoka Chakra">
            
            <!-- Scheme 1 -->
            <!-- Scheme 1: Government Initiatives -->
            <div class="bg-emerald-700/90 rounded-none p-10 text-white group hover:shadow-2xl hover:shadow-emerald-900/40 transition-all duration-500 min-h-[400px] flex flex-col relative overflow-hidden">
                <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-white/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10 h-full flex flex-col">
                    <div class="w-16 h-16 rounded-xl bg-white/10 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl">gavel</span>
                    </div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-300 mb-2">Government Support</h4>
                    <h3 class="text-2xl font-black uppercase tracking-wider mb-4 leading-tight">Access Government Schemes & Support</h3>
                    <p class="text-white/70 mb-8 flex-grow leading-relaxed font-medium">We help you find and use the right government schemes, funding programs, and startup benefits. Our goal is to make it easier for you to grow your business with the support already available.</p>
                    <a href="#" class="inline-flex items-center gap-2 bg-white text-emerald-800 font-black py-4 px-8 rounded-none text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all self-start mt-auto">
                        Explore Government Support
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
            
            <!-- Scheme 2 -->
            <!-- Scheme 2: Tier 2 & Tier 3 -->
            <div class="bg-secondary rounded-none p-10 text-white group hover:shadow-2xl hover:shadow-black/40 transition-all duration-500 min-h-[400px] flex flex-col relative overflow-hidden">
                <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-primary/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10 h-full flex flex-col">
                    <div class="w-16 h-16 rounded-xl bg-primary flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl text-secondary">location_city</span>
                    </div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-primary mb-2">Tier 2 & Tier 3 Cities</h4>
                    <h3 class="text-2xl font-black uppercase tracking-wider mb-4 leading-tight">Grow Your Business from Any City</h3>
                    <p class="text-white/70 mb-8 flex-grow leading-relaxed font-medium">No matter where you are — Tier 2 or Tier 3 city — IBSEA helps you connect, learn, and grow. Get access to mentorship, networking, and opportunities usually available only in big cities.</p>
                    <a href="#" class="inline-flex items-center gap-2 bg-primary text-secondary font-black py-4 px-8 rounded-none text-[10px] uppercase tracking-widest hover:bg-amber-600 transition-all self-start mt-auto">
                        Discover Growth Opportunities
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Scheme 3 -->
            <!-- Scheme 3: International Expansion -->
            <div class="bg-orange-600 rounded-none p-10 text-white group hover:shadow-2xl hover:shadow-orange-900/40 transition-all duration-500 min-h-[400px] flex flex-col relative overflow-hidden">
                <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-white/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10 h-full flex flex-col">
                    <div class="w-16 h-16 rounded-xl bg-white/10 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl text-white">public</span>
                    </div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-white/80 mb-2">International Growth</h4>
                    <h3 class="text-2xl font-black uppercase tracking-wider mb-4 leading-tight">Take Your Business Global</h3>
                    <p class="text-white/70 mb-8 flex-grow leading-relaxed font-medium">We help you connect with international businesses, partners, and markets. Expand beyond India and grow your business on a global level with the right support.</p>
                    <a href="#" class="inline-flex items-center gap-2 bg-white text-orange-600 font-black py-4 px-8 rounded-none text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all self-start mt-auto">
                        Expand Globally
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Global and National Strategic Partners Section -->
<section class="py-16 bg-slate-50 dark:bg-slate-900 border-y border-slate-100 dark:border-slate-800 overflow-hidden">
    <div class="container mx-auto px-4 lg:px-16 mb-12 text-center" data-aos="fade-up">
        <div class="inline-flex items-center gap-3 mb-4">
            <span class="h-[1px] w-8 bg-primary/40"></span>
            <span class="text-primary font-bold uppercase tracking-[0.2em] text-[10px]">Institutional Synergy</span>
            <span class="h-[1px] w-8 bg-primary/40"></span>
        </div>
        <h2 class="text-3xl md:text-5xl font-display font-black text-secondary dark:text-white uppercase tracking-tight">Global and National <span class="text-primary">Strategic Partners</span></h2>
        <p class="mt-4 text-slate-500 dark:text-slate-400 max-w-2xl mx-auto font-medium text-sm">Empowering the ecosystem through high-authority institutional collaborations and strategic alliances.</p>
    </div>

    <!-- National Partners -->
    <div class="mb-12">
        <div class="px-4 lg:px-16 mb-4">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">National Strategic Partners</h4>
        </div>
        <div class="swiper national-partner-swiper">
            <div class="swiper-wrapper flex items-center">
                @foreach($nationalPartners as $partner)
                <div class="swiper-slide !w-auto flex items-center justify-center px-12">
                    <div class="w-[200px] h-[100px] flex items-center justify-center bg-white dark:bg-slate-800 rounded-2xl shadow-premium border border-slate-100 dark:border-slate-700 p-6 hover:grayscale transition-all duration-500 group">
                        <img src="{{ asset($partner->image_path) }}" alt="{{ $partner->title }}" title="{{ $partner->title }}" class="max-w-full max-h-full object-contain transition-transform group-hover:scale-110">
                    </div>
                </div>
                @endforeach
                {{-- Handle empty state or add MOU if needed --}}
                @foreach($mouPartners as $partner)
                <div class="swiper-slide !w-auto flex items-center justify-center px-12">
                    <div class="w-[200px] h-[100px] flex items-center justify-center bg-white dark:bg-slate-800 rounded-2xl shadow-premium border border-slate-100 dark:border-slate-700 p-6 hover:grayscale transition-all duration-500 group">
                        <img src="{{ asset($partner->image_path) }}" alt="{{ $partner->title }}" title="{{ $partner->title }}" class="max-w-full max-h-full object-contain transition-transform group-hover:scale-110">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- International Partners -->
    <div>
        <div class="px-4 lg:px-16 mb-4 text-right">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">International Strategic Partners</h4>
        </div>
        <div class="swiper international-partner-swiper">
            <div class="swiper-wrapper flex items-center">
                @foreach($internationalPartners as $partner)
                <div class="swiper-slide !w-auto flex items-center justify-center px-12">
                    <div class="w-[200px] h-[100px] flex items-center justify-center bg-white dark:bg-slate-800 rounded-2xl shadow-premium border border-slate-100 dark:border-slate-700 p-6 hover:grayscale transition-all duration-500 group">
                        <img src="{{ asset($partner->image_path) }}" alt="{{ $partner->title }}" title="{{ $partner->title }}" class="max-w-full max-h-full object-contain transition-transform group-hover:scale-110">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Global Connects Section
<section class="py-16 bg-gray-50 dark:bg-slate-900/30 border-y border-slate-100 dark:border-slate-800">
    <div class="container mx-auto px-4 lg:px-16 text-center">
        <div class="inline-flex items-center gap-3 mb-10">
            <span class="h-[1px] w-12 bg-slate-200"></span>
            <span class="text-slate-400 font-black uppercase tracking-[0.3em] text-[9px]">Global Strategic Partners</span>
            <span class="h-[1px] w-12 bg-slate-200"></span>
        </div>
        <div class="flex flex-wrap justify-around gap-12 items-center opacity-30 grayscale hover:opacity-100 hover:grayscale-0 transition-all duration-1000">
            <div class="flex items-center gap-3 font-black text-xl text-secondary dark:text-white uppercase tracking-tighter">
                <span class="material-symbols-outlined text-primary">public</span> WTO
            </div>
            <div class="flex items-center gap-3 font-black text-xl text-secondary dark:text-white uppercase tracking-tighter">
                <span class="material-symbols-outlined text-primary">account_balance</span> WORLD BANK
            </div>
            <div class="flex items-center gap-3 font-black text-xl text-secondary dark:text-white uppercase tracking-tighter">
                <span class="material-symbols-outlined text-primary">business</span> IMF
            </div>
            <div class="flex items-center gap-3 font-black text-xl text-secondary dark:text-white uppercase tracking-tighter">
                <span class="material-symbols-outlined text-primary">groups_3</span> G20
            </div>
            <div class="flex items-center gap-3 font-black text-xl text-secondary dark:text-white uppercase tracking-tighter">
                <span class="material-symbols-outlined text-primary">handshake</span> BRICS
            </div>
            <div class="flex items-center gap-3 font-black text-xl text-secondary dark:text-white uppercase tracking-tighter">
                <span class="material-symbols-outlined text-primary">language</span> UNCTAD
            </div>
        </div>
    </div>
</section> -->
 

<!-- Animated Counters Section -->
<section data-aos="fade-up" class="py-12 bg-secondary text-white relative overflow-hidden border-y border-white/5 shadow-inner">
    <div class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/dark-matter.png')]"></div>
    <div class="container mx-auto px-4 lg:px-16 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-y-12 gap-x-8">
            <!-- Stat 1: MoU Partners -->
            <div class="flex flex-col items-center text-center group">
                <div class="text-primary mb-3 transform group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-5xl">handshake</span>
                </div>
                <div class="text-4xl md:text-5xl font-black mb-1 flex items-baseline">
                    <span class="counter" data-target="65">0</span><span class="text-primary text-2xl md:text-3xl ml-0.5">+</span>
                </div>
                <p class="text-[10px] md:text-xs font-black uppercase tracking-[0.2em] text-slate-400">MoU Partners</p>
            </div>
            <!-- Stat 2: Expert Mentors -->
            <div class="flex flex-col items-center text-center group">
                <div class="text-primary mb-3 transform group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-5xl">school</span>
                </div>
                <div class="text-4xl md:text-5xl font-black mb-1 flex items-baseline">
                    <span class="counter" data-target="100">0</span><span class="text-primary text-2xl md:text-3xl ml-0.5">+</span>
                </div>
                <p class="text-[10px] md:text-xs font-black uppercase tracking-[0.2em] text-slate-400">Expert Mentors</p>
            </div>
            <!-- Stat 3: State Chapters -->
            <div class="flex flex-col items-center text-center group">
                <div class="text-primary mb-3 transform group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-5xl">location_city</span>
                </div>
                <div class="text-4xl md:text-5xl font-black mb-1 flex items-baseline">
                    <span class="counter" data-target="28">0</span><span class="text-primary text-2xl md:text-3xl ml-0.5">+</span>
                </div>
                <p class="text-[10px] md:text-xs font-black uppercase tracking-[0.2em] text-slate-400">State Chapters</p>
            </div>
            <!-- Stat 4: Global Chapters -->
            <div class="flex flex-col items-center text-center group">
                <div class="text-primary mb-3 transform group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-5xl">public</span>
                </div>
                <div class="text-4xl md:text-5xl font-black mb-1 flex items-baseline">
                    <span class="counter" data-target="10">0</span><span class="text-primary text-2xl md:text-3xl ml-0.5">+</span>
                </div>
                <p class="text-[10px] md:text-xs font-black uppercase tracking-[0.2em] text-slate-400">Global Chapters</p>
            </div>
            <!-- Stat 5: Influencers -->
            <div class="flex flex-col items-center text-center group">
                <div class="text-primary mb-3 transform group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-5xl">groups</span>
                </div>
                <div class="text-4xl md:text-5xl font-black mb-1 flex items-baseline">
                    <span class="counter" data-target="35">0</span><span class="text-primary text-2xl md:text-3xl ml-0.5">+</span>
                </div>
                <p class="text-[10px] md:text-xs font-black uppercase tracking-[0.2em] text-slate-400">Influencers</p>
            </div>
            <!-- Stat 6: Strategic Sectors -->
            <div class="flex flex-col items-center text-center group">
                <div class="text-primary mb-3 transform group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-5xl">category</span>
                </div>
                <div class="text-4xl md:text-5xl font-black mb-1 flex items-baseline">
                    <span class="counter" data-target="21">0</span><span class="text-primary text-2xl md:text-3xl ml-0.5">+</span>
                </div>
                <p class="text-[10px] md:text-xs font-black uppercase tracking-[0.2em] text-slate-400">Strategic Sectors</p>
            </div>
        </div>
    </div>
</section>

<!-- Key Initiatives Section -->
<section data-aos="fade-up" class="py-20 bg-gray-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800" id="key-initiatives">
    <div class="container mx-auto px-4 lg:px-16">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-3 mb-4">
                <span class="h-[2px] w-10 bg-primary"></span>
                <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">Strategic Focus</span>
                <span class="h-[2px] w-10 bg-primary"></span>
            </div>
            <h2 class="text-3xl md:text-5xl font-display font-black text-secondary dark:text-white mt-2 uppercase">IBSEA Key Initiatives</h2>
            <p class="mt-4 text-slate-600 dark:text-slate-400 max-w-2xl mx-auto font-medium">Driving impactful change through focused programs designed for sustainable startup growth and leadership.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 bg-white dark:bg-secondary rounded-none p-8 shadow-xl border border-slate-200 dark:border-slate-700 min-h-[500px]">
            <!-- Responsive Tabs -->
            <div class="hidden lg:flex w-full lg:w-1/4 flex-col border-r border-slate-100 dark:border-slate-700 pr-4 space-y-1">
                @foreach($activeInitiatives as $index => $init)
                <button onclick="handleInitiativeChange({{ $index }})"
                    class="tab-btn {{ $index === 0 ? 'active border-primary bg-primary/5 text-secondary dark:text-white font-bold' : 'border-transparent text-slate-600 dark:text-slate-400 font-medium' }} text-left px-6 py-4 border-l-4 transition-all duration-300 rounded-r-lg hover:bg-gray-50 dark:hover:bg-slate-800 hover:text-primary hover:border-primary/30">
                    {{ $init->title }}
                </button>
                @endforeach
            </div>

            <!-- Content Area -->
            <div class="w-full lg:w-3/4 lg:pl-8 flex items-center relative">
                <div class="swiper initiative-swiper w-full">
                    <div class="swiper-wrapper">
                        @foreach($activeInitiatives as $init)
                        <div class="swiper-slide w-full">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 items-start">
                                <div class="md:col-span-3 space-y-6 flex flex-col items-center md:items-start text-center md:text-left">
                                    <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center text-primary mb-4 overflow-hidden">
                                        @if($init->logo_path)
                                            <img src="{{ $init->logo_url }}" alt="{{ $init->title }} Logo" class="w-full h-full object-contain p-2">
                                        @else
                                            <span class="material-icons text-4xl">{{ $init->icon }}</span>
                                        @endif
                                    </div>
                                    <h3 class="text-3xl font-display font-bold text-secondary dark:text-blue-400 leading-tight">{{ $init->title }}</h3>
                                    <p class="text-lg text-slate-600 dark:text-slate-300 leading-relaxed font-medium">{{ $init->summary }}</p>
                                    <div class="flex flex-wrap gap-4 pt-4 justify-center md:justify-start">
                                        <a href="{{ route('public.initiatives.show', $init->slug) }}" class="bg-primary hover:bg-amber-600 text-secondary font-black py-4 px-10 rounded shadow-lg transition-all text-xs uppercase tracking-widest flex items-center gap-2">
                                            Know More 
                                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                        </a>
                                    </div>
                                </div>
                                @if($init->organizer_name)
                                <div class="md:col-span-2 bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-8 border border-slate-100 dark:border-slate-700/50 flex flex-col items-center text-center shadow-sm h-full justify-center">
                                    <div class="w-24 h-24 rounded-full border-4 border-white dark:border-slate-700 shadow-md overflow-hidden mb-4">
                                        <img src="{{ $init->organizer_image_url }}" alt="{{ $init->organizer_name }}" class="w-full h-full object-cover">
                                    </div>
                                    <h4 class="text-lg font-black text-secondary dark:text-white uppercase tracking-tight">{{ $init->organizer_name }}</h4>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">{{ $init->organizer_role }}</p>
                                    <div class="flex gap-4">
                                        @if($init->organizer_email)
                                        <a href="mailto:{{ $init->organizer_email }}" class="w-10 h-10 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400 hover:text-primary transition-all">
                                            <span class="material-symbols-outlined text-lg">mail</span>
                                        </a>
                                        @endif
                                        @if($init->organizer_linkedin)
                                        <a href="{{ $init->organizer_linkedin }}" target="_blank" class="w-10 h-10 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400 hover:text-primary transition-all font-bold">in</a>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DPIIT Startup Booster Section -->
<section class="py-20 bg-gradient-to-br from-white to-slate-50 dark:from-secondary dark:to-background-dark relative overflow-hidden" id="dpiit-booster">
    <!-- Border Accents (Saffron & Green) -->
    <div class="absolute top-0 left-0 w-full h-1.5 bg-[#FF9933]"></div>
    <div class="absolute bottom-0 left-0 w-full h-1.5 bg-[#138808]"></div>
    
    <div class="container mx-auto px-4 lg:px-16">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <!-- Left: Impactful Image -->
            <div class="w-full lg:w-1/2 relative group" data-aos="fade-right">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-8 border-white dark:border-slate-800">
                    <img src="{{ asset('image/dppit startup.webp') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="DPIIT Recognised Startup Booster">

                </div>
                <!-- Floating Badge -->
                <div class="absolute -top-6 -right-6 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-xl border border-[#FF9933]/20 flex flex-col items-center">
                    <span class="text-[#FF9933] font-black text-2xl">FREE</span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Membership</span>
                </div>
            </div>

            <!-- Right: Compelling Content -->
            <div class="w-full lg:w-1/2" data-aos="fade-left">
                <div class="inline-flex items-center gap-3 mb-6">
                    <span class="h-[2px] w-10 bg-[#FF9933]"></span>
                    <span class="text-[#000080] dark:text-blue-400 font-black uppercase tracking-[0.2em] text-[11px]">DPIIT Startup Booster</span>
                    <span class="h-[2px] w-10 bg-[#138808]"></span>
                </div>
                
                <h2 class="text-3xl md:text-5xl font-display font-black text-secondary dark:text-white leading-tight mb-6 uppercase">
                    Free Booster Membership for <span class="text-[#FF9933]">DPIIT Recognised</span> Startups
                </h2>

                <p class="text-lg text-slate-600 dark:text-slate-400 font-medium leading-relaxed mb-8">
                    IBSEA is offering <span class="text-[#138808] font-bold">FREE Booster Membership</span> to support your journey from startup to scale-up. Empowering India’s Recognised Startups to Scale Faster.
                </p>

                <!-- Benefits Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                    <div class="flex items-start gap-3 bg-white dark:bg-slate-800/50 p-4 rounded-xl border border-slate-100 dark:border-slate-700">
                        <span class="material-symbols-outlined text-[#138808]">verified</span>
                        <span class="text-sm font-bold text-slate-600 dark:text-slate-300">IBSEA Conferences Access</span>
                    </div>
                    <div class="flex items-start gap-3 bg-white dark:bg-slate-800/50 p-4 rounded-xl border border-slate-100 dark:border-slate-700">
                        <span class="material-symbols-outlined text-[#138808]">groups</span>
                        <span class="text-sm font-bold text-slate-600 dark:text-slate-300">Exclusive Community Entry</span>
                    </div>
                    <div class="flex items-start gap-3 bg-white dark:bg-slate-800/50 p-4 rounded-xl border border-slate-100 dark:border-slate-700">
                        <span class="material-symbols-outlined text-[#138808]">trending_up</span>
                        <span class="text-sm font-bold text-slate-600 dark:text-slate-300">Growth Training Programs</span>
                    </div>
                    <div class="flex items-start gap-3 bg-white dark:bg-slate-800/50 p-4 rounded-xl border border-slate-100 dark:border-slate-700">
                        <span class="material-symbols-outlined text-[#138808]">handshake</span>
                        <span class="text-sm font-bold text-slate-600 dark:text-slate-300">Mentorship Opportunities</span>
                    </div>
                </div>

                <div class="bg-[#000080]/5 dark:bg-blue-900/10 p-6 rounded-2xl border-l-4 border-[#000080] mb-10">
                    <h4 class="text-sm font-black text-[#000080] dark:text-blue-400 uppercase tracking-widest mb-2 italic">Why This Matters</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-300 font-medium">
                        We believe startups are the backbone of <span class="font-bold">Viksit Bharat @2047</span>. This initiative is our commitment to empowering recognized innovators across India.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="https://ibsea.in/f/registration-form" target="_blank" class="group inline-flex items-center justify-center gap-3 bg-[#FF9933] hover:bg-[#e68a2e] text-white px-8 py-5 rounded-none font-black text-xs uppercase tracking-widest transition-all shadow-xl hover:-translate-y-1">
                        Claim Your Membership
                        <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">rocket_launch</span>
                    </a>
                    <a href="{{ route('membership') }}" class="inline-flex items-center justify-center gap-3 bg-white dark:bg-slate-800 border-2 border-[#138808] text-[#138808] hover:bg-[#138808] hover:text-white px-8 py-5 rounded-none font-black text-xs uppercase tracking-widest transition-all shadow-md hover:-translate-y-1">
                        Verify Eligibility
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Membership Plans Section -->
<section data-aos="fade-up" class="py-20 bg-white dark:bg-background-dark relative overflow-hidden" id="membership">
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary/20 to-transparent"></div>
    
    <div class="container mx-auto px-4 lg:px-16">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-3 mb-4">
                <span class="h-[2px] w-10 bg-primary"></span>
                <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">Join the Inner Circle</span>
                <span class="h-[2px] w-10 bg-primary"></span>
            </div>
            <h2 class="text-3xl md:text-5xl font-display font-black text-secondary dark:text-white mt-2 uppercase tracking-tight">Become an <span class="text-primary">IBSEA Member</span></h2>
            <p class="mt-4 text-slate-600 dark:text-slate-400 max-w-2xl mx-auto font-medium">Select a plan that aligns with your professional journey and unlock exclusive ecosystem benefits.</p>
        </div>

        <div class="relative px-12">
            <!-- Navigation Arrows -->
            <button class="membership-prev absolute left-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white dark:bg-surface-dark shadow-xl text-secondary dark:text-white flex items-center justify-center transition-all hover:bg-primary hover:text-secondary group">
                <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">chevron_left</span>
            </button>
            <button class="membership-next absolute right-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white dark:bg-surface-dark shadow-xl text-secondary dark:text-white flex items-center justify-center transition-all hover:bg-primary hover:text-secondary group">
                <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">chevron_right</span>
            </button>

            <!-- Swiper Container -->
            <div class="swiper membership-swiper overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach($plans as $plan)
                    @php
                        $isFeatured = $plan->is_featured;
                        $bgClass = $isFeatured ? 'bg-secondary' : 'bg-white';
                        $textClass = $isFeatured ? 'text-white' : 'text-secondary';
                        $subTextClass = $isFeatured ? 'text-slate-300' : 'text-slate-500';
                        $borderClass = $isFeatured ? 'border-primary shadow-2xl' : 'border-slate-100 shadow-xl';
                    @endphp
                    <!-- Plan Slide -->
                    <div class="swiper-slide h-auto py-10">
                        <div class="h-full relative group {{ $bgClass }} dark:bg-surface-dark p-8 border-t-4 {{ $borderClass }} flex flex-col items-center text-center transition-all duration-500 hover:-translate-y-3">
                            @if($isFeatured)
                            <div class="absolute -top-4 right-8 bg-primary text-secondary text-[9px] font-black px-4 py-1.5 uppercase tracking-widest shadow-lg rounded-full">Most Popular</div>
                            @endif
                            
                            <h3 class="text-2xl font-black {{ $textClass }} dark:text-white uppercase tracking-tight mb-2">{{ $plan->title }}</h3>
                            <p class="text-[10px] font-bold {{ $subTextClass }} uppercase tracking-widest mb-8 border-b border-primary/20 pb-4 w-full">{{ $plan->tagline ?? 'Professional Membership' }}</p>
                            
                            <div class="mb-10 w-full text-center">
                                <span class="text-xs font-black uppercase {{ $subTextClass }} align-top">{{ $plan->currency_symbol ?? '₹' }}</span>
                                <span class="text-5xl font-display font-black {{ $textClass }} dark:text-white">{{ number_format($plan->fee_numeric) }}</span>
                                <span class="text-xs font-bold {{ $subTextClass }}">
                                    /{{ str_contains(strtolower($plan->title), 'lifetime') ? 'Lifetime' : ($plan->validity_days >= 365 ? 'Year' : 'Cycle') }}
                                </span>
                            </div>

                            <ul class="space-y-4 mb-10 w-full text-left flex-grow">
                                @foreach($plan->benefits_json ?? [] as $benefit)
                                <li class="flex items-start gap-3 text-xs font-bold {{ $subTextClass }}">
                                    <span class="material-symbols-outlined text-primary text-sm flex-shrink-0">check_circle</span>
                                    <span class="leading-tight">{{ $benefit }}</span>
                                </li>
                                @endforeach
                            </ul>

                            <div class="w-full space-y-3">
                                <form action="{{ route('payment.checkout') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="Membership">
                                    <input type="hidden" name="item_id" value="{{ $plan->id }}">
                                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 {{ $isFeatured ? 'bg-primary text-secondary border-none' : 'bg-transparent border-2 border-secondary text-secondary hover:bg-secondary hover:text-white dark:border-primary dark:text-primary dark:hover:bg-primary dark:hover:text-secondary' }} py-4 px-6 rounded-none font-black text-xs uppercase tracking-widest transition-all shadow-md group-hover:scale-[1.02]">
                                        Get Started
                                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                    </button>
                                </form>
                                
                                <a href="{{ route('membership') }}#{{ $plan->id }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest {{ $subTextClass }} hover:text-primary transition-colors">
                                    Know More 
                                    <span class="material-symbols-outlined text-xs">arrow_right_alt</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-16 text-center">
            <p class="text-slate-400 text-xs font-black uppercase tracking-widest">
                <span class="material-symbols-outlined align-middle mr-2 text-primary">info</span>
                Prices are exclusive of GST as applicable.
            </p>
        </div>
    </div>
</section>

<!-- Global Growth Banner Section -->
<section class="py-12 px-6 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative bg-gradient-to-br from-white to-slate-50 dark:from-secondary dark:to-background-dark rounded-[40px] overflow-hidden shadow-2xl border border-slate-200 dark:border-white/10 group">
            <!-- Border Accents (Saffron & Green) -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-[#FF9933] z-20"></div>
            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-[#138808] z-20"></div>
            
            <div class="grid lg:grid-cols-2 gap-0 relative z-10">
                <!-- Column 1: Image Asset -->
                <div class="relative min-h-[400px] border-b lg:border-b-0 lg:border-r border-slate-100 dark:border-white/5 overflow-hidden group">
                    <img src="{{ asset('international membership.webp') }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="International Membership">
                </div>
                
                <!-- Column 2: CTA -->
                <div class="p-12 lg:p-20 bg-white/40 dark:bg-white/5 backdrop-blur-sm flex flex-col justify-center items-start lg:items-center text-left lg:text-center">
                    <div class="max-w-sm">
                        <div class="inline-flex items-center gap-2 mb-4">
                            <span class="h-[1px] w-6 bg-[#FF9933]"></span>
                            <span class="text-[#000080] dark:text-blue-400 font-black uppercase tracking-[0.2em] text-[10px]">Global Reach</span>
                            <span class="h-[1px] w-6 bg-[#138808]"></span>
                        </div>
                        <h3 class="text-3xl font-black text-secondary dark:text-white uppercase tracking-tight mb-4">Start Your <span class="text-[#FF9933]">Global Journey</span></h3>
                        <p class="text-slate-600 dark:text-slate-400 font-bold text-sm mb-10">Access matchmaking, speaking slots, and exclusive events. Join the IBSEA International network today.</p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 w-full">
                            <form action="{{ route('payment.checkout') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="type" value="Membership">
                                <input type="hidden" name="item_id" value="international">
                                <button type="submit" class="w-full bg-[#FF9933] hover:bg-[#e68a2e] text-white py-5 px-8 font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-primary/10 flex items-center justify-center gap-2 group-hover:scale-[1.05]">
                                    Get Started
                                    <span class="material-icons text-sm">rocket_launch</span>
                                </button>
                            </form>
                            <a href="{{ route('membership') }}#international" class="flex-1 border-2 border-[#138808] text-[#138808] py-5 px-8 font-black text-xs uppercase tracking-widest transition-all hover:bg-[#138808] hover:text-white flex items-center justify-center gap-2">
                                Know More
                                <span class="material-icons text-sm">info</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Institutional Resource Hub Carousel -->
@if($homeResources->count() > 0)
<section data-aos="fade-up" class="py-20 bg-slate-50 dark:bg-background-dark overflow-hidden" id="resource-hub">
    <div class="container mx-auto px-4 lg:px-16 text-center">
        <div class="mb-16">
            <div class="inline-flex items-center gap-3 mb-4">
                <span class="h-[2px] w-10 bg-primary"></span>
                <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">Knowledge Ecosystem</span>
                <span class="h-[2px] w-10 bg-primary"></span>
            </div>
            <h2 class="text-3xl md:text-5xl font-display font-black text-secondary dark:text-white mt-2 uppercase tracking-tight">Institutional <span class="text-primary">Resource Hub</span></h2>
            <p class="mt-4 text-slate-600 dark:text-slate-400 max-w-2xl mx-auto font-medium italic">Manage official PDFs, templates, and mission-essential documents for our global alliance.</p>
        </div>

        <div class="relative px-12">
            <!-- Navigation -->
            <button class="resource-prev absolute left-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white dark:bg-surface-dark shadow-xl text-secondary dark:text-white flex items-center justify-center transition-all hover:bg-primary hover:text-secondary group">
                <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">chevron_left</span>
            </button>
            <button class="resource-next absolute right-0 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white dark:bg-surface-dark shadow-xl text-secondary dark:text-white flex items-center justify-center transition-all hover:bg-primary hover:text-secondary group">
                <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">chevron_right</span>
            </button>

            <!-- Swiper Container -->
            <div class="swiper resource-swiper overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach($homeResources as $resource)
                    <div class="swiper-slide h-auto py-10">
                        <div class="h-full bg-white dark:bg-surface-dark rounded-3xl p-6 shadow-xl border border-slate-100 dark:border-slate-800 transition-all duration-500 hover:-translate-y-3 flex flex-col items-center">
                            <div class="w-full aspect-[3/4] rounded-2xl overflow-hidden mb-6 shadow-lg relative group/cover">
                                <img src="{{ asset($resource->cover_image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/cover:scale-110" alt="{{ $resource->title }}">
                                <div class="absolute inset-0 bg-secondary/20 opacity-0 group-hover/cover:opacity-100 transition-opacity"></div>
                            </div>
                            <span class="text-[9px] font-black text-primary uppercase tracking-widest mb-2">{{ $resource->category }}</span>
                            <h3 class="text-lg font-black text-secondary dark:text-white leading-tight mb-6 line-clamp-2 px-2 uppercase tracking-tight">{{ $resource->title }}</h3>
                            
                            <a href="{{ route('public.resources.show', $resource->slug) }}" target="_blank" class="mt-auto w-full bg-secondary text-white py-4 px-6 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-3 transition-all hover:bg-primary hover:text-secondary group/btn">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                View Resource
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Upcoming Major Event Section -->
<section data-aos="fade-up" class="py-20 bg-white dark:bg-gray-800 overflow-hidden">
    <div class="container mx-auto px-4 lg:px-16">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-3 mb-4">
                <span class="h-[2px] w-10 bg-primary"></span>
                <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">Upcoming Major Event</span>
                <span class="h-[2px] w-10 bg-primary"></span>
            </div>
        </div>

        @if($featured_events->count() > 0)
        <div class="swiper major-event-swiper rounded-2xl overflow-hidden shadow-2xl border border-slate-100 dark:border-slate-800 bg-white dark:bg-secondary">
            <div class="swiper-wrapper">
                @foreach($featured_events as $fe)
                <div class="swiper-slide h-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 items-stretch min-h-[500px]">
                        <!-- Left: Details -->
                        <div class="p-8 lg:p-16 flex flex-col items-center lg:items-start text-center lg:text-left order-2 lg:order-1 bg-white dark:bg-slate-900 justify-center">
                            <h2 class="text-3xl lg:text-5xl font-display font-black text-secondary dark:text-white leading-tight mb-8 uppercase tracking-tight">
                                {{ $fe->name }}
                            </h2>
                            <p class="text-slate-600 dark:text-slate-400 mb-10 max-w-2xl leading-relaxed text-lg font-medium">
                                {{ strip_tags($fe->description) }}
                            </p>
                            <div class="flex flex-wrap gap-6 mb-12 justify-center lg:justify-start w-full">
                                <div class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 rounded-xl flex items-center gap-4 border border-slate-100 dark:border-slate-700 transition hover:border-primary group/item">
                                    <span class="material-symbols-outlined text-primary text-2xl">calendar_today</span>
                                    <div class="text-left">
                                        <div class="text-[9px] uppercase font-black text-slate-400 tracking-wider">Date</div>
                                        <span class="text-sm font-bold text-secondary dark:text-white">{{ date('jS F, Y', strtotime($fe->event_date)) }}</span>
                                    </div>
                                </div>
                                <div class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 rounded-xl flex items-center gap-4 border border-slate-100 dark:border-slate-700 transition hover:border-primary group/item">
                                    <span class="material-symbols-outlined text-primary text-2xl">location_on</span>
                                    <div class="text-left">
                                        <div class="text-[9px] uppercase font-black text-slate-400 tracking-wider">Venue</div>
                                        <span class="text-sm font-bold text-secondary dark:text-white uppercase">{{ $fe->city }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full lg:w-auto mt-4">
                                <a href="{{ route('public.events.show', $fe->id) }}" class="inline-flex w-full lg:w-auto justify-center bg-primary hover:bg-amber-600 text-secondary font-black py-5 px-14 rounded-none items-center gap-4 transition shadow-2xl scale-105 active:scale-100 text-sm uppercase tracking-widest">
                                    Register Now
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </a>
                            </div>
                        </div>

                        <!-- Right: Image -->
                        <div class=" bg-white dark:bg-slate-800 flex items-center justify-center order-1 lg:order-2 pr-4 ">
                             @if ($fe->featured_image)
                                <img src="{{ asset($fe->featured_image) }}" class="w-full object-cover rounded-xl" alt="{{ $fe->name }}">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-secondary to-[#0b1f49] text-white p-12">
                                    <span class="material-symbols-outlined text-8xl mb-4 text-primary opacity-50">event_available</span>
                                    <h3 class="text-3xl font-black uppercase tracking-widest text-center">{{ $fe->name }}</h3>
                                </div>
                            @endif
                            <!-- Decorative Overlay -->
                            <div class="absolute inset-0 bg-secondary/10 group-hover:bg-transparent transition-all"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination major-pagination !-bottom-8"></div>
        </div>
        @else
            <div class="bg-slate-50 dark:bg-slate-800 border-2 border-dashed border-slate-200 p-16 text-center">
                <p class="text-slate-400 font-bold uppercase tracking-widest">Stay tuned for upcoming landmark events.</p>
            </div>
        @endif
    </div>
</section>

<!-- Special Programs Section -->
<section data-aos="fade-up" class="py-20 bg-gray-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800" id="programs-grid">
    <div class="container mx-auto px-4 lg:px-16">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-3 mb-4">
                <span class="h-[2px] w-10 bg-primary"></span>
                <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">Programs & Frameworks</span>
                <span class="h-[2px] w-10 bg-primary"></span>
            </div>
            <h2 class="text-3xl md:text-5xl font-display font-black text-secondary dark:text-blue-400 mt-2 uppercase">Empowering Every Founder</h2>
            <p class="mt-4 text-slate-600 dark:text-slate-400 max-w-2xl mx-auto font-medium">Through our signature frameworks, we provide the tools, mentorship, and access needed for sustainable business expansion.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Program 1 -->
            <div class="group bg-white dark:bg-surface-dark p-8 border border-slate-100 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-0 bg-primary group-hover:h-full transition-all duration-500"></div>
                <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6 transition-transform group-hover:scale-110">
                    <span class="material-symbols-outlined text-4xl">rocket_launch</span>
                </div>
                <h3 class="text-xl font-bold text-secondary dark:text-white mb-4 uppercase tracking-tighter">Startup Incubation</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6 font-medium">Structured support for early-stage ventures, providing the foundation for scale-up and market entry.</p>
                <a href="#" class="text-primary font-black text-[10px] uppercase tracking-widest flex items-center gap-2 group/link">
                    Explore Program
                    <span class="material-symbols-outlined text-sm group-hover/link:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

            <!-- Program 2 -->
            <div class="group bg-white dark:bg-surface-dark p-8 border border-slate-100 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-0 bg-secondary group-hover:h-full transition-all duration-500"></div>
                <div class="w-16 h-16 bg-secondary/5 rounded-xl flex items-center justify-center text-secondary dark:text-blue-400 mb-6 transition-transform group-hover:scale-110">
                    <span class="material-symbols-outlined text-4xl">account_balance</span>
                </div>
                <h3 class="text-xl font-bold text-secondary dark:text-white mb-4 uppercase tracking-tighter">Fin-Link Access</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6 font-medium">Connecting viable startups with funding opportunities, VC networks, and strategic financial partners.</p>
                <a href="#" class="text-primary font-black text-[10px] uppercase tracking-widest flex items-center gap-2 group/link">
                    Explore Program
                    <span class="material-symbols-outlined text-sm group-hover/link:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

            <!-- Program 3 -->
            <div class="group bg-white dark:bg-surface-dark p-8 border border-slate-100 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-0 bg-primary group-hover:h-full transition-all duration-500"></div>
                <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center text-primary mb-6 transition-transform group-hover:scale-110">
                    <span class="material-symbols-outlined text-4xl">travel_explore</span>
                </div>
                <h3 class="text-xl font-bold text-secondary dark:text-white mb-4 uppercase tracking-tighter">Global Connect</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6 font-medium">Bridging Indian entrepreneurs with international markets through our global chapters and partners.</p>
                <a href="#" class="text-primary font-black text-[10px] uppercase tracking-widest flex items-center gap-2 group/link">
                    Explore Program
                    <span class="material-symbols-outlined text-sm group-hover/link:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

            <!-- Program 4 -->
            <div class="group bg-white dark:bg-surface-dark p-8 border border-slate-100 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-0 bg-secondary group-hover:h-full transition-all duration-500"></div>
                <div class="w-16 h-16 bg-secondary/5 rounded-xl flex items-center justify-center text-secondary dark:text-blue-400 mb-6 transition-transform group-hover:scale-110">
                    <span class="material-symbols-outlined text-4xl">psychology</span>
                </div>
                <h3 class="text-xl font-bold text-secondary dark:text-white mb-4 uppercase tracking-tighter">Mentor Minds</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6 font-medium">Direct access to industry veterans and successful founders for personalized growth strategies.</p>
                <a href="#" class="text-primary font-black text-[10px] uppercase tracking-widest flex items-center gap-2 group/link">
                    Explore Program
                    <span class="material-symbols-outlined text-sm group-hover/link:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- IBSEA Intro & Initiatives Section -->
<section data-aos="fade-up" class="py-20 bg-gray-50 dark:bg-slate-900/50 border-t border-slate-200 dark:border-slate-800" id="intro-initiatives">
    <div class="container mx-auto px-4 lg:px-16">
        <div class="flex items-center gap-4 mb-16">
            <div class="h-1 w-12 bg-primary"></div>
            <h2 class="text-3xl md:text-4xl font-display font-black text-secondary dark:text-white uppercase tracking-tight">IBSEA Intro &amp; Initiatives</h2>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="space-y-8">
                <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="flex flex-col gap-6">
                        <div class="flex items-start gap-6 mb-2">
                            <div class="bg-primary/10 text-primary p-4 rounded-lg">
                                <span class="material-symbols-outlined text-4xl">travel_explore</span>
                            </div>
                            <div>
                                <h3 class="text-2xl font-display font-black text-secondary dark:text-white mb-2 uppercase">Framework For Growth</h3>
                                <p class="text-slate-600 dark:text-slate-400 font-medium leading-relaxed">Access our comprehensive ecosystem roadmaps, strategic engagement plans, and everything you need to know about IBSEA's vision for the future.</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 mt-2">
                            <a class="w-full bg-primary text-secondary dark:text-white text-center font-black py-5 px-6 rounded shadow-lg transition-all hover:bg-amber-600 flex items-center justify-center gap-3 uppercase tracking-widest text-xs" href="https://ibsea.in/resources/ibsea-2026-annual-calendar/view" target="_blank">
                                <span class="material-symbols-outlined text-lg">calendar_month</span>
                                IBSEA Annual Calendar 2026 Events
                            </a>
                            <a class="w-full border-2 border-primary text-primary hover:bg-primary hover:text-secondary dark:hover:text-white text-center font-black py-5 px-6 rounded shadow-lg transition-all flex items-center justify-center gap-3 uppercase tracking-widest text-xs" href="https://ibsea.in/resources/everything-about-ibsea/view" target="_blank">
                                <span class="material-symbols-outlined text-lg">info</span>
                                Everything About IBSEA
                            </a>
                        </div>
                    </div>
                </div>
                <div class="aspect-video bg-secondary dark:bg-slate-900 rounded-2xl overflow-hidden relative shadow-lg">
                    <video class="w-full h-full object-cover" controls preload="metadata">
                        <source src="{{ asset('image/key initiatives (1).mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
            <div class="space-y-8">
                <div class="aspect-video bg-slate-200 dark:bg-slate-800 rounded-2xl overflow-hidden relative shadow-sm">
                    <iframe class="w-full h-full absolute inset-0" src="https://www.youtube.com/embed/3B5yI2h9aAE" title="IBSEA Intro" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="flex items-start gap-6">
                        <div class="bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 p-4 rounded-lg">
                            <span class="material-symbols-outlined text-4xl">rocket_launch</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-display font-black text-secondary dark:text-white mb-2 uppercase">Key Initiatives</h3>
                            <p class="text-slate-600 dark:text-slate-400 font-medium">Watch our global introductory campaigns and understand how we are bridging the gap between academia and industry on a national scale.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Events Section -->
<section data-aos="fade-up" class="py-20 bg-white dark:bg-surface-dark overflow-hidden">
    <div class="container mx-auto px-4 lg:px-16">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-2">
                    <span class="h-[2px] w-8 bg-primary"></span>
                    <span class="text-primary font-black uppercase tracking-widest text-[10px]">Calendar</span>
                </div>
                <h2 class="text-4xl text-center font-display font-black text-secondary dark:text-white uppercase tracking-tight">Upcoming Events</h2>
            </div>
            <a href="{{ url('/events') }}" class="group flex items-center gap-3 text-xs font-black text-slate-400 hover:text-primary transition-colors uppercase tracking-widest">
                View Full Calendar
                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>

        <div class="swiper program-swiper !pb-12">
            <div class="swiper-wrapper">
                @foreach($events as $event)
                <div class="swiper-slide h-auto">
                    <div class="bg-slate-100 dark:bg-slate-800/40 rounded-none border border-slate-100 dark:border-slate-700/50 p-6 flex flex-col h-full group hover:shadow-2xl transition-all">
                        <div class="relative aspect-[4/3] rounded-none overflow-hidden mb-6">
                            @if($event->featured_image)
                                <img src="{{ asset($event->featured_image) }}" class="w-full object-cover group-hover:scale-105 transition-transform duration-700 rounded-xl" alt="{{ $event->name }}">
                            @else
                                <div class="w-full h-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300">event</span>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 bg-primary text-secondary px-4 py-2 text-center shadow-lg">
                                <span class="block text-xl font-black">{{ date('d', strtotime($event->event_date)) }}</span>
                                <span class="block text-[10px] font-black uppercase">{{ date('M', strtotime($event->event_date)) }}</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-black text-secondary dark:text-white mb-4 line-clamp-2 uppercase tracking-tight">{{ $event->name }}</h3>
                        <div class="space-y-3 mb-8 flex-grow">
                            <div class="flex items-center gap-3 text-xs font-bold text-slate-500 dark:text-slate-400">
                                <span class="material-symbols-outlined text-sm text-primary">location_on</span>
                                {{ $event->city }}
                            </div>
                            <div class="flex items-center gap-3 text-xs font-bold text-slate-500 dark:text-slate-400">
                                <span class="material-symbols-outlined text-sm text-primary">schedule</span>
                                {{ date('h:i A', strtotime($event->start_time)) }}
                            </div>
                        </div>
                        <a href="{{ url('/event/'.$event->id) }}" class="w-full bg-secondary hover:bg-black text-white font-black py-4 rounded-none text-[10px] uppercase tracking-widest text-center transition-all shadow-lg shadow-black/5">
                            Program Details
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination program-pagination"></div>
        </div>
    </div>
</section>

<!-- Voices and Inquiry Section -->
<section data-aos="fade-up" class="py-24 bg-gray-50 dark:bg-slate-900/50 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-800 to-transparent"></div>
    <div class="container mx-auto px-4 lg:px-16">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            
            <!-- Voices Swiper -->
            <div data-aos="fade-right">
                <div class="inline-flex items-center gap-2 mb-6">
                    <span class="h-[2px] w-8 bg-primary"></span>
                    <span class="text-primary font-black uppercase tracking-widest text-[10px]">Ecosystem Impact</span>
                </div>
                <h2 class="text-4xl font-display font-black text-secondary dark:text-white uppercase mb-12 tracking-tight">Member Voices</h2>
                
                <div class="swiper voices-swiper w-[450px] md:w-full rounded-xl relative">
                    <div class="swiper-wrapper">
                        <!-- Voice 1 -->
                        <div class="swiper-slide h-auto">
                            <div class="bg-white dark:bg-surface-dark p-6 md:p-10 rounded-none shadow-2xl border border-slate-100 dark:border-slate-800 relative group overflow-hidden h-full">
                                <span class="material-symbols-outlined text-6xl md:text-8xl text-primary/5 absolute -top-4 -right-4 transition-transform group-hover:scale-110">format_quote</span>
                                <div class="relative z-10">
                                    <p class="text-lg text-slate-600 dark:text-slate-300 italic mb-10 leading-relaxed font-medium">
                                        "Being part of IBSEA has opened doors I never knew existed. The cross-border networking opportunities and the strategic insights from Bharat Ke Maharathi conclaves have played a pivotal role in our recent expansion."
                                    </p>
                                    <div class="flex items-center gap-5">
                                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-200 border-2 border-white dark:border-slate-700 shadow-md">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover" alt="Member">
                                        </div>
                                        <div>
                                            <h4 class="font-black text-secondary dark:text-white uppercase tracking-wider">Arjun Mehta</h4>
                                            <p class="text-[10px] font-black text-primary uppercase tracking-widest">Founder, Mehta Tech Sol</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Voice 2 -->
                        <div class="swiper-slide h-auto">
                            <div class="bg-white dark:bg-surface-dark p-6 md:p-10 rounded-none shadow-2xl border border-slate-100 dark:border-slate-800 relative group overflow-hidden h-full">
                                <span class="material-symbols-outlined text-6xl md:text-8xl text-primary/5 absolute -top-4 -right-4">format_quote</span>
                                <div class="relative z-10">
                                    <p class="text-lg text-slate-600 dark:text-slate-300 italic mb-10 leading-relaxed font-medium">
                                        "The mentorship access via IBSEA is unparalleled. Connecting with global industry stalwarts through the Director Mentor Conclave helped us refine our market positioning for a successful Series A."
                                    </p>
                                    <div class="flex items-center gap-5">
                                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-200 border-2 border-white dark:border-slate-700 shadow-md">
                                            <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=1974&auto=format&fit=crop" class="w-full h-full object-cover" alt="Member">
                                        </div>
                                        <div>
                                            <h4 class="font-black text-secondary dark:text-white uppercase tracking-wider">Priya Sharma</h4>
                                            <p class="text-[10px] font-black text-primary uppercase tracking-widest">CEO, InnovateHub</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4 mt-8">
                        <button class="voices-prev w-12 h-12 rounded-none border border-slate-200 dark:border-slate-800 flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all bg-white dark:bg-slate-900 shadow-sm">
                            <span class="material-symbols-outlined">arrow_back</span>
                        </button>
                        <button class="voices-next w-12 h-12 rounded-none border border-slate-200 dark:border-slate-800 flex items-center justify-center text-slate-400 hover:text-primary hover:border-primary transition-all bg-white dark:bg-slate-900 shadow-sm">
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Professional Enquiry Form -->
            <div id="enquiry-form" data-aos="fade-left">
                <div class="bg-secondary w-[450px] md:w-full dark:bg-slate-900 rounded-none p-10 lg:p-14 relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-display font-black text-white uppercase tracking-wider mb-2">Connect with Us</h3>
                        <p class="text-slate-400 text-sm mb-10 font-medium">Have questions about our programs or memberships? Reach out to our ecosystem experts.</p>
                        
                        <form action="{{ url('/enquiry') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                            @csrf
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Full Name</label>
                                <input type="text" name="name" required class="w-full bg-slate-800/50 border-b border-white/10 focus:border-primary px-0 py-3 text-white placeholder:text-slate-600 focus:ring-0 transition-all outline-none" placeholder="Enter name">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Address</label>
                                <input type="email" name="email" required class="w-full bg-slate-800/50 border-b border-white/10 focus:border-primary px-0 py-3 text-white placeholder:text-slate-600 focus:ring-0 transition-all outline-none" placeholder="Enter email">
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Select Purpose</label>
                                <select name="purpose" class="w-full bg-slate-800/50 border-b border-white/10 focus:border-primary px-0 py-3 text-white focus:ring-0 transition-all appearance-none outline-none">
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Membership">Membership Details</option>
                                    <option value="Corporate Partnership">Corporate Partnership</option>
                                    <option value="Speaker/Mentor Enquiry">Speaker/Mentor Enquiry</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Your Message</label>
                                <textarea name="message" rows="3" required class="w-full bg-slate-800/50 border-b border-white/10 focus:border-primary px-0 py-3 text-white placeholder:text-slate-600 focus:ring-0 transition-all resize-none outline-none" placeholder="Tell us how we can help..."></textarea>
                            </div>
                            <div class="md:col-span-2 pt-4">
                                <button type="submit" class="w-full bg-primary hover:bg-amber-600 text-secondary font-black py-5 rounded-none uppercase tracking-widest text-xs shadow-xl active:scale-[0.98] transition-all">
                                    Submit Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


@endsection

@push('scripts')
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- AOS Animation -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- Lenis Smooth Scroll -->
<script src="https://unpkg.com/@studio-freight/lenis@1.0.34/dist/lenis.min.js"></script>

<script>
    // Initialize AOS
    AOS.init({ 
        duration: 800, 
        once: true,
        offset: 50,
        easing: 'ease-out-quad',
        disable: 'mobile' // Optional: Disable animations on mobile if lag persists
    });

    // Initialize Lenis Smooth Scroll
    const lenis = new Lenis({
        duration: 1.1,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        orientation: 'vertical',
        gestureOrientation: 'vertical',
        smoothWheel: true,
        wheelMultiplier: 0.9,
        smoothTouch: false,
        touchMultiplier: 1.5,
        infinite: false,
    });

    function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);

    // Hero Swiper
    const heroSwiper = new Swiper('.hero-swiper', {
        loop: true,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        autoplay: { delay: 6000, disableOnInteraction: false },
        speed: 800,
        navigation: { nextEl: '.hero-next', prevEl: '.hero-prev' },
        pagination: { el: '.hero-pagination', clickable: true }
    });

    // Major Event Swiper (Landmark Event)
    const majorEventSwiper = new Swiper('.major-event-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: { delay: 5000 },
        pagination: { el: '.major-pagination', clickable: true }
    });

    // Institutional Resource Swiper
    const resourceSwiper = new Swiper('.resource-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        navigation: {
            nextEl: '.resource-next',
            prevEl: '.resource-prev',
        },
        breakpoints: {
            640: { slidesPerView: 2, spaceBetween: 20 },
            1024: { slidesPerView: 3, spaceBetween: 30 },
            1280: { slidesPerView: 4, spaceBetween: 30 }
        }
    });

    // Upcoming Programs Swiper
    const programSwiper = new Swiper('.program-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: { el: '.program-pagination', clickable: true },
        breakpoints: {
            640: { slidesPerView: 2, spaceBetween: 20 },
            1024: { slidesPerView: 3, spaceBetween: 30 },
            1280: { slidesPerView: 4, spaceBetween: 30 }
        }
    });

    // Membership Plans Swiper
    const membershipSwiper = new Swiper('.membership-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: '.membership-next',
            prevEl: '.membership-prev',
        },
        breakpoints: {
            640: { slidesPerView: 2, spaceBetween: 20 },
            1024: { slidesPerView: 3, spaceBetween: 30 },
            1280: { slidesPerView: 4, spaceBetween: 30 }
        }
    });

    // Member Voices Swiper
    const voicesSwiper = new Swiper('.voices-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoHeight: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        navigation: { nextEl: '.voices-next', prevEl: '.voices-prev' },
        breakpoints: {
            768: {
                spaceBetween: 30
            }
        }
    });

    // Sidebar Featured Events Mini Swiper
    const featuredEventSwiper = new Swiper('.featured-event-swiper', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        autoplay: { delay: 4000 },
        speed: 800
    });

    // Key Initiatives Swiper
    const initiativeSwiper = new Swiper('.initiative-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        allowTouchMove: true,
        speed: 600,
        on: {
            slideChange: function () {
                updateInitiativeTabs(this.activeIndex);
            }
        }
    });

    window.handleInitiativeChange = function(index) {
        initiativeSwiper.slideTo(index);
    }

    function updateInitiativeTabs(index) {
        const tabs = document.querySelectorAll('.tab-btn');
        tabs.forEach((tab, i) => {
            if (i === index) {
                tab.classList.add('active', 'bg-primary/5', 'text-secondary', 'border-primary', 'font-bold');
                tab.classList.remove('border-transparent', 'text-slate-600', 'font-medium');
            } else {
                tab.classList.remove('active', 'bg-primary/5', 'text-secondary', 'border-primary', 'font-bold');
                tab.classList.add('border-transparent', 'text-slate-600', 'font-medium');
            }
        });
    }


    // Counter Animation (Optimized with requestAnimationFrame)
    const animateCounters = () => {
        const counters = document.querySelectorAll('.counter');
        
        const updateCount = (el) => {
            const target = +el.getAttribute('data-target');
            const duration = 2000; // 2 seconds
            const startTime = performance.now();

            const step = (currentTime) => {
                const progress = Math.min((currentTime - startTime) / duration, 1);
                const currentVal = Math.floor(progress * target);
                el.innerText = currentVal;

                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    el.innerText = target;
                }
            };
            requestAnimationFrame(step);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    updateCount(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });

        counters.forEach(counter => observer.observe(counter));
    };

    // National Strategic Partner Swiper (Marquee Style - Forward)
    const nationalPartnerSwiper = new Swiper('.national-partner-swiper', {
        slidesPerView: 'auto',
        spaceBetween: 0,
        loop: true,
        speed: 5500,
        autoplay: {
            delay: 0,
            disableOnInteraction: false,
        },
        allowTouchMove: false,
    });

    // International Strategic Partner Swiper (Marquee Style - Reverse)
    const internationalPartnerSwiper = new Swiper('.international-partner-swiper', {
        slidesPerView: 'auto',
        spaceBetween: 0,
        loop: true,
        speed: 6000,
        autoplay: {
            delay: 0,
            disableOnInteraction: false,
            reverseDirection: true
        },
        allowTouchMove: false,
    });

    document.addEventListener('DOMContentLoaded', () => {
        animateCounters();
    });
</script>
@endpush
