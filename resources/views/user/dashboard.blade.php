@extends('layouts.app')

@push('styles')
<style>
    .text-gold { color: #D4AF37; }
    .bg-gold { background-color: #D4AF37; }
    .border-gold { border-color: #D4AF37; }
    .text-orange-corp { color: #f58220; }
    .bg-orange-corp { background-color: #f58220; }
    .primary-blue { color: #0f49bd; }
    .bg-primary-blue { background-color: #0f49bd; }
</style>
@endpush

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <!-- Main Dashboard Area -->
    <main class="flex-1 overflow-y-auto p-4 md:p-12">
        <!-- Personalized Welcome -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold text-navy-accent dark:text-white tracking-tight leading-none mb-2">Welcome, {{ explode(' ', $user->name)[0] }}!</h2>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">{{ $user->membership_id }}</span>
                    @if($user->leadership_email)
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <a href="mailto:{{ $user->leadership_email }}" class="text-[10px] font-black text-orange-500 lowercase tracking-widest font-mono hover:underline">{{ $user->leadership_email }}</a>
                    @endif
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $strategicRank }}</span>
                </div>
                <p class="text-sm text-slate-500 font-medium">{{ $isRestricted ? 'Start your business journey with IBSEA.' : 'Your mission intelligence for today.' }}</p>
            </div>

            @if(!$user->profile_completed && !$isRestricted)
                <div class="bg-primary/5 border border-primary/10 p-4 rounded-3xl flex items-center gap-4 animate-pulse">
                    <div class="w-10 h-10 bg-primary rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-primary/20">
                        <span class="material-icons text-sm">priority_high</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-primary">Portfolio Incomplete</p>
                        <p class="text-xs text-slate-500 font-bold uppercase mt-0.5">Unlock the Directory</p>
                    </div>
                    <a href="{{ route('user.onboarding') }}" class="bg-primary text-white text-[10px] font-bold hover:bg-orange-600 px-4 py-2 rounded-xl uppercase tracking-widest transition-all">Fix Now</a>
                </div>
            @endif

            @if(!$user->chapter_id && !$isRestricted)
                <div class="bg-orange-500/5 border border-orange-500/10 p-4 rounded-3xl flex items-center gap-4">
                    <div class="w-10 h-10 bg-orange-500 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-orange-500/20">
                        <span class="material-icons text-sm">location_on</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-orange-500 uppercase tracking-widest mb-0.5">Chapter Info</h4>
                        <p class="text-xs text-slate-500 font-bold uppercase mt-0.5">Selection Required</p>
                    </div>
                    <a href="{{ route('user.onboarding') }}" class="bg-orange-500 text-white text-[10px] font-bold hover:bg-orange-600 px-4 py-2 rounded-xl uppercase tracking-widest transition-all">Select Now</a>
                </div>
            @endif
        </div>

        @if($isRestricted)
            <!-- Restricted / Guest UI (Matching Legacy Exactly) -->
            <div class="bg-slate-900 rounded-[3rem] p-10 md:p-16 relative overflow-hidden shadow-2xl mb-12">
                <div class="relative z-10 flex flex-col lg:flex-row items-center gap-12">
                    <div class="flex-1 space-y-8 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 px-5 py-2.5 rounded-full">
                            <span class="w-2 h-2 bg-gold rounded-full animate-ping"></span>
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gold">Elite Access Pending</span>
                        </div>
                        <h3 class="text-4xl md:text-6xl font-black text-white leading-[1.1] tracking-tighter italic">Become an IBSEA Member For More Benefits</h3>
                        <p class="text-slate-400 text-lg md:text-xl font-medium max-w-2xl leading-relaxed">Join the alliance to unlock Professional Portfolios, Strategic Councils, and Chapter Leadership assignments.</p>
                        
                        <div class="flex flex-wrap gap-4 pt-6 justify-center lg:justify-start">
                            <a href="{{ route('membership') }}?plan=booster" class="bg-primary hover:bg-orange-600 text-white font-black px-12 py-6 rounded-3xl transition-all flex items-center gap-3 text-lg uppercase tracking-widest shadow-2xl shadow-primary/20 group">
                                Join IBSEA
                                <span class="material-icons group-hover:translate-x-1 transition-transform">bolt</span>
                            </a>
                            <a href="{{ route('membership') }}" class="bg-white/5 hover:bg-white/10 text-white border border-white/10 font-bold px-10 py-6 rounded-3xl transition-all uppercase tracking-widest text-sm">
                                All Tiers
                            </a>
                        </div>
                    </div>

                    <div class="shrink-0 w-full lg:w-96 hidden md:block">
                        <div class="bg-white/5 p-8 rounded-[2.5rem] border border-white/10 backdrop-blur-xl space-y-8">
                            <div>
                                <p class="text-[10px] font-black text-gold uppercase tracking-[0.3em] mb-4">Recommended Strategy</p>
                                <h4 class="text-3xl font-black text-white italic">BOOSTER PLAN</h4>
                                <div class="flex items-end gap-1 mt-2">
                                    <p class="text-4xl font-black text-white">₹{{ number_format($boosterPlan->price ?? 1999) }}</p>
                                    <p class="text-sm font-bold text-slate-500 mb-1 uppercase tracking-widest">/ Year</p>
                                </div>
                            </div>
                            
                            <ul class="space-y-4">
                                @foreach(['Business Training (50hrs)', 'Digital Identity Cert', 'Global Network Access'] as $benefit)
                                    <li class="flex items-center gap-3 text-slate-300 font-bold text-sm uppercase tracking-tighter">
                                        <span class="material-icons text-primary text-xl">verified</span>
                                        {{ $benefit }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Abstract Decor -->
                <div class="absolute -right-32 -top-32 opacity-10">
                    <span class="material-icons text-[400px]">hub</span>
                </div>
                <div class="absolute -left-20 -bottom-20 opacity-5">
                    <span class="material-icons text-[250px]">language</span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-white dark:bg-slate-900 p-10 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-xl space-y-6 group hover:border-primary transition-all">
                            <div class="w-20 h-20 bg-primary/10 rounded-[2.5rem] flex items-center justify-center text-primary transition-transform group-hover:scale-90">
                                <span class="material-icons text-4xl">public</span>
                            </div>
                            <div>
                                <h4 class="text-2xl font-black text-slate-800 dark:text-white italic tracking-tighter mb-2">Global Directory</h4>
                                <p class="text-slate-500 font-medium italic leading-relaxed">Your business listed in our high-authority directory for global strategic sourcing.</p>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-slate-900 p-10 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-xl space-y-6 group hover:border-blue-500 transition-all">
                            <div class="w-20 h-20 bg-blue-500/10 rounded-[2.5rem] flex items-center justify-center text-blue-500 transition-transform group-hover:scale-90">
                                <span class="material-icons text-4xl">handshake</span>
                            </div>
                            <div>
                                <h4 class="text-2xl font-black text-slate-800 dark:text-white italic tracking-tighter mb-2">21 Councils</h4>
                                <p class="text-slate-500 font-medium italic leading-relaxed">Join specialized cells to influence policy and drive sectoral business trends.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-primary/5 dark:bg-white/5 p-10 rounded-[3rem] border border-primary/10 flex flex-col md:flex-row items-center gap-8">
                        <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center text-white text-2xl animate-bounce shadow-xl shadow-primary/20 shrink-0">🏆</div>
                        <div class="flex-1 text-center md:text-left">
                            <h4 class="text-xl font-bold text-navy-accent dark:text-white italic tracking-tighter">Leadership Appointments</h4>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mt-1">Founding members are eligible for Chapter President and Alliance Head roles.</p>
                        </div>
                        <a href="{{ route('leadership') }}" class="text-[10px] font-bold text-primary uppercase tracking-widest flex items-center gap-2 hover:gap-3 transition-all shrink-0">
                            Learn More <span class="material-icons text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <!-- Right Side: Events List (Restricted) -->
                <div class="space-y-8">
                    @include('user.dashboard_partials.events_list')
                </div>
            </div>
        @else
            <!-- Main Content Container -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Left Column (Intelligence & Leadership) -->
                <div class="lg:col-span-2 space-y-12">
                    <!-- Insight Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Plan Validity -->
                        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Plan Validity</h3>
                                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                                    <span class="material-icons text-sm">timer</span>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div class="flex items-end gap-2 leading-none">
                                    <p class="text-3xl font-bold text-navy-accent dark:text-white">{{ floor($daysRemaining) }}</p>
                                    <span class="text-sm text-gray-500 font-bold uppercase tracking-wider pb-1">Days Remaining</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-primary h-full rounded-full transition-all duration-1000" style="width:{{ $validityPercent }}%"></div>
                                </div>
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Expires {{ \Carbon\Carbon::parse($user->membership_end)->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Chapter Info -->
                        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Chapter Intelligence</h3>
                                    <div class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500">
                                        <span class="material-icons text-sm">location_on</span>
                                    </div>
                                </div>
                                <h4 class="text-2xl font-bold text-navy-accent dark:text-white italic uppercase tracking-tighter">{{ $user->chapter->name ?? 'National Office' }}</h4>
                                <p class="text-sm text-gray-500 font-bold uppercase tracking-wider mt-2">Regionally Verified Node</p>
                            </div>
                            <div class="mt-8 flex flex-col gap-4">
                                <a href="{{ route('leadership') }}" class="text-[10px] font-black text-primary uppercase tracking-widest flex items-center gap-2 hover:gap-3 transition-all">
                                    View Full Roster <span class="material-icons text-xs">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Leadership Hub -->
                    <div class="space-y-10">
                        <div class="flex items-center justify-between px-2">
                            <h3 class="text-xl font-bold text-navy-accent dark:text-white flex items-center gap-3">
                                <span class="material-icons text-primary">stars</span>
                                Chapter Leadership
                            </h3>
                            <a href="{{ route('leadership') }}" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline">All Leaders</a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- President Card -->
                            <div class="bg-white dark:bg-slate-900 p-4 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-md flex items-center gap-4 group hover:border-primary transition-all">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 shrink-0 overflow-hidden border border-primary/10 transition-transform group-hover:scale-95">
                                    @if($president?->profile_image)
                                        <img src="{{ asset($president->profile_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-primary text-xl font-black italic">
                                            {{ substr($president->name ?? 'P', 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <p class="text-[9px] font-black text-primary uppercase tracking-widest">Team Lead</p>
                                        <span class="text-green-500 material-icons text-[12px]">verified</span>
                                    </div>
                                    <h4 class="text-md font-bold text-navy-accent dark:text-white truncate italic tracking-tighter leading-tight">{{ $president->name ?? 'Appointment Pending' }}</h4>
                                    @if($president?->leadership_email)
                                        <a href="mailto:{{ $president->leadership_email }}" class="text-[9px] font-black text-primary font-mono lowercase tracking-tighter mb-1 hover:underline block truncate">{{ $president->leadership_email }}</a>
                                    @endif
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $president->role ?? 'State President' }}</p>
                                </div>
                            </div>

                            <!-- VP Card -->
                            <div class="bg-white dark:bg-slate-900 p-4 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-md flex items-center gap-4 group hover:border-primary transition-all">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 shrink-0 overflow-hidden border border-orange-500/10 transition-transform group-hover:scale-95">
                                    @if($vp?->profile_image)
                                        <img src="{{ asset($vp->profile_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-orange-500 text-xl font-black italic">
                                            {{ substr($vp->name ?? 'V', 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <p class="text-[9px] font-black text-orange-500 uppercase tracking-widest">Strategic VP</p>
                                    </div>
                                    <h4 class="text-md font-bold text-navy-accent dark:text-white truncate italic tracking-tighter leading-tight">{{ $vp->name ?? 'Appointment Pending' }}</h4>
                                    @if($vp?->leadership_email)
                                        <a href="mailto:{{ $vp->leadership_email }}" class="text-[9px] font-black text-orange-500 font-mono lowercase tracking-tighter mb-1 hover:underline block truncate">{{ $vp->leadership_email }}</a>
                                    @endif
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Vice President</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exclusive Member Banner -->
                    <div class="bg-gradient-to-br from-slate-900 to-slate-950 p-10 md:p-14 rounded-[3rem] relative overflow-hidden shadow-2xl">
                        <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                            <div class="flex-1 space-y-6">
                                <h4 class="text-3xl font-black text-white italic tracking-tighter leading-tight">Exclusive Hub For IBSEA Agents</h4>
                                <p class="text-slate-400 text-lg leading-relaxed">Access the upcoming Global Leadership Summit and connect with industry veterans in your sector.</p>
                                <a href="{{ route('events') }}" class="bg-white hover:bg-primary hover:text-white text-slate-900 font-black px-8 py-4 rounded-2xl transition-all inline-block uppercase tracking-widest text-[10px]">
                                    Explore Events
                                </a>
                            </div>
                            <div class="hidden lg:block opacity-20">
                                <span class="material-icons text-[180px]">hub</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Social Growth & Events) -->
                <div class="space-y-12">
                    <!-- Referral Network -->
                    @if(($settings['allow_referral_program'] ?? '1') == '1')
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-xl flex flex-col justify-between group hover:border-primary/30 transition-all duration-500 hover:shadow-primary/5">
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Referral Network</h3>
                                <div class="w-10 h-10 bg-orange-500/10 rounded-xl flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
                                    <span class="material-icons text-sm">share</span>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-2xl font-black text-navy-accent dark:text-white italic uppercase tracking-tighter">{{ $strategicRank }}</h4>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">{{ $totalReferrals }} Successful Referrals</p>
                            </div>
                            
                            <!-- Referral Code Sharing -->
                            <div class="mt-6 pt-6 border-t border-slate-50 dark:border-slate-800/50">
                                <div class="flex items-start gap-4">
                                    <div class="flex-1">
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Your Referral Code</p>
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-slate-50 dark:bg-slate-800/50 px-4 py-2.5 rounded-xl font-mono text-xs font-bold text-primary border border-slate-100 dark:border-slate-800 transition-all uppercase tracking-widest leading-none flex items-center justify-center">
                                                {{ $user->referral_code }}
                                            </div>
                                            <button onclick="copyToClipboard('{{ $user->referral_code }}', 'code')" class="p-2.5 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-xl transition-all group/copy">
                                                <span class="material-icons text-sm opacity-70 group-hover/copy:opacity-100">content_copy</span>
                                            </button>
                                        </div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-4 mb-2">Social Share</p>
                                        <div class="flex gap-2">
                                            <a href="https://wa.me/?text=Join%20me%20at%20IBSEA%20using%20my%20code:%20{{ $user->referral_code }}%20{{ route('register', ['referral_code' => $user->referral_code]) }}" 
                                               target="_blank"
                                               class="flex-1 py-2.5 bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white rounded-xl transition-all flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-widest">
                                                <span class="material-icons text-sm">share</span> WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- QR Code -->
                                    <div class="shrink-0">
                                        <div class="bg-white p-2 rounded-2xl border border-slate-100 shadow-sm relative group/qr">
                                            <img src="https://quickchart.io/qr?text={{ urlencode(route('register', ['referral_code' => $user->referral_code])) }}&size=120&light=ffffff&dark=000000" 
                                                 alt="Referral QR" 
                                                 class="w-24 h-24 rounded-lg">
                                            <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover/qr:opacity-100 transition-opacity rounded-2xl flex flex-col items-center justify-center text-white text-[8px] font-black uppercase tracking-widest text-center px-1">
                                                <span class="material-icons text-sm mb-1">qr_code_scanner</span>
                                                Scan to<br>Join
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ url('/user/referral') }}" class="mt-6 bg-slate-50 dark:bg-slate-800/50 hover:bg-primary hover:text-white text-slate-600 dark:text-slate-400 text-[10px] font-black py-4 rounded-2xl uppercase tracking-[0.2em] transition-all text-center">
                            Manage Network
                        </a>
                    </div>
                    @endif

                    <!-- Events List -->
                    <div class="space-y-8">
                        @include('user.dashboard_partials.events_list')
                        
                        <div class="bg-primary p-10 rounded-[3rem] text-white shadow-2xl shadow-primary/20 relative overflow-hidden group">
                            <div class="relative z-10 text-center space-y-4">
                                <span class="material-icons text-4xl mb-4 group-hover:scale-125 transition-transform duration-500">campaign</span>
                                <h4 class="text-2xl font-black italic uppercase tracking-tighter leading-tight">Global Connectivity</h4>
                                <p class="text-white/60 font-medium text-sm">Download the official ecosystem map and connect with world-class hubs.</p>
                                <button class="bg-white text-primary font-black px-8 py-4 rounded-2xl text-[10px] uppercase tracking-widest shadow-xl transition-all active:scale-95 w-full">Network Map</button>
                            </div>
                            <div class="absolute -right-8 -bottom-8 opacity-10">
                                <span class="material-icons text-9xl">language</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>
</div>

<!-- Dynamic Engagement Modals -->
@if($isRestricted)
    <!-- Conversion Modal (Guest -> Booster) -->
    <div id="conversionModal" class="fixed inset-0 z-[10000] flex items-center justify-center p-6 hidden">
        <div class="absolute inset-0 bg-slate-950/95 backdrop-blur-2xl transition-opacity duration-700 opacity-0" id="conversionOverlay"></div>
        <div class="relative bg-white dark:bg-slate-900 w-full max-w-md rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-[0_30px_100px_rgba(0,0,0,0.7)] overflow-hidden transition-all duration-500 scale-95 opacity-0 translate-y-4" id="conversionContent">
            <!-- Decorative Background -->
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-40 h-40 bg-orange-500/10 rounded-full blur-[50px]"></div>
            
            <button onclick="closeEngagementModal('conversionModal')" class="absolute top-5 right-5 w-9 h-9 rounded-lg bg-slate-50 dark:bg-slate-800/50 flex items-center justify-center text-slate-400 hover:text-primary transition-all z-20">
                <span class="material-icons text-lg">close</span>
            </button>

            <div class="p-7 md:p-10 relative z-10 text-center space-y-6">
                <!-- Header -->
                <div class="space-y-2">
                    <h2 class="text-xl font-black text-navy-accent dark:text-white leading-tight italic tracking-tighter uppercase">Become Part of IBSEA Today</h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">To expand your network knowledge and sales</p>
                </div>
                
                <!-- Plan Card -->
                <div class="bg-primary/5 dark:bg-white/5 border border-primary/20 rounded-3xl p-6 text-left relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-primary italic uppercase tracking-tighter">Booster Membership</span>
                            <span class="material-icons text-primary text-sm">rocket_launch</span>
                        </div>
                        <h4 class="text-xs font-bold text-slate-500 dark:text-slate-400 mb-4">Start Growing Your Business with IBSEA</h4>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-black text-navy-accent dark:text-white">₹1,999</span>
                            <span class="text-[10px] font-bold text-slate-500 uppercase">/ Annual</span>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-700">
                        <span class="material-icons text-7xl text-primary">bolt</span>
                    </div>
                </div>

                <!-- Benefits List -->
                <ul class="text-left space-y-2.5 px-1">
                    @foreach([
                        'Access to IBSEA conferences and networking',
                        'Exclusive WhatsApp community access',
                        '50 hours growth training annually',
                        'Discount coupons for conclaves/meetups',
                        'E-Certificate and Membership ID Card',
                        '10% discount on Vyapar Badhao'
                    ] as $benefit)
                        <li class="flex items-start gap-2.5 text-[9px] font-bold text-slate-600 dark:text-slate-300 leading-tight">
                            <span class="material-icons text-primary text-[14px] shrink-0">check_circle</span>
                            {{ $benefit }}
                        </li>
                    @endforeach
                </ul>

                <div class="flex flex-col gap-2.5 pt-2">
                    <a href="{{ route('membership') }}?plan=booster" class="bg-primary hover:bg-orange-600 text-white font-black py-4 rounded-xl transition-all shadow-xl shadow-primary/20 text-sm uppercase tracking-widest flex items-center justify-center gap-2 active:scale-95 group">
                        Join IBSEA Now <span class="material-icons text-md group-hover:translate-x-1 transition-transform">bolt</span>
                    </a>
                    <button onclick="closeEngagementModal('conversionModal')" class="text-[8px] font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-all">I'll do it later</button>
                </div>
            </div>
        </div>
    </div>
@elseif(!$user->profile_completed)
    <!-- Profile Completion Modal (One-time Daily) -->
    <div id="profileReminderModal" class="fixed inset-0 z-[10000] flex items-center justify-center p-6 hidden">
        <div class="absolute inset-0 bg-slate-950/95 backdrop-blur-2xl transition-opacity duration-700 opacity-0" id="profileOverlay"></div>
        <div class="relative bg-white dark:bg-slate-900 w-full max-w-md rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-[0_30px_100px_rgba(0,0,0,0.7)] overflow-hidden transition-all duration-500 scale-95 opacity-0 translate-y-4" id="profileContent">
            
            <button onclick="closeEngagementModal('profileReminderModal')" class="absolute top-5 right-5 w-9 h-9 rounded-lg bg-slate-50 dark:bg-slate-800/50 flex items-center justify-center text-slate-400 hover:text-primary transition-all z-20">
                <span class="material-icons text-lg">close</span>
            </button>

            <div class="p-7 md:p-10 relative z-10 text-center space-y-5">
                <div class="w-16 h-16 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500 mx-auto animate-bounce">
                    <span class="material-icons text-3xl">person_pin</span>
                </div>
                
                <div class="space-y-2.5">
                    <h2 class="text-2xl font-black text-navy-accent dark:text-white leading-tight italic tracking-tighter uppercase">Complete Your Portfolio</h2>
                    <p class="text-slate-500 font-bold text-xs leading-relaxed px-2">Your business portfolio is the key to global networking. Finish your setup to appear in the directory.</p>
                </div>

                <div class="bg-primary/5 dark:bg-white/5 p-4 rounded-xl border border-primary/20">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[8px] font-black text-primary uppercase tracking-widest">Profile Progress</span>
                        <span class="text-[8px] font-black text-primary italic">2 Mins Left</span>
                    </div>
                    <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                        <div class="bg-primary h-full rounded-full animate-pulse" style="width: 60%"></div>
                    </div>
                </div>

                <div class="flex flex-col gap-2.5 pt-2">
                    <a href="{{ route('user.onboarding') }}" class="bg-primary hover:bg-orange-600 text-white font-black py-4 rounded-xl transition-all shadow-xl shadow-primary/20 text-sm uppercase tracking-widest active:scale-95">
                        Complete Portfolio Now
                    </a>
                    <button onclick="closeEngagementModal('profileReminderModal')" class="text-[8px] font-black text-slate-400 uppercase tracking-widest hover:text-primary transition-all">Remind Me Tomorrow</button>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
    function copyToClipboard(text, type) {
        navigator.clipboard.writeText(text).then(() => {
            alert(type === 'code' ? 'Referral Code Copied!' : 'Referral Link Copied!');
        }).catch(err => {
            console.error('Failed to copy: ', err);
            // Fallback
            const el = document.createElement('textarea');
            el.value = text;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            alert(type === 'code' ? 'Referral Code Copied!' : 'Referral Link Copied!');
        });
    }

    // Modal Handling Logic
    function openEngagementModal(id) {
        const modal = document.getElementById(id);
        const overlayId = id === 'conversionModal' ? 'conversionOverlay' : 'profileOverlay';
        const contentId = id === 'conversionModal' ? 'conversionContent' : 'profileContent';
        
        const overlay = document.getElementById(overlayId);
        const content = document.getElementById(contentId);
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            content.classList.remove('scale-90', 'opacity-0', 'translate-y-8');
        }, 100);
    }

    function closeEngagementModal(id) {
        const overlayId = id === 'conversionModal' ? 'conversionOverlay' : 'profileOverlay';
        const contentId = id === 'conversionModal' ? 'conversionContent' : 'profileContent';
        
        const overlay = document.getElementById(overlayId);
        const content = document.getElementById(contentId);
        
        overlay.classList.add('opacity-0');
        content.classList.add('scale-90', 'opacity-0', 'translate-y-8');
        setTimeout(() => {
            document.getElementById(id).classList.add('hidden');
        }, 500);
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if($isRestricted)
            // Guest Conversion Popup (Once-per-day)
            const lastShownConversion = localStorage.getItem('ibsea_conversion_reminder_day');
            const today = new Date().toDateString();

            if (lastShownConversion !== today) {
                setTimeout(() => {
                    openEngagementModal('conversionModal');
                    localStorage.setItem('ibsea_conversion_reminder_day', today);
                }, 1500);
            }
        @elseif(!$user->profile_completed)
            // Profile Completion Reminder (Once-per-day)
            const lastShownProfile = localStorage.getItem('ibsea_profile_reminder_day');
            const today = new Date().toDateString();

            if (lastShownProfile !== today) {
                setTimeout(() => {
                    openEngagementModal('profileReminderModal');
                    localStorage.setItem('ibsea_profile_reminder_day', today);
                }, 2000); // Slight delay for member impact
            }
        @endif
    });
</script>
@endpush
