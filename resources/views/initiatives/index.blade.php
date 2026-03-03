@extends('layouts.app')

@push('styles')
<style>
    .initiative-section:nth-child(even) { @apply bg-slate-50 dark:bg-slate-900/50; }
    .initiative-section:nth-child(odd) { @apply bg-white dark:bg-background-dark; }
    .content-area h2 { @apply text-3xl font-black text-secondary dark:text-white mt-8 mb-4 uppercase tracking-tight; }
    .content-area p { @apply text-slate-600 dark:text-slate-400 leading-relaxed mb-6 text-lg font-medium; }
    .content-area ul { @apply list-disc pl-6 mb-6 space-y-2 text-slate-600 dark:text-slate-400; }
    .sticky-nav { @apply sticky top-20 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 hidden md:block; }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative pt-40 pb-20 overflow-hidden bg-secondary">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-primary/20 via-transparent to-transparent"></div>
    </div>
    
    <div class="container mx-auto px-4 lg:px-16 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <nav class="flex justify-center items-center gap-2 mb-8 text-[10px] font-black uppercase tracking-[0.2em] text-primary">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors">Home</a>
                <span class="material-icons text-xs">chevron_right</span>
                <span class="text-white">Strategic Initiatives</span>
            </nav>

            <h1 class="text-4xl md:text-7xl font-display font-black text-white mb-8 leading-tight uppercase tracking-tighter">
                Strategic <span class="text-primary italic">Roadmaps</span>
            </h1>

            <p class="text-xl text-slate-300 font-medium leading-relaxed">
                A common information hub for all IBSEA initiatives. Explore the full depth, framework, and vision of our flagship programs in one place.
            </p>
        </div>
    </div>
</section>

<!-- Sticky Quick Nav -->
<div class="sticky-nav">
    <div class="container mx-auto px-4 lg:px-16">
        <div class="flex items-center gap-8 overflow-x-auto no-scrollbar py-4 justify-center">
            @foreach($initiatives as $init)
            <a href="#{{ $init->slug }}" class="whitespace-nowrap text-[9px] font-black uppercase tracking-widest text-slate-500 hover:text-primary transition-all flex items-center gap-2 group">
                <span class="w-4 h-4 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[8px] group-hover:bg-primary group-hover:text-white transition-all">{{ $loop->iteration }}</span>
                {{ $init->title }}
            </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Consolidated Grid Content -->
<div class="container mx-auto px-4 lg:px-16 py-20">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($initiatives as $init)
        <a href="{{ $init->custom_url ?: route('public.initiatives.show', $init->slug) }}" class="group relative bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-premium overflow-hidden hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-2 transition-all duration-500 flex flex-col h-full z-0">
            
            <!-- Animated Top Border -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-secondary scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left z-20"></div>

            <!-- Card Header Pattern -->
            <div class="h-56 relative flex-shrink-0 border-b border-slate-100 dark:border-slate-800/50 z-10">
                <!-- Background Layer (clips images only, allows badges to float outside) -->
                <div class="absolute inset-0 overflow-hidden bg-slate-50 dark:bg-slate-800/50">
                    @if($init->banner_path)
                        <img src="{{ $init->banner_url }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $init->title }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent z-0"></div>
                    @else
                        <!-- Premium Mesh Background Fallback -->
                        <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_80%_20%,_var(--tw-gradient-stops))] from-primary/40 via-transparent to-transparent group-hover:opacity-60 transition-opacity duration-700"></div>
                        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_80%,_var(--tw-gradient-stops))] from-secondary/40 via-transparent to-transparent group-hover:opacity-40 transition-opacity duration-700"></div>
                    @endif
                </div>
                
                <!-- Floating Status Badge -->
                <div class="absolute z-10 top-6 right-6 px-3 py-1 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-full border border-slate-200 dark:border-slate-700 shadow-sm">
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-secondary dark:text-white">Active</span>
                </div>

                <!-- Floating Logo/Icon Badge (No longer cut off!) -->
                <div class="absolute -bottom-10 left-8 w-20 h-20 bg-white dark:bg-slate-900 rounded-2xl flex items-center justify-center shadow-xl border border-slate-100 dark:border-slate-800 z-20 group-hover:shadow-primary/20 transition-shadow duration-300">
                    @if($init->logo_path)
                        <img src="{{ $init->logo_url }}" class="w-12 h-12 object-contain group-hover:scale-110 transition-transform duration-500" alt="Logo">
                    @else
                        <span class="material-icons text-3xl text-primary group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">{{ $init->icon ?? 'flag' }}</span>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-8 pt-16 flex flex-col flex-grow relative bg-gradient-to-b from-transparent to-slate-50/50 dark:to-slate-900/50 z-0">
                <h3 class="text-2xl font-black text-secondary dark:text-white uppercase tracking-tight mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-300">{{ $init->title }}</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-8 line-clamp-3">
                    <span class="w-1 h-1 rounded-full bg-primary/50"></span>
                    {{ $init->summary }}
                </p>
                
                
                <!-- Card Footer Elements -->
                <div class="mt-auto flex flex-col gap-6">
                    @if($init->organizer_name)
                    <div class="flex items-center gap-4 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <div class="w-10 h-10 rounded-xl overflow-hidden shadow-sm border border-slate-100 dark:border-slate-800 shrink-0">
                            <img src="{{ $init->organizer_image_url }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Strategic Leader</p>
                            <p class="text-[11px] font-black text-secondary dark:text-white uppercase tracking-widest line-clamp-1">{{ $init->organizer_name }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex items-center justify-between pt-4 w-full">
                        <span class="text-[10px] whitespace-nowrap font-black uppercase tracking-widest text-slate-500 group-hover:text-primary transition-colors">Know More</span>
                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center group-hover:bg-primary transition-colors duration-300">
                            <span class="material-icons text-sm text-primary group-hover:text-white group-hover:translate-x-0.5 transition-all">arrow_forward</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>

<!-- Ecosystem Call to Action -->
<section class="py-24 bg-white dark:bg-background-dark overflow-hidden relative">
    <div class="container mx-auto px-4 lg:px-16">
        <div class="bg-secondary rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-[100px] -mr-48 -mt-48"></div>
            
            <h2 class="text-3xl md:text-5xl font-display font-black text-white mb-8 uppercase leading-tight relative z-10">
                Are you ready to <span class="text-primary italic">Lead</span>?
            </h2>
            
            <p class="text-lg text-slate-300 max-w-2xl mx-auto mb-12 relative z-10">
                Join our council of mentors and industry titans. Together, we are building the roadmap for Bharat @2047.
            </p>
            
            <a href="{{ url('/register') }}" class="inline-block bg-primary text-secondary px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:bg-white transition-all relative z-10">
                Register Membership
            </a>
        </div>
    </div>
</section>

<script>
    // Smooth scroll for quick nav
    document.querySelectorAll('.sticky-nav a').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endsection
