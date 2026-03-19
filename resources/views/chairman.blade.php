<!DOCTYPE html>

<html class="scroll-smooth" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Dr. Anshumaan Singh | Startup Mentor &amp; Leadership Coach</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@300;400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
    <nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl shadow-sm">
        <div class="flex justify-between items-center px-8 py-4 max-w-7xl mx-auto">
            <div class="text-xl font-extrabold text-slate-900 font-headline tracking-tight">
                Dr. Anshumaan Singh
            </div>
            <div class="hidden md:flex gap-8 items-center">
                <a class="text-orange-600 border-b-2 border-orange-500 pb-1 font-headline font-bold" href="#home">Home</a>
                <a class="text-slate-600 hover:text-slate-900 transition-colors font-headline font-bold" href="#about">About</a>
                <a class="text-slate-600 hover:text-slate-900 transition-colors font-headline font-bold" href="#services">Services</a>
                <a class="text-slate-600 hover:text-slate-900 transition-colors font-headline font-bold" href="#impact">Impact</a>
                <a class="text-slate-600 hover:text-slate-900 transition-colors font-headline font-bold" href="#media">Media</a>
                <a class="text-slate-600 hover:text-slate-900 transition-colors font-headline font-bold" href="#contact">Contact</a>
                <a href="{{ url('/') }}" class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-6 py-2.5 rounded-md font-bold hover:scale-105 transition-transform duration-300">
                    Back to IBSEA
                </a>
            </div>
            <div class="md:hidden">
                <span class="material-symbols-outlined text-on-surface">menu</span>
            </div>
        </div>
        <div class="bg-gradient-to-r from-orange-500/10 to-transparent h-[1px] w-full absolute bottom-0"></div>
    </nav>
    <main>
        <!-- Hero Section -->
        <section class="relative pt-32 pb-24 px-8 overflow-hidden bg-white" id="home">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 z-10">
                    <span class="text-secondary font-headline font-bold tracking-widest uppercase text-sm mb-4 block">Chairman IBSEA &amp; Startup Mentor</span>
                    <h1 class="text-5xl lg:text-7xl font-headline font-extrabold text-on-surface leading-[1.1] tracking-tight mb-8">
                        Dr. Anshumaan Singh
                    </h1>
                    <p class="text-xl text-on-surface-variant max-w-xl mb-10 leading-relaxed font-bold">
                        Transforming Visions Into Ventures
                    </p>
                    <p class="text-lg text-on-surface-variant max-w-xl mb-10 leading-relaxed italic border-l-4 border-primary pl-4">
                        “You don’t need more motivation — you need mentorship that works.”
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#contact" class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-8 py-4 rounded-md font-bold text-lg shadow-xl shadow-primary/20 hover:translate-y-[-2px] transition-all">
                            Book a Consultation
                        </a>
                        <a href="#services" class="border border-outline-variant text-on-surface px-8 py-4 rounded-md font-bold text-lg hover:bg-surface-container-low transition-all">
                            Explore Services
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-5 relative">
                    <div class="absolute -top-12 -left-12 w-64 h-64 bg-primary-container/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-12 -right-12 w-64 h-64 bg-secondary-container/10 rounded-full blur-3xl"></div>
                    <div class="relative bg-surface-container rounded-xl overflow-hidden aspect-[4/5] shadow-2xl border flex items-center justify-center">
                        <img alt="Dr. Anshumaan Singh Professional Portrait" class="w-full h-full object-cover" src="{{ asset('image/chairman.jpg') }}" onerror="this.src='https://lh3.googleusercontent.com/aida-public/AB6AXuBtOfg6TyqMFM6a47h8JDMG28MpoIOFym6i_tKNa6UHkp23LPQwNOKYvQWxLZc4KAPkA7E5z1T1khqWhFGauNq0-mDRJIqV0n8OOtYv17LQT9Wc9NeCAl0ZCSsIpabRfHDxDQVIDgiAtNjN4RxqikDxSSdYKk_yVOl3pxhPIhZbmBeUuJjHiAvGNcZj3u3aBCgcj0FAyz1T8Zc3Du14q6rFhmg0zvCb7KWVA9GQMTTUbyZfpzgxibx99Y8CbuYvNtXO4LNk_mSdFIA'" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Dynamic Content from Markdown -->
        <section class="py-24 px-8 bg-surface" id="about">
            <div class="max-w-4xl mx-auto prose prose-lg md:prose-xl text-on-surface-variant font-body">
                <h2 class="text-4xl font-headline font-bold mb-8 text-on-surface">🚀 Overview</h2>
                <p class="mb-4">Dr. Anshumaan Singh is one of India’s most recognized figures in startup mentorship, strategic growth consulting, and leadership development. As the Chairman of the International Business Startup and Entrepreneurs Association (IBSEA), he has dedicated his career to empowering individuals, startups, and institutions to achieve measurable growth and long-term impact.</p>
                <hr class="my-10 border-outline-variant">

                <h2 class="text-3xl font-headline font-bold mb-6 text-on-surface">🎯 Professional Identity</h2>
                <p class="mb-4">Dr. Singh works at the intersection of entrepreneurship, leadership, and nation-building. His mission is to transform ideas into scalable ventures while developing future-ready leaders who can contribute to India’s growth.</p>
                <hr class="my-10 border-outline-variant">

                <h2 class="text-3xl font-headline font-bold mb-6 text-on-surface">📊 Key Achievements</h2>
                <ul class="list-disc pl-6 space-y-2 mb-8">
                    <li>Mentored <strong>2.5 lakh+ students</strong> across India</li>
                    <li>Conducting <strong>10,000+ professional meetings</strong> in the past 5 years</li>
                    <li>Invited as Guest Speaker by <strong>185+ colleges and universities</strong></li>
                    <li>Recipient of <strong>180+ national and international awards</strong> including <em>Uttar Pradesh Ratna</em> and <em>Shiksha Ratna</em></li>
                    <li>Recognized <strong>TEDx Speaker</strong> for thought leadership in entrepreneurship</li>
                </ul>
                <hr class="my-10 border-outline-variant">

                <h2 class="text-3xl font-headline font-bold mb-6 text-on-surface">👥 Who He Works With</h2>
                <ul class="list-disc pl-6 space-y-2 mb-8">
                    <li><strong>Startup Founders</strong> looking to scale with clarity and speed</li>
                    <li><strong>CXOs & Chairpersons</strong> seeking strategic growth and alignment</li>
                    <li><strong>Government & Policy Leaders</strong> building innovation-driven ecosystems</li>
                    <li><strong>Business Incubators & Accelerators</strong> focused on mentorship-led outcomes</li>
                </ul>
                <hr class="my-10 border-outline-variant">

                <h2 class="text-4xl font-headline font-bold mb-8 text-on-surface" id="services">🔧 Services & Expertise</h2>
                
                <h3 class="text-2xl font-headline font-bold mb-4 text-primary">🎯 Startup & Business Mentorship</h3>
                <p class="mb-2">Provides end-to-end guidance for entrepreneurs:</p>
                <ul class="list-disc pl-6 space-y-2 mb-8">
                    <li>Idea validation</li>
                    <li>Market entry strategies</li>
                    <li>Fundraising frameworks</li>
                    <li>Customer acquisition</li>
                    <li>Scaling and execution</li>
                </ul>

                <h3 class="text-2xl font-headline font-bold mb-4 text-primary">🎯 Executive Coaching</h3>
                <p class="mb-2">Helps leaders align purpose with performance:</p>
                <ul class="list-disc pl-6 space-y-2 mb-8">
                    <li>Strategic clarity</li>
                    <li>Leadership development</li>
                    <li>Decision-making frameworks</li>
                    <li>Breaking leadership stagnation</li>
                </ul>

                <h3 class="text-2xl font-headline font-bold mb-4 text-primary">🎯 Brand & Image Building</h3>
                <p class="mb-2">Builds strong personal and professional brands:</p>
                <ul class="list-disc pl-6 space-y-2 mb-8">
                    <li>Positioning for CEOs, influencers, and public figures</li>
                    <li>Authentic brand storytelling</li>
                    <li>Reputation and visibility enhancement</li>
                </ul>
                <hr class="my-10 border-outline-variant">

                <h2 class="text-3xl font-headline font-bold mb-6 text-on-surface" id="impact">🌐 Nation Building Through Entrepreneurship</h2>
                <p class="mb-4">Dr. Singh plays a significant role in shaping India’s entrepreneurial ecosystem.</p>
                <p class="mb-2 font-bold">Key Initiatives:</p>
                <ul class="list-disc pl-6 space-y-2 mb-4">
                    <li>Organizer of <strong>India@2047 Conference</strong></li>
                    <li>Organizer of <strong>Bharat Ke Maharathi Awards</strong></li>
                </ul>
                <p class="mb-2 font-bold mt-6">IBSEA Impact:</p>
                <ul class="list-disc pl-6 space-y-2 mb-8">
                    <li><strong>100+ Mentors onboarded</strong></li>
                    <li><strong>1,000+ Booster Members</strong></li>
                    <li><strong>50+ MOUs signed</strong></li>
                    <li><strong>21 Councils established</strong> to build 21st-century business skills</li>
                    <li>Leadership structure including <strong>10 State Presidents/Vice Presidents</strong></li>
                </ul>

                <h2 class="text-3xl font-headline font-bold mb-6 text-on-surface">🎯 Mission & Vision</h2>
                <div class="bg-primary/5 p-8 rounded-xl border border-primary/20 mb-8">
                    <p class="mb-4"><strong>Core Mission:</strong><br>To transform youth potential into measurable performance through structured mentorship, entrepreneurial mindset development, and leadership training.</p>
                    <p><strong>Vision:</strong><br>To establish 100 Centers of Excellence across India, enabling skill-based learning, innovation-driven thinking, and scalable entrepreneurship ecosystems.</p>
                </div>
                <hr class="my-10 border-outline-variant">

                <h2 class="text-3xl font-headline font-bold mb-6 text-on-surface" id="media">🎤 Media & Videos</h2>
                <ul class="list-disc pl-6 space-y-2 mb-4">
                    <li>Renowned <strong>TEDx Speaker</strong> delivering sessions across top institutions</li>
                    <li>Known for impactful talks on Entrepreneurship, Leadership, Nation-building, and Youth empowerment</li>
                </ul>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <a href="https://youtu.be/JiTi11TnVKs" target="_blank" class="block aspect-video bg-slate-200 rounded-2xl overflow-hidden relative group">
                        <div class="absolute inset-0 bg-slate-900/40 group-hover:bg-slate-900/20 transition-all flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-7xl opacity-80 group-hover:scale-110 transition-transform">play_circle</span>
                        </div>
                        <img alt="Video" class="w-full h-full object-cover" src="https://img.youtube.com/vi/JiTi11TnVKs/maxresdefault.jpg" />
                    </a>
                    <a href="https://youtu.be/DOWksCIv8FY" target="_blank" class="block aspect-video bg-slate-200 rounded-2xl overflow-hidden relative group">
                        <div class="absolute inset-0 bg-slate-900/40 group-hover:bg-slate-900/20 transition-all flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-7xl opacity-80 group-hover:scale-110 transition-transform">play_circle</span>
                        </div>
                        <img alt="Video" class="w-full h-full object-cover" src="https://img.youtube.com/vi/DOWksCIv8FY/maxresdefault.jpg" />
                    </a>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="py-24 px-8 bg-surface-container-low" id="contact">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row">
                    <div class="lg:w-1/2 p-12 lg:p-20">
                        <h2 class="text-4xl font-headline font-bold mb-8">Let's Build the <span class="text-primary">Future</span></h2>
                        <h3 class="text-xl font-bold text-on-surface mb-4">🤝 Collaboration Invitation</h3>
                        <p class="mb-4 text-on-surface-variant">Dr. Anshumaan Singh invites collaboration with individuals and organizations ready to launch stronger, scale faster, and lead better.</p>
                        <ul class="mb-8 text-on-surface-variant list-disc pl-6">
                            <li>Sustainable systems</li>
                            <li>Strategic growth frameworks</li>
                            <li>Long-term impact</li>
                        </ul>
                    </div>
                    <div class="lg:w-1/2 bg-tertiary p-12 lg:p-20 text-white flex flex-col justify-between">
                        <div>
                            <h3 class="text-3xl font-headline font-bold mb-10">Direct Reach</h3>
                            <div class="space-y-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                                        <span class="material-symbols-outlined">mail</span>
                                    </div>
                                    <div>
                                        <p class="text-white/60 text-sm uppercase font-bold">Email</p>
                                        <p class="text-lg">contact@anshumaansingh.com</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                                        <span class="material-symbols-outlined">public</span>
                                    </div>
                                    <div>
                                        <p class="text-white/60 text-sm uppercase font-bold">Website</p>
                                        <p class="text-lg">www.anshumaansingh.com</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                                        <span class="material-symbols-outlined">map</span>
                                    </div>
                                    <div>
                                        <p class="text-white/60 text-sm uppercase font-bold">Location</p>
                                        <p class="text-lg">Delhi, India</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-20">
                            <p class="text-white/60 font-bold mb-6">SOCIAL CONNECT</p>
                            <div class="flex gap-6">
                                <a class="w-14 h-14 bg-white/10 rounded-xl flex items-center justify-center hover:bg-primary transition-all group" href="https://www.linkedin.com/in/anshumaansinghofficial" target="_blank">
                                    <span class="text-white text-sm font-bold">In</span>
                                </a>
                                <a class="w-14 h-14 bg-white/10 rounded-xl flex items-center justify-center hover:bg-primary transition-all group" href="https://www.facebook.com/share/15TKHLN6fJ/" target="_blank">
                                    <span class="text-white text-sm font-bold">Fb</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="bg-slate-900 dark:bg-black w-full py-12 px-8 mt-24 border-t border-slate-800">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 max-w-7xl mx-auto">
            <div class="md:col-span-1">
                <div class="text-lg font-bold text-white uppercase tracking-widest mb-6">Dr. Anshumaan Singh</div>
                <p class="text-slate-400 text-sm leading-relaxed mb-6 font-body">Architecting the future of Indian entrepreneurship. Building leaders, scaling ventures, creating impact.</p>
            </div>
            <div>
                <h4 class="text-white font-medium mb-6">Quick Links</h4>
                <ul class="space-y-4">
                    <li><a class="text-slate-500 hover:text-orange-400 transition-colors hover:translate-x-1 duration-300 block" href="https://www.linkedin.com/in/anshumaansinghofficial" target="_blank">LinkedIn</a></li>
                    <li><a class="text-slate-500 hover:text-orange-400 transition-colors hover:translate-x-1 duration-300 block" href="https://www.facebook.com/share/15TKHLN6fJ/" target="_blank">Facebook</a></li>
                    <li><a class="text-slate-500 hover:text-orange-400 transition-colors hover:translate-x-1 duration-300 block" href="#contact">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-medium mb-6">Initiatives</h4>
                <ul class="space-y-4">
                    <li><a class="text-slate-500 hover:text-orange-400 transition-colors block" href="{{ url('/') }}">IBSEA India</a></li>
                    <li><a class="text-slate-500 hover:text-orange-400 transition-colors block" href="#services">Startup Mentorship</a></li>
                    <li><a class="text-slate-500 hover:text-orange-400 transition-colors block" href="#impact">Leadership Summit</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-16 pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="font-bold text-sm text-slate-400">© 2026 Dr. Anshumaan Singh. India@2047</p>
            <div class="flex gap-8">
                <span class="text-orange-500 font-bold text-xs tracking-widest uppercase">Leadership</span>
                <span class="text-orange-500 font-bold text-xs tracking-widest uppercase">Innovation</span>
                <span class="text-orange-500 font-bold text-xs tracking-widest uppercase">Nation Building</span>
            </div>
        </div>
    </footer>
</body>
</html>
