@extends('layouts.app')

@push('styles')
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .bg-milestone-green { background-color: #f6790b; } /* Matching primary color */
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section data-aos="fade-up" class="relative w-full h-[600px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0 bg-cover bg-center bg-no-repeat"
            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDczLQAitM54B-dMiwFEH5GG312IxL0gbYZCvdubwBBEl7_6G1z-FqAK1WbgU_23gblXDbom8ZwGHFpk6TmOWl_xA5pIlSBUe47IbIsOeExZCI8NFS-gipH7iW24Ub1DJ3449Gr5bedmdyQVzY2qbtli3P79Cp5qpb3T0AfBBbn-MmXWaux6tx6XQstKbGDRlozvd0H6-PaEInOZXrF9sKiY-pQV5ScKazJlSJLdfMQHSquDixhXDGSW-spgqsT2cSTVcGgiz6xVMg");'>
        </div>
        <div class="absolute inset-0 z-10 bg-gradient-to-r from-secondary/90 via-secondary/70 to-transparent"></div>
        <div class="absolute inset-0 z-10 bg-gradient-to-t from-[#111827] via-transparent to-transparent"></div>
        <div class="relative z-20 w-full max-w-[1280px] mx-auto px-4 lg:px-10 flex flex-col gap-6 pt-16">
            <span
                class="inline-block px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-bold tracking-wider w-fit uppercase mb-2">
                Vision 2047
            </span>
            <h1
                class="text-white text-5xl lg:text-7xl font-black leading-tight tracking-[-0.03em] max-w-[800px] drop-shadow-xl uppercase">
                Empowering Global <br />
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-orange-300">Entrepreneurs</span>
            </h1>
            <p class="text-gray-200 text-lg lg:text-xl font-normal max-w-[600px] leading-relaxed">
                Building a Viksit Bharat @2047 through innovation, leadership, and global collaboration. Join the
                premier ecosystem for Indian startups.
            </p>
            <div class="pt-6">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 h-14 px-8 bg-primary text-white text-base font-bold rounded-lg shadow-lg shadow-primary/30 hover:bg-orange-600 hover:scale-105 transition-all duration-300 group">
                    <span>Join the Movement</span>
                    <span
                        class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Mission & Growth Story Section -->
    <section id="mission-growth" data-aos="fade-up" class="py-24 px-4 lg:px-10 bg-white dark:bg-[#1a120b] relative overflow-hidden">
        <div class="max-w-[1280px] mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                <!-- Left: Mission Text -->
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-3 mb-6">
                        <span class="h-[2px] w-10 bg-primary"></span>
                        <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">Mission@2047</span>
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-black text-secondary dark:text-white leading-tight mb-8 uppercase">
                        Catalyzing India's <br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-orange-500">Entrepreneurial Revolution</span>
                    </h2>
                    <div class="space-y-6 text-gray-600 dark:text-gray-400 text-lg leading-relaxed">
                        <p class="font-medium text-secondary dark:text-white">To actively contribute to the Viksit Bharat 2047 mission, we are scaling the International Business Startup and Entrepreneurs Association (IBSEA).</p>
                        <p>IBSEA is a Section 8, not-for-profit organization, operational for the past 27 months with a clear mandate to empower founders in Tier 2 and Tier 3 regions. We enable the <span class="text-primary font-bold">"Vocal for Local to Local to Global"</span> journey, transforming raw ideas into scalable global ventures.</p>
                        <p>We support entrepreneurs across the entire lifecycle — from ideation, validation, and incubation to branding, market positioning, and growth stage funding, offering a truly one-stop entrepreneurial ecosystem.</p>
                    </div>

                    <!-- Roadmap Visual -->
                    <div class="mt-12 p-8 bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] border border-slate-100 dark:border-slate-800">
                        <h4 class="text-sm font-black uppercase tracking-widest text-secondary dark:text-white mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">analytics</span>
                            Expansion Roadmap
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="flex gap-4">
                                <div class="size-12 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-primary">map</span>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-tighter">National Reach</p>
                                    <p class="text-secondary dark:text-white font-black">Active in 10 States, expanding to all Indian States by year-end.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="size-12 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-primary">public</span>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-tighter">Global Footprint</p>
                                    <p class="text-secondary dark:text-white font-black">Establishing presence in 25 countries worldwide within 2 years.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Impact Stats Grid -->
                <div class="lg:col-span-1"></div> <!-- Spacer -->
                <div class="lg:col-span-4 grid grid-cols-2 gap-4">
                    <div class="p-6 bg-white dark:bg-slate-800/40 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-primary/30 transition-colors group">
                        <p class="text-3xl font-black text-secondary dark:text-white group-hover:text-primary transition-colors">65+</p>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">MoU Partners</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-slate-800/40 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-primary/30 transition-colors group">
                        <p class="text-3xl font-black text-secondary dark:text-white group-hover:text-primary transition-colors">15</p>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">Strategic Alliances</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-slate-800/40 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-primary/30 transition-colors group">
                        <p class="text-3xl font-black text-secondary dark:text-white group-hover:text-primary transition-colors">21</p>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">Strategic Councils</p>
                    </div>
                    <div class="p-6 bg-white dark:bg-slate-800/40 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-primary/30 transition-colors group">
                        <p class="text-3xl font-black text-secondary dark:text-white group-hover:text-primary transition-colors">13</p>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">Annual Programs</p>
                    </div>
                    <div class="col-span-2 p-8 bg-primary/5 rounded-[2rem] border border-primary/10 mt-4">
                        <div class="flex items-start gap-4">
                            <div class="size-10 bg-primary rounded-full flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-white text-sm">groups</span>
                            </div>
                            <div>
                                <p class="text-secondary dark:text-white font-bold leading-tight line-clamp-2">Powered by a network of 100+ Mentors, 10 Investors, and 35 Global Influencers.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chairman's Message -->
    <section id="chairman-message" data-aos="fade-up" class="py-20 px-4 lg:px-10 bg-background-light dark:bg-background-dark">
        <div class="max-w-[1100px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="relative group">
                <div
                    class="absolute -inset-4 bg-gradient-to-tr from-primary/20 to-secondary/20 rounded-2xl blur-lg opacity-70 group-hover:opacity-100 transition-opacity duration-500">
                </div>
                <div class="relative h-[500px] w-full rounded-2xl overflow-hidden shadow-2xl">
                    <img alt="Portrait of the Chairman"
                        class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-700"
                        src="{{ asset('image/chairman.jpg') }}" />
                    <div
                        class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-8">
                        <h3 class="text-white text-xl font-bold">Dr. Anshumaan Singh</h3>
                        <p class="text-gray-300 text-sm">Chairman, IBSEA</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-3 mb-2">
                    <span class="h-[2px] w-12 bg-primary"></span>
                    <span class="text-primary font-bold uppercase tracking-widest text-sm">Chairman's Message</span>
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-secondary dark:text-white leading-tight uppercase">
                    From Local Roots to <br /><span class="text-primary">Global Reach</span>
                </h2>
                <div class="space-y-4 text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
                    <p>
                        "Our vision is not just to support startups, but to catalyze a revolution. We believe that every
                        local innovation holds the seed of a global powerhouse."
                    </p>
                    <p>
                        At IBSEA, we are committed to bridging the gap between potential and performance. Through
                        strategic mentorship, robust policy advocacy, and unparalleled network access, we are crafting
                        the architecture for India's economic sovereignty in 2047.
                    </p>
                </div>
                <div class="pt-4">
                    <img alt="Dr. Anshumaan Singh Signature" class="h-12 w-auto opacity-70 dark:invert filter invert-0"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuArCJfJBRXiun_VbAoCCOpEcbyw0Tx-5icTHGhNko-KXvz6WnhH4WRbf8gzkbYc_6OctR6OT7H0mR_BIjXMHJkIKGyB40HbKMlP-b3uh8W1L07ZFPkXeXk1VLC4DzVKBKALzJWNB3PSSCnVAZTwfg5QqCK7CBno2uCiMM_XiJLLdDVAdet_Tcxz4ov9IdPSns6ojg5CgpUnPXIkY8PM0drAccshPLG0OIZyBEh33SLSZaCnZIR8T0n2vdt5XI74KWppV4sSQ54DKeI" />
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose IBSEA -->
    <section data-aos="fade-up" class="py-20 px-4 lg:px-10 bg-white dark:bg-[#1a120b]">
        <div class="max-w-[1280px] mx-auto flex flex-col gap-16">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-3 mb-4">
                    <span class="h-[2px] w-10 bg-primary"></span>
                    <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">Core Value</span>
                    <span class="h-[2px] w-10 bg-primary"></span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-black text-secondary dark:text-white mb-4 uppercase">Why Choose <span class="text-primary">IBSEA?</span></h2>
                <p class="text-gray-600 dark:text-gray-400">We provide the ecosystem, tools, and connections necessary to transform ambitious ideas into industry-leading enterprises.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="group bg-[#fcfaf8] dark:bg-[#2c2016] p-8 rounded-xl border-t-4 border-primary shadow-sm hover-lift relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-8xl text-primary font-light">public</span>
                    </div>
                    <div class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">public</span>
                    </div>
                    <h3 class="text-xl font-bold text-secondary dark:text-white mb-3">Global Networking</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Access to an exclusive network of international investors, mentors, and industry veterans across 30+ countries.</p>
                </div>
                <!-- Card 2 -->
                <div class="group bg-[#fcfaf8] dark:bg-[#2c2016] p-8 rounded-xl border-t-4 border-primary shadow-sm hover-lift relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-8xl text-primary font-light">gavel</span>
                    </div>
                    <div class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">gavel</span>
                    </div>
                    <h3 class="text-xl font-bold text-secondary dark:text-white mb-3">Policy Advocacy</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Direct representation to government bodies to shape policies that foster innovation and ease of doing business.</p>
                </div>
                <!-- Card 3 -->
                <div class="group bg-[#fcfaf8] dark:bg-[#2c2016] p-8 rounded-xl border-t-4 border-primary shadow-sm hover-lift relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-8xl text-primary font-light">storefront</span>
                    </div>
                    <div class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">storefront</span>
                    </div>
                    <h3 class="text-xl font-bold text-secondary dark:text-white mb-3">Market Access</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Strategic partnerships opening doors to untapped markets in Southeast Asia, MENA, and Europe.</p>
                </div>
                <!-- Card 4 -->
                <div class="group bg-[#fcfaf8] dark:bg-[#2c2016] p-8 rounded-xl border-t-4 border-primary shadow-sm hover-lift relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-8xl text-primary font-light">school</span>
                    </div>
                    <div class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">school</span>
                    </div>
                    <h3 class="text-xl font-bold text-secondary dark:text-white mb-3">Expert Mentorship</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">One-on-one guidance from seasoned entrepreneurs who have successfully scaled businesses globally.</p>
                </div>
                <!-- Card 5 -->
                <div class="group bg-[#fcfaf8] dark:bg-[#2c2016] p-8 rounded-xl border-t-4 border-primary shadow-sm hover-lift relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-8xl text-primary font-light">attach_money</span>
                    </div>
                    <div class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">attach_money</span>
                    </div>
                    <h3 class="text-xl font-bold text-secondary dark:text-white mb-3">Capital Facilitation</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Curated pitch sessions and investor connect programs designed to secure growth capital.</p>
                </div>
                <!-- Card 6 -->
                <div class="group bg-[#fcfaf8] dark:bg-[#2c2016] p-8 rounded-xl border-t-4 border-primary shadow-sm hover-lift relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-8xl text-primary font-light">hub</span>
                    </div>
                    <div class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">hub</span>
                    </div>
                    <h3 class="text-xl font-bold text-secondary dark:text-white mb-3">Resource Hub</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Comprehensive library of legal frameworks, market reports, and compliance checklists.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Organizational Structure -->
    <section id="structure" data-aos="fade-up" class="py-20 px-4 lg:px-10 bg-background-light dark:bg-background-dark overflow-hidden">
        <div class="max-w-[1280px] mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-3 mb-4">
                    <span class="h-[2px] w-10 bg-primary"></span>
                    <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">Organizational Hierarchy</span>
                    <span class="h-[2px] w-10 bg-primary"></span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-black text-secondary dark:text-white mb-4 uppercase">IBSEA National Leadership <span class="text-primary">Structure</span></h2>
                <p class="text-gray-600 dark:text-gray-400">300+ Members || Core IBSEA Management.</p>
            </div>
            <!-- Hierarchy Flow -->
            <div class="relative flex flex-col items-center mb-24">
                <!-- Level 1 -->
                <div class="z-10 bg-white dark:bg-[#2c2016] border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-6 w-64 text-center">
                    <div class="text-primary font-bold mb-1">Leadership</div>
                    <div class="text-sm text-gray-500">Chairman & 5 Strategic Advisors</div>
                </div>
                <div class="h-12 w-0.5 bg-gray-300 dark:bg-gray-600"></div>
                <!-- Level 2 -->
                <div class="z-10 bg-white dark:bg-[#2c2016] border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-6 w-64 text-center">
                    <div class="text-secondary dark:text-gray-200 font-bold mb-1">Core Management</div>
                    <div class="text-sm text-gray-500">15 Core Team Alliances</div>
                </div>
                <!-- Tree Connectors simplified for Responsive -->
                <div class="relative h-12 w-full max-w-[600px] mt-0">
                    <div class="absolute left-1/2 top-0 h-full w-0.5 bg-gray-300 dark:bg-gray-600 -translate-x-1/2"></div>
                    <div class="absolute left-0 bottom-0 h-0.5 w-full bg-gray-300 dark:bg-gray-600"></div>
                </div>
                <!-- Level 3 -->
                <div class="flex justify-between w-full max-w-[800px] mt-6 gap-4">
                    <div class="relative flex flex-col items-center flex-1">
                        <div class="absolute -top-6 h-6 w-0.5 bg-gray-300 dark:bg-gray-600"></div>
                        <div class="bg-white dark:bg-[#2c2016] border border-gray-200 dark:border-gray-700 rounded-lg shadow p-4 text-center w-full">
                            <div class="text-secondary dark:text-gray-200 font-bold text-sm">25 Advisors</div>
                        </div>
                    </div>
                    <div class="relative flex flex-col items-center flex-1">
                        <div class="absolute -top-6 h-6 w-0.5 bg-gray-300 dark:bg-gray-600"></div>
                        <div class="bg-white dark:bg-[#2c2016] border border-gray-200 dark:border-gray-700 rounded-lg shadow p-4 text-center w-full">
                            <div class="text-secondary dark:text-gray-200 font-bold text-sm">50+ MOU Partners</div>
                        </div>
                    </div>
                </div>
                <div class="h-12 w-0.5 bg-gray-300 dark:bg-gray-600"></div>
                 <div class="relative h-12 w-full max-w-[600px] mt-0">
                    <div class="absolute left-1/2 top-0 h-full w-0.5 bg-gray-300 dark:bg-gray-600 -translate-x-1/2"></div>
                    <div class="absolute left-0 bottom-0 h-0.5 w-full bg-gray-300 dark:bg-gray-600"></div>
                </div>
                <!-- Level 4 -->
                <div class="flex justify-between w-full max-w-[800px] mt-6 gap-4">
                    <div class="relative flex flex-col items-center flex-1">
                        <div class="absolute -top-6 h-6 w-0.5 bg-gray-300 dark:bg-gray-600"></div>
                        <div class="bg-white dark:bg-[#2c2016] border border-gray-200 dark:border-gray-700 rounded-lg shadow p-4 text-center w-full">
                            <div class="text-secondary dark:text-gray-200 font-bold text-sm">10 Investors</div>
                        </div>
                    </div>
                    <div class="relative flex flex-col items-center flex-1">
                        <div class="absolute -top-6 h-6 w-0.5 bg-gray-300 dark:bg-gray-600"></div>
                        <div class="bg-white dark:bg-[#2c2016] border border-gray-200 dark:border-gray-700 rounded-lg shadow p-4 text-center w-full">
                            <div class="text-secondary dark:text-gray-200 font-bold text-sm">35 Influencers</div>
                        </div>
                    </div>
                </div>
                <div class="h-12 w-0.5 bg-gray-300 dark:bg-gray-600"></div>
                <!-- Level 5 -->
                <div class="z-10 bg-white dark:bg-[#2c2016] border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-6 w-64 text-center">
                    <div class="text-secondary dark:text-gray-200 font-bold mb-1">Knowledge & Training</div>
                    <div class="text-sm text-gray-500">100 Mentors/Trainers</div>
                </div>
            </div>
            
            <!-- 21 Council Diagram -->
            <div class="bg-secondary dark:bg-[#15100c] rounded-2xl p-8 lg:p-12 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <div class="text-center mb-6">
                    <h3 class="text-4xl lg:text-5xl font-bold mb-2 text-center relative z-10 uppercase">21 Councils For 21st Century</h3>
                    <p class="text-gray-100 italic">आत्मनिर्भर भारत के सपने को साकार करने हेतु एक पहल</p>
                </div>
                <div class="flex flex-wrap justify-center gap-4 relative z-10">
                    <div class="w-full flex justify-center mb-6">
                        <div class="bg-gradient-to-br from-primary to-orange-600 size-24 rounded-full flex items-center justify-center shadow-lg shadow-orange-500/30 border-4 border-[#15100c]">
                            <span class="material-symbols-outlined text-4xl">hub</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-3 max-w-6xl mx-auto">
                        @foreach([
                            'Startup & Innovation Council', 'MSME & Industry Development Council', 'Skill Development & Education Council',
                            'Corporate & Leadership Council', 'Women Entrepreneurship Council', 'Youth Entrepreneurship Council',
                            'Agriculture & Rural Development Council', 'Technology & Artificial Intelligence Council', 'Digital Economy & E-Commerce Council',
                            'Export, Trade & Global Markets Council', 'Investment & Funding Council', 'Policy, Governance & Public Affairs Council',
                            'Sustainability & Climate Action Council', 'Healthcare & Wellness Council', 'Media, Branding & Communications Council',
                            'Tourism, Hospitality & Culture Council', 'Infrastructure & Urban Development Council', 'Social Impact & NGO Collaboration Council',
                            'Research, Strategy & Knowledge Council', 'Startup Mentorship & Advisory Council', 'International Relations & Global Connect Council'
                        ] as $council)
                            <span class="px-4 py-2 rounded-full bg-white/10 border border-white/20 text-[10px] md:text-sm font-medium hover:bg-white/20 transition-colors cursor-default whitespace-nowrap uppercase tracking-tight">
                                {{ $council }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements -->
    <section id="achievements" data-aos="fade-up" class="py-20 px-4 lg:px-10 bg-white dark:bg-[#1a120b]">
        <div class="max-w-[1000px] mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-3 mb-4">
                    <span class="h-[2px] w-10 bg-primary"></span>
                    <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">Our Journey</span>
                    <span class="h-[2px] w-10 bg-primary"></span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-black text-secondary dark:text-white mb-4 uppercase">Milestones of <span class="text-primary">Growth</span></h2>
                <p class="text-gray-600 dark:text-gray-400">Charting our path from inception to the vision of 2047.</p>
            </div>
            <div class="relative">
                <div class="absolute left-[20px] lg:left-1/2 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700 lg:-translate-x-1/2"></div>
                <div class="flex flex-col gap-12 lg:gap-24">
                    <!-- Milestone 1 -->
                    <div class="flex flex-col lg:flex-row items-start lg:items-center w-full relative group">
                        <div class="w-full lg:w-1/2 lg:pr-12 lg:text-right pl-12 lg:pl-0 order-2 lg:order-1">
                            <h3 class="text-2xl font-bold text-secondary dark:text-white">2023: Inception</h3>
                            <p class="text-gray-500 mt-2">Founded with 50 charter members and a mission to unify the startup ecosystem.</p>
                        </div>
                        <div class="absolute left-0 lg:left-1/2 size-10 rounded-full border-4 border-white dark:border-[#1a120b] bg-primary flex items-center justify-center z-10 lg:-translate-x-1/2 order-1 lg:order-2 shadow-lg group-hover:scale-125 transition-transform duration-300">
                            <span class="size-3 bg-white rounded-full"></span>
                        </div>
                        <div class="w-full lg:w-1/2 lg:pl-12 order-3"></div>
                    </div>
                    <!-- Milestone 2 -->
                    <div class="flex flex-col lg:flex-row items-start lg:items-center w-full relative group">
                        <div class="w-full lg:w-1/2 order-3 lg:order-1 hidden lg:block"></div>
                        <div class="absolute left-0 lg:left-1/2 size-10 rounded-full border-4 border-white dark:border-[#1a120b] bg-primary flex items-center justify-center z-10 lg:-translate-x-1/2 order-1 lg:order-2 shadow-lg group-hover:scale-125 transition-transform duration-300">
                            <span class="size-3 bg-white rounded-full"></span>
                        </div>
                        <div class="w-full lg:w-1/2 lg:pl-12 pl-12 order-3 lg:order-3">
                            <h3 class="text-2xl font-bold text-secondary dark:text-white">2025: Global Expansion</h3>
                            <p class="text-gray-500 mt-2">Establishing international chapters in Dubai, London, Singapore, New York, and Tokyo.</p>
                        </div>
                    </div>
                    <!-- Milestone 3 -->
                    <div class="flex flex-col lg:flex-row items-start lg:items-center w-full relative group">
                        <div class="w-full lg:w-1/2 lg:pr-12 lg:text-right pl-12 lg:pl-0 order-2 lg:order-1">
                            <h3 class="text-2xl font-bold text-secondary dark:text-white">2030: The Unicorn Decadal</h3>
                            <p class="text-gray-500 mt-2">Targeting support for 100 new unicorns originating from Tier 2 & 3 cities.</p>
                        </div>
                        <div class="absolute left-0 lg:left-1/2 size-10 rounded-full border-4 border-white dark:border-[#1a120b] bg-primary flex items-center justify-center z-10 lg:-translate-x-1/2 order-1 lg:order-2 shadow-lg group-hover:scale-125 transition-transform duration-300">
                            <span class="size-3 bg-white rounded-full"></span>
                        </div>
                        <div class="w-full lg:w-1/2 lg:pl-12 order-3"></div>
                    </div>
                    <!-- Milestone 4 -->
                    <div class="flex flex-col lg:flex-row items-start lg:items-center w-full relative group">
                        <div class="w-full lg:w-1/2 order-3 lg:order-1 hidden lg:block"></div>
                        <div class="absolute left-0 lg:left-1/2 size-10 rounded-full border-4 border-white dark:border-[#1a120b] bg-primary flex items-center justify-center z-10 lg:-translate-x-1/2 order-1 lg:order-2 shadow-lg group-hover:scale-125 transition-transform duration-300 animate-pulse">
                            <span class="material-symbols-outlined text-white text-sm font-bold">star</span>
                        </div>
                        <div class="w-full lg:w-1/2 lg:pl-12 pl-12 order-3 lg:order-3">
                            <h3 class="text-2xl font-bold text-primary">2047: Viksit Bharat</h3>
                            <p class="text-gray-500 mt-2">A fully developed ecosystem contributing 20% to India's GDP through innovation and global trade.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Sliders -->
    @php
        $sliders = [
            ['id' => 'strategic-advisors', 'title' => 'Strategic Advisory', 'highlight' => 'Board', 'subtitle' => 'Core Governance', 'data' => $strategic_advisors, 'class' => 'strategicSwiper', 'prev' => 'strategic-prev', 'next' => 'strategic-next', 'role_label' => 'Strategic Advisor', 'color' => 'primary'],
            ['id' => 'board-members', 'title' => 'Board', 'highlight' => 'Members', 'subtitle' => 'Institutional Leadership', 'data' => $board_members, 'class' => 'boardSwiper', 'prev' => 'board-prev', 'next' => 'board-next', 'role_label' => 'Board Member', 'color' => 'orange-600'],
            ['id' => 'advisors', 'title' => 'Our', 'highlight' => 'Advisors', 'subtitle' => 'Expert Counsel', 'data' => $advisors, 'class' => 'advisorsSwiper', 'prev' => 'advisors-prev', 'next' => 'advisors-next', 'role_label' => 'Advisor', 'color' => 'primary'],
            ['id' => 'alliance-leadership', 'title' => 'Strategic Alliance', 'highlight' => 'Heads', 'subtitle' => 'Mission Execution', 'data' => $alliance_heads, 'class' => 'allianceSwiper', 'prev' => 'alliance-prev', 'next' => 'alliance-next', 'role_label' => 'Alliance Head', 'color' => 'orange-600'],
            ['id' => 'state-presidents', 'title' => 'State', 'highlight' => 'Presidents', 'subtitle' => 'Regional Network', 'data' => $state_presidents, 'class' => 'stateSwiper', 'prev' => 'state-prev', 'next' => 'state-next', 'role_label' => 'State President', 'color' => 'primary'],
            ['id' => 'vice-presidents', 'title' => 'Vice', 'highlight' => 'Presidents', 'subtitle' => 'Operational Excellence', 'data' => $vice_presidents, 'class' => 'vpSwiper', 'prev' => 'vp-prev', 'next' => 'vp-next', 'role_label' => 'Vice President', 'color' => 'orange-500']
        ];
    @endphp

    @foreach($sliders as $slider)
        @if($slider['data']->isNotEmpty())
            <section id="{{ $slider['id'] }}" data-aos="fade-up" class="py-24 px-4 lg:px-10 border-t border-gray-100 dark:border-gray-800 {{ $loop->index % 2 == 0 ? 'bg-white dark:bg-[#1a120b]' : 'bg-[#fcfaf8] dark:bg-[#15100c]' }}">
                <div class="max-w-[1280px] mx-auto">
                    <div class="text-center mb-16">
                        <div class="inline-flex items-center gap-3 mb-4">
                            <span class="h-[2px] w-10 bg-primary"></span>
                            <span class="text-primary font-bold uppercase tracking-[0.2em] text-[11px]">{{ $slider['subtitle'] }}</span>
                            <span class="h-[2px] w-10 bg-primary"></span>
                        </div>
                        <h2 class="text-3xl lg:text-5xl font-black text-secondary dark:text-white uppercase">{{ $slider['title'] }} <span class="text-{{ $slider['color'] }}">{{ $slider['highlight'] }}</span></h2>
                    </div>
                    
                    <div class="relative group px-12">
                        <div class="swiper {{ $slider['class'] }}">
                            <div class="swiper-wrapper py-10">
                                @foreach($slider['data'] as $member)
                                    <div class="swiper-slide flex flex-col items-center text-center group/slide">
                                        <div class="relative mb-8">
                                            <div class="absolute -inset-4 bg-gradient-to-tr from-primary/30 to-secondary/30 rounded-full blur-xl opacity-0 group-hover/slide:opacity-100 transition-all duration-700"></div>
                                            <div class="size-48 rounded-full overflow-hidden relative border-8 border-white dark:border-slate-800 shadow-2xl mx-auto">
                                                @if($member->profile_image)
                                                    <img src="{{ $member->profile_image }}" alt="{{ $member->name }}" class="w-full h-full object-cover group-hover/slide:scale-110 transition-transform duration-1000" />
                                                @else
                                                    <div class="w-full h-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-6xl text-slate-300">person</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <h4 class="font-black text-2xl text-secondary dark:text-white mb-2 uppercase">{{ $member->name }}</h4>
                                        <div class="px-4 py-1 bg-primary/10 rounded-full mb-3 inline-block">
                                            <p class="text-[10px] font-black text-primary uppercase tracking-[0.1em]">{{ $slider['role_label'] }}</p>
                                        </div>
                                        <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm px-6 h-12 line-clamp-2">
                                            @if($slider['id'] == 'alliance-leadership')
                                                {{ $member->alliance_name ?? 'Strategic Global Alliances' }}
                                            @elseif($slider['id'] == 'advisors' || $slider['id'] == 'board-members' || $slider['id'] == 'strategic-advisors')
                                                {{ $member->short_description ?? $member->profession ?? $member->industry ?? 'Institutional Leadership' }}
                                            @elseif($slider['id'] == 'state-presidents' || $slider['id'] == 'vice-presidents')
                                                {{ $member->chapter->name ?? $member->state_country ?? 'Regional Chapter' }} {{ ($member->chapter->name ?? false) ? 'Chapter' : '' }}
                                            @else
                                                {{ $member->state_country ?? 'Regional Chapter' }}
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button class="{{ $slider['prev'] }} absolute left-0 top-1/2 -translate-y-1/2 z-20 size-12 bg-white dark:bg-slate-800 rounded-full shadow-lg flex items-center justify-center text-secondary dark:text-white border border-slate-100 dark:border-slate-700 hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                        <button class="{{ $slider['next'] }} absolute right-0 top-1/2 -translate-y-1/2 z-20 size-12 bg-white dark:bg-slate-800 rounded-full shadow-lg flex items-center justify-center text-secondary dark:text-white border border-slate-100 dark:border-slate-700 hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>
            </section>
        @endif
    @endforeach

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1000,
                easing: 'ease-out-cubic',
                once: true,
                offset: 100
            });

            const swiperOptions = {
                slidesPerView: 2,
                spaceBetween: 20,
                loop: true,
                breakpoints: {
                    1024: { slidesPerView: 4, spaceBetween: 30 }
                }
            };

            // Initialize all carousels
            ['strategic', 'board', 'advisors', 'alliance', 'state', 'vp'].forEach(key => {
                const selector = `.${key}Swiper`;
                if (document.querySelector(selector)) {
                    new Swiper(selector, {
                        ...swiperOptions,
                        observer: true,
                        observeParents: true,
                        watchOverflow: true,
                        navigation: {
                            nextEl: `.${key}-next`,
                            prevEl: `.${key}-prev`,
                        }
                    });
                }
            });
        });
    </script>
@endpush
