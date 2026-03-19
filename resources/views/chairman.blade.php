<!DOCTYPE html>
<html class="scroll-smooth" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Dr. Anshumaan Singh | Startup Mentor &amp; Leadership Coach</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@300;400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-secondary-fixed-variant": "#035300",
                        "secondary": "#056e00",
                        "primary-fixed-dim": "#ffb77a",
                        "on-primary-fixed": "#2e1500",
                        "surface": "#f9f9fb",
                        "on-primary": "#ffffff",
                        "surface-container": "#eeeef0",
                        "on-secondary-container": "#067500",
                        "on-secondary-fixed": "#012200",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-container": "#a5abff",
                        "primary": "#8f4e00",
                        "on-secondary": "#ffffff",
                        "primary-fixed": "#ffdcc2",
                        "surface-container-low": "#f3f3f5",
                        "on-error-container": "#93000a",
                        "on-surface": "#1a1c1d",
                        "tertiary-fixed": "#e0e0ff",
                        "on-error": "#ffffff",
                        "on-tertiary-container": "#3036a0",
                        "outline-variant": "#dbc2b0",
                        "tertiary-fixed-dim": "#bfc2ff",
                        "on-tertiary-fixed": "#00006e",
                        "surface-tint": "#8f4e00",
                        "on-tertiary": "#ffffff",
                        "surface-container-highest": "#e2e2e4",
                        "on-surface-variant": "#554336",
                        "inverse-surface": "#2f3132",
                        "secondary-container": "#8dfc75",
                        "tertiary": "#4b53bc",
                        "on-background": "#1a1c1d",
                        "error": "#ba1a1a",
                        "on-primary-container": "#693800",
                        "primary-container": "#ff9933",
                        "surface-dim": "#d9dadc",
                        "surface-container-high": "#e8e8ea",
                        "outline": "#887364",
                        "error-container": "#ffdad6",
                        "background": "#f9f9fb",
                        "inverse-primary": "#ffb77a",
                        "on-tertiary-fixed-variant": "#3239a3",
                        "on-primary-fixed-variant": "#6d3a00",
                        "surface-variant": "#e2e2e4",
                        "surface-bright": "#f9f9fb",
                        "secondary-fixed-dim": "#72de5c",
                        "secondary-fixed": "#8dfc75",
                        "inverse-on-surface": "#f0f0f2"
                    },
                    fontFamily: {
                        "headline": ["Plus Jakarta Sans"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
                },
            },
        }
    </script>
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
        }

        .statue-metric {
            font-feature-settings: "tnum" on, "lnum" on;
        }
    </style>
</head>

<body class="bg-surface text-on-surface font-body selection:bg-primary-container selection:text-on-primary-container">
    <!-- Top Navigation Bar -->
    @include('partials.header')
    <main>
        <!-- Hero Section -->
        <section class="relative pt-32 pb-24 px-8 overflow-hidden bg-white" id="home">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 z-10">
                    <p class="text-xl lg:text-3xl text-primary italic font-headline font-bold mb-8">
                        Transforming Visions Into Ventures
                    </p>
                    <h1
                        class="text-6xl lg:text-7xl font-headline font-extrabold text-on-surface leading-[1.1] tracking-tight mb-4">
                        Dr. Anshumaan Singh
                    </h1>
                    <span
                        class="text-secondary font-headline font-bold tracking-widest text-sm mb-4 block">Chairman – International Business Startup and Entrepreneurs Association (IBSEA) </span>
                    
                    <p class="text-xl text-on-surface-variant max-w-xl mb-10 leading-relaxed font-bold border-l-4 border-primary pl-4">
                        “You don’t need more motivation — you need mentorship that works.”
                    </p>
                    <p class="text-lg text-on-surface-variant max-w-xl mb-6 leading-relaxed">
                        Dr. Anshumaan Singh is one of India’s most recognized figures in startup mentorship, strategic growth consulting, and leadership development. As the Chairman of the International Business Startup and Entrepreneurs Association (IBSEA), he has dedicated his career to empowering individuals, startups, and institutions to achieve measurable growth and long-term impact.
                    </p>
                    <div class="flex flex-wrap gap-4 mb-10">
                        <a href="https://facebook.com/anshumaansinghofficial" target="_blank" class="w-10 h-10 rounded-full bg-blue-600/10 flex items-center justify-center text-blue-600 border border-blue-600/20 hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Facebook">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="https://linkedin.com/in/anshumaansinghofficial" target="_blank" class="w-10 h-10 rounded-full bg-blue-700/10 flex items-center justify-center text-blue-700 border border-blue-700/20 hover:bg-blue-700 hover:text-white transition-all shadow-sm" title="LinkedIn">
                            <i class="fa-brands fa-linkedin-in text-sm"></i>
                        </a>
                        <a href="https://instagram.com/anshumaansinghofficial" target="_blank" class="w-10 h-10 rounded-full bg-pink-600/10 flex items-center justify-center text-pink-600 border border-pink-600/20 hover:bg-pink-600 hover:text-white transition-all shadow-sm" title="Instagram">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="https://x.com/anshu_maansingh" target="_blank" class="w-10 h-10 rounded-full bg-slate-900/10 flex items-center justify-center text-slate-900 border border-slate-900/20 hover:bg-slate-900 hover:text-white transition-all shadow-sm" title="X (Twitter)">
                            <i class="fa-brands fa-x-twitter text-sm"></i>
                        </a>
                        <a href="https://youtube.com/@anshumaansinghofficial" target="_blank" class="w-10 h-10 rounded-full bg-red-600/10 flex items-center justify-center text-red-600 border border-red-600/20 hover:bg-red-600 hover:text-white transition-all shadow-sm" title="YouTube">
                            <i class="fa-brands fa-youtube text-sm"></i>
                        </a>
                        <a href="https://wa.me/918756952378" target="_blank" class="w-10 h-10 rounded-full bg-green-500/10 flex items-center justify-center text-green-500 border border-green-500/20 hover:bg-green-500 hover:text-white transition-all shadow-sm" title="WhatsApp">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <a href="#contact"
                            class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-4 rounded-md font-bold text-lg shadow-xl shadow-primary/20 hover:translate-y-[-2px] transition-all">
                            Book a Consultation
                        </a>
                        <a href="#services"
                            class="border border-outline-variant text-on-surface px-8 py-4 rounded-md font-bold text-lg hover:bg-surface-container-low transition-all">
                            Explore Programs
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-5 relative">
                    <div class="absolute -top-12 -left-12 w-64 h-64 bg-primary-container/10 rounded-full blur-3xl">
                    </div>
                    <div
                        class="absolute -bottom-12 -right-12 w-64 h-64 bg-secondary-container/10 rounded-full blur-3xl">
                    </div>
                    <div class="relative bg-surface-container rounded-xl overflow-hidden aspect-[4/5] shadow-2xl flex items-center justify-center">
                        <img alt="Dr. Anshumaan Singh Professional Portrait" class="w-full h-full object-cover"
                            data-alt="Professional portrait of Dr. Anshumaan Singh in executive attire"
                            src="{{ asset('image/chairman.jpg') }}" onerror="this.src='{{ asset('image/avatar.jpg') }}'" />
                    </div>
                </div>
            </div>
        </section>
        <!-- Statue Metrics (About Summary) -->
        <section class="bg-blue-900 py-20 px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center md:text-left">
                        <div class="text-4xl lg:text-5xl font-headline font-extrabold text-white statue-metric mb-2">
                            2.5L+</div>
                        <div class="text-primary-container font-headline font-bold text-sm tracking-wider uppercase">
                            Students Mentored</div>
                    </div>
                    <div class="text-center md:text-left">
                        <div class="text-4xl lg:text-5xl font-headline font-extrabold text-white statue-metric mb-2">
                            10k+</div>
                        <div class="text-primary-container font-headline font-bold text-sm tracking-wider uppercase">
                            Meetings Conducted</div>
                    </div>
                    <div class="text-center md:text-left">
                        <div class="text-4xl lg:text-5xl font-headline font-extrabold text-white statue-metric mb-2">
                            185+</div>
                        <div class="text-primary-container font-headline font-bold text-sm tracking-wider uppercase">
                            Institutions Reached</div>
                    </div>
                    <div class="text-center md:text-left">
                        <div class="text-4xl lg:text-5xl font-headline font-extrabold text-white statue-metric mb-2">
                            180+</div>
                        <div class="text-primary-container font-headline font-bold text-sm tracking-wider uppercase">
                            Global Awards</div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Section -->
        <section class="py-24 px-8 bg-surface" id="about">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-20 items-center">
                <div class="lg:w-1/2">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-surface-container-lowest p-1 rounded-lg shadow-sm">
                            <img alt="Corporate Workshop" class="rounded-lg object-cover h-100 w-full"
                                data-alt="Dr. Singh conducting a corporate workshop session"
                                src="https://ibsea.in/uploads/members/698f90b40b785.jpg" />
                        </div>
                        <div class="bg-surface-container-lowest p-1 rounded-lg shadow-sm mt-8">
                            <img alt="Leadership Speech" class="rounded-lg object-cover h-64 w-full"
                                data-alt="Dr. Singh delivering a keynote speech at a summit"
                                src="{{ asset('image/anshumaan-image-building-1536x1536.jpg') }}" />
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-headline font-bold mb-8 text-on-surface">The 7-Year Journey of <span
                            class="text-tertiary">Impact</span></h2>
                    <div class="space-y-6 text-on-surface-variant text-lg leading-relaxed">
                        <p>With a vision to redefine the startup ecosystem in India, Dr. Anshumaan Singh has dedicated
                            nearly a decade to architecting success for students and entrepreneurs alike.</p>
                        <p>As the Chairman of IBSEA, he bridges the gap between academic theory and real-world
                            industrial demand, fostering a culture of innovation that aligns with the <span
                                class="font-bold text-on-surface">India@2047</span> vision.</p>
                        <div class="pt-4">
                            <div class="flex items-center gap-4 mb-4">
                                <span class="material-symbols-outlined text-secondary"
                                    style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <span>National record for most workshops in a single calendar year</span>
                            </div>
                            <div class="flex items-center gap-4 mb-4">
                                <span class="material-symbols-outlined text-secondary"
                                    style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <span>Architect of 50+ MoUs between global institutions</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services Section (Modern Cards) -->
        <section class="py-24 px-8 bg-white" id="services">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                    <div class="max-w-2xl">
                        <h2 class="text-4xl font-headline font-bold mb-4">Expertise That <span
                                class="text-primary">Scales</span></h2>
                        <p class="text-on-surface-variant text-lg">Specialized programs designed to transform leaders
                            and build sustainable business models.</p>
                    </div>
                    <a class="text-primary font-bold flex items-center gap-2 hover:translate-x-1 transition-transform"
                        href="#contact">
                        View All Services <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div
                        class="group bg-surface-container-lowest p-10 rounded-xl relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border border-slate-100">
                        <div
                            class="absolute top-0 left-0 w-1 h-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div class="w-16 h-16 bg-primary-container/20 rounded-lg flex items-center justify-center mb-8">
                            <span class="material-symbols-outlined text-primary text-3xl">rocket_launch</span>
                        </div>
                        <h3 class="text-2xl font-headline font-bold mb-4">Startup Mentorship</h3>
                        <p class="text-on-surface-variant leading-relaxed mb-4">Strategic guidance from ideation to series
                            funding. Focused on building lean, resilient, and scalable ventures.</p>
                        <ul class="text-sm space-y-2 text-on-surface text-opacity-80">
                            <li><span class="text-primary font-bold mr-1">→</span> Idea validation</li>
                            <li><span class="text-primary font-bold mr-1">→</span> Market entry strategies</li>
                            <li><span class="text-primary font-bold mr-1">→</span> Fundraising frameworks</li>
                        </ul>
                    </div>
                    <!-- Card 2 -->
                    <div
                        class="group bg-surface-container-lowest p-10 rounded-xl relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border border-slate-100">
                        <div
                            class="absolute top-0 left-0 w-1 h-full bg-secondary opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div
                            class="w-16 h-16 bg-secondary-container/20 rounded-lg flex items-center justify-center mb-8">
                            <span class="material-symbols-outlined text-secondary text-3xl">leaderboard</span>
                        </div>
                        <h3 class="text-2xl font-headline font-bold mb-4">Executive Coaching</h3>
                        <p class="text-on-surface-variant leading-relaxed mb-4">High-performance training for CXOs and
                            founders to master decision-making and organizational culture.</p>
                        <ul class="text-sm space-y-2 text-on-surface text-opacity-80">
                            <li><span class="text-secondary font-bold mr-1">→</span> Strategic clarity</li>
                            <li><span class="text-secondary font-bold mr-1">→</span> Leadership development</li>
                            <li><span class="text-secondary font-bold mr-1">→</span> Breaking leadership stagnation</li>
                        </ul>
                    </div>
                    <!-- Card 3 -->
                    <div
                        class="group bg-surface-container-lowest p-10 rounded-xl relative overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border border-slate-100">
                        <div
                            class="absolute top-0 left-0 w-1 h-full bg-tertiary opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div
                            class="w-16 h-16 bg-tertiary-container/20 rounded-lg flex items-center justify-center mb-8">
                            <span class="material-symbols-outlined text-tertiary text-3xl">star</span>
                        </div>
                        <h3 class="text-2xl font-headline font-bold mb-4">Brand Building</h3>
                        <p class="text-on-surface-variant leading-relaxed mb-4">Personal and corporate image transformation
                            to establish global authority and market dominance.</p>
                        <ul class="text-sm space-y-2 text-on-surface text-opacity-80">
                            <li><span class="text-tertiary font-bold mr-1">→</span> Public figure positioning</li>
                            <li><span class="text-tertiary font-bold mr-1">→</span> Authentic brand storytelling</li>
                            <li><span class="text-tertiary font-bold mr-1">→</span> Visibility enhancement</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- Impact Section -->
        <section class="py-24 px-8 bg-surface-container-low" id="impact">
            <div class="max-w-7xl mx-auto text-center mb-20">
                <h2 class="text-4xl font-headline font-bold mb-4">A National <span
                        class="text-secondary">Footprint</span></h2>
                <p class="text-on-surface-variant text-lg">Building the backbone of a developed India through strategic
                    partnerships.</p>
            </div>
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="bg-white p-12 rounded-2xl shadow-sm flex flex-col items-center text-center">
                    <span class="text-6xl font-headline font-extrabold text-tertiary mb-4">100+</span>
                    <p class="font-headline font-bold text-on-surface tracking-wide uppercase">Expert Mentors</p>
                    <p class="text-on-surface-variant mt-2 text-sm">Industry leaders across 20+ sectors</p>
                </div>
                <div class="bg-white p-12 rounded-2xl shadow-sm flex flex-col items-center text-center">
                    <span class="text-6xl font-headline font-extrabold text-tertiary mb-4">1000+</span>
                    <p class="font-headline font-bold text-on-surface tracking-wide uppercase">Active Members</p>
                    <p class="text-on-surface-variant mt-2 text-sm">Innovators driving the startup economy</p>
                </div>
                <div class="bg-white p-12 rounded-2xl shadow-sm flex flex-col items-center text-center">
                    <span class="text-6xl font-headline font-extrabold text-tertiary mb-4">50+</span>
                    <p class="font-headline font-bold text-on-surface tracking-wide uppercase">Institutional MOUs</p>
                    <p class="text-on-surface-variant mt-2 text-sm">Global bridges for student exchange</p>
                </div>
            </div>
        </section>
        <!-- Mission Section -->
        <section class="py-24 px-8 bg-white relative">
            <div
                class="mx-auto bg-slate-900 rounded-[2rem] p-12 lg:p-20 text-white flex flex-col align-center justify-center text-center lg:flex-row gap-16 overflow-hidden">
                <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary/20 to-transparent"></div>
                <div class="lg:w-3/5 relative z-10">
                    <h2 class="text-4xl lg:text-5xl font-headline font-extrabold mb-8 leading-tight">
                        Transforming Youth Potential into <span
                            class="text-primary-container underline decoration-primary-container/30 decoration-8 underline-offset-8">Performance</span>
                    </h2>
                    <p class="text-slate-300 text-xl leading-relaxed mb-10 italic">
                        "Our goal is to establish 100 Centers of Excellence across India by 2030, ensuring that every
                        Tier-2 and Tier-3 city becomes a hub of entrepreneurial excellence."
                    </p>
        
                    <div class="bg-surface-container-lowest p-1 rounded-lg shadow-sm mt-8">
                            <img alt="Leadership Speech" class="rounded-lg object-cover h-30 w-full"
                                data-alt="Dr. Singh delivering a keynote speech at a summit"
                                src="{{ asset('image/6990427a9c3d0.webp') }}" />
                        </div>
                </div>
                
            </div>
        </section>
        <!-- Media & Speaking -->
        <section class="py-24 px-8 bg-surface" id="media">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center gap-4 mb-16">
                    <div class="h-1 w-12 bg-primary"></div>
                    <h2 class="text-4xl font-headline font-bold">Media &amp; Global Speaking</h2>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="space-y-8">
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                            <div class="flex items-start gap-6">
                                <div class="bg-red-50 text-red-600 p-4 rounded-lg">
                                    <span class="material-symbols-outlined text-4xl">mic</span>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-headline font-bold mb-2">TEDx Speaker</h3>
                                    <p class="text-on-surface-variant">Sharing insights on the "Future of
                                        Entrepreneurship" to a global audience of millions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="block aspect-video bg-slate-200 rounded-2xl overflow-hidden shadow-lg border border-slate-100">
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/JiTi11TnVKs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="space-y-8">
                        <div class="block aspect-video bg-slate-200 rounded-2xl overflow-hidden shadow-lg border border-slate-100">
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/DOWksCIv8FY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                            <div class="flex items-start gap-6">
                                <div class="bg-blue-50 text-tertiary p-4 rounded-lg">
                                    <span class="material-symbols-outlined text-4xl">newspaper</span>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-headline font-bold mb-2">Industrial Recognition</h3>
                                    <p class="text-on-surface-variant">Featured in leading publications for pioneering
                                        work in startup mentoring and policy advocacy.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Awards Grid -->
        <section class="py-24 px-8 bg-white" id="awards">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-headline font-bold mb-4">Honors &amp; Accolades</h2>
                    <p class="text-on-surface-variant">Recognized at the highest levels for excellence in education and
                        mentorship.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        class="bg-surface-container-low p-8 rounded-xl text-center border-b-4 border-primary group hover:bg-white hover:shadow-xl transition-all">
                        <span class="material-symbols-outlined text-primary text-5xl mb-6">workspace_premium</span>
                        <h4 class="font-headline font-bold text-lg mb-2">Uttar Pradesh Ratna</h4>
                        <p class="text-xs text-on-surface-variant uppercase tracking-widest">State Recognition</p>
                    </div>
                    <div
                        class="bg-surface-container-low p-8 rounded-xl text-center border-b-4 border-secondary group hover:bg-white hover:shadow-xl transition-all">
                        <span class="material-symbols-outlined text-secondary text-5xl mb-6">school</span>
                        <h4 class="font-headline font-bold text-lg mb-2">Shiksha Ratna</h4>
                        <p class="text-xs text-on-surface-variant uppercase tracking-widest">Academic Excellence</p>
                    </div>
                    <div
                        class="bg-surface-container-low p-8 rounded-xl text-center border-b-4 border-tertiary group hover:bg-white hover:shadow-xl transition-all">
                        <span class="material-symbols-outlined text-tertiary text-5xl mb-6">military_tech</span>
                        <h4 class="font-headline font-bold text-lg mb-2">Leadership Excellence</h4>
                        <p class="text-xs text-on-surface-variant uppercase tracking-widest">Global Summit</p>
                    </div>
                    <div
                        class="bg-surface-container-low p-8 rounded-xl text-center border-b-4 border-orange-400 group hover:bg-white hover:shadow-xl transition-all">
                        <span class="material-symbols-outlined text-orange-400 text-5xl mb-6">public</span>
                        <h4 class="font-headline font-bold text-lg mb-2">Global Impact Award</h4>
                        <p class="text-xs text-on-surface-variant uppercase tracking-widest">International Forum</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Collaboration Section -->
        <section class="py-24 px-8 bg-slate-900 text-white">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-20">
                <div class="lg:w-1/3">
                    <h2 class="text-4xl font-headline font-bold mb-6">Strategic Partnerships</h2>
                    <p class="text-slate-400 leading-relaxed">Collaborating with the visionaries of today to build the
                        industries of tomorrow.</p>
                </div>
                <div class="lg:w-2/3 grid grid-cols-2 gap-8">
                    <div class="border-l-2 border-primary/30 pl-8 py-4">
                        <h4 class="text-xl font-headline font-bold mb-2">Startup Founders</h4>
                        <p class="text-slate-500 text-sm">Equity-based mentorship and strategic scaling models.</p>
                    </div>
                    <div class="border-l-2 border-secondary/30 pl-8 py-4">
                        <h4 class="text-xl font-headline font-bold mb-2">Government Leaders</h4>
                        <p class="text-slate-500 text-sm">Policy framework and socio-economic growth consulting.</p>
                    </div>
                    <div class="border-l-2 border-tertiary/30 pl-8 py-4">
                        <h4 class="text-xl font-headline font-bold mb-2">CXOs &amp; Executives</h4>
                        <p class="text-slate-500 text-sm">Transformational leadership and cultural architecture.</p>
                    </div>
                    <div class="border-l-2 border-orange-300/30 pl-8 py-4">
                        <h4 class="text-xl font-headline font-bold mb-2">Incubators</h4>
                        <p class="text-slate-500 text-sm">Structuring sustainable acceleration programs.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact Section -->
        <section class="py-24 px-8 bg-surface" id="contact">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row">
                    <div class="lg:w-1/2 p-12 lg:p-20">
                        <h2 class="text-4xl font-headline font-bold mb-8">Let's Build the <span
                                class="text-primary">Future</span></h2>
                        <form class="space-y-6" action="mailto:contact@anshumaansingh.com" method="post" enctype="text/plain">
                            <div>
                                <label
                                    class="block text-sm font-bold uppercase tracking-widest text-on-surface-variant mb-2">Name</label>
                                <input
                                    class="w-full bg-surface-container-low border-none border-b-2 border-outline focus:ring-0 focus:border-primary transition-all p-4"
                                    placeholder="John Doe" type="text" />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-bold uppercase tracking-widest text-on-surface-variant mb-2">Email</label>
                                <input
                                    class="w-full bg-surface-container-low border-none border-b-2 border-outline focus:ring-0 focus:border-primary transition-all p-4"
                                    placeholder="john@example.com" type="email" />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-bold uppercase tracking-widest text-on-surface-variant mb-2">Message</label>
                                <textarea
                                    class="w-full bg-surface-container-low border-none border-b-2 border-outline focus:ring-0 focus:border-primary transition-all p-4"
                                    placeholder="How can I help you?" rows="4"></textarea>
                            </div>
                            <button
                                class="w-full bg-primary text-white font-bold py-5 rounded-md hover:bg-on-primary-container transition-colors text-lg cursor-pointer">Send
                                Message</button>
                        </form>
                    </div>
                    <div class="lg:w-1/2 bg-tertiary p-12 lg:p-20 text-white flex flex-col justify-between">
                        <div>
                            <h3 class="text-3xl font-headline font-bold mb-10">Direct Reach</h3>
                            <div class="space-y-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center border border-white/20">
                                        <span class="material-symbols-outlined">mail</span>
                                    </div>
                                    <div>
                                        <p class="text-white/60 text-sm uppercase font-bold">Email Me</p>
                                        <p class="text-lg">contact@anshumaansingh.com</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center border border-white/20">
                                        <span class="material-symbols-outlined">public</span>
                                    </div>
                                    <div>
                                        <p class="text-white/60 text-sm uppercase font-bold">Website</p>
                                        <p class="text-lg">www.anshumaansingh.com</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center border border-white/20">
                                        <span class="material-symbols-outlined">map</span>
                                    </div>
                                    <div>
                                        <p class="text-white/60 text-sm uppercase font-bold">Headquarters</p>
                                        <p class="text-lg">1/22/Asaf Ali Road, New Delhi, India</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-20">
                            <p class="text-white/60 font-bold mb-6 tracking-widest text-sm">SOCIAL CONNECT</p>
                            <div class="flex gap-6">
                                <a class="w-14 h-14 bg-white/10 rounded-xl flex items-center justify-center hover:bg-primary transition-all group"
                                    href="https://www.linkedin.com/in/anshumaansinghofficial" target="_blank">
                                    <span class="text-white font-bold group-hover:scale-110 transition-transform">In</span>
                                </a>
                                <a class="w-14 h-14 bg-white/10 rounded-xl flex items-center justify-center hover:bg-primary transition-all group"
                                    href="https://www.facebook.com/share/15TKHLN6fJ/" target="_blank">
                                    <span class="text-white font-bold group-hover:scale-110 transition-transform">Fb</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    @include('partials.footer')
</body>

</html>
