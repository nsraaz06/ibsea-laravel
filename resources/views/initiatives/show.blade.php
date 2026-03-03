@extends('layouts.app')

@push('styles')
<style>
    .initiative-content h2 { @apply text-2xl font-bold text-secondary mt-8 mb-4 uppercase tracking-tight; }
    .initiative-content p { @apply text-slate-600 leading-relaxed mb-6 text-lg; }
    .initiative-content ul { @apply list-disc pl-6 mb-6 space-y-2 text-slate-600; }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20 overflow-hidden bg-secondary">
    <div class="absolute inset-0 opacity-20">
        <img src="{{ $initiative->banner_url }}" class="w-full h-full object-cover blur-sm scale-105" alt="Banner Background">
        <div class="absolute inset-0 bg-gradient-to-b from-secondary via-secondary/80 to-secondary"></div>
    </div>
    
    <div class="container mx-auto px-4 lg:px-16 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left Column: Content -->
            <div>
                <nav class="flex items-center gap-2 mb-8 text-[10px] font-black uppercase tracking-[0.2em] text-primary">
                    <a href="{{ url('/') }}" class="hover:text-white transition-colors">Home</a>
                    <span class="material-icons text-xs">chevron_right</span>
                    <span class="text-white/60">Strategic Initiatives</span>
                    <span class="material-icons text-xs font-bold">chevron_right</span>
                    <span class="text-white">{{ $initiative->title }}</span>
                </nav>

                <div class="inline-flex items-center gap-4 bg-white backdrop-blur-md border border-primary/30 px-6 py-2 rounded-xl mb-8 overflow-hidden">
                    @if($initiative->logo_path)
                        <img src="{{ $initiative->logo_url }}" class="w-32 h-32 object-contain" alt="Logo">
                    @else
                        <span class="material-icons text-primary text-xl">{{ $initiative->icon }}</span>
                    @endif
                    <!-- <span class="text-[10px] font-black text-white uppercase tracking-[0.3em]">Priority Initiative</span> -->
                </div>

                <h1 class="text-4xl md:text-6xl font-display font-black text-white mb-8 leading-tight uppercase">
                    {{ $initiative->title }}
                </h1>

                <p class="text-xl text-slate-300 font-medium max-w-2xl leading-relaxed">
                    {{ $initiative->summary }}
                </p>
            </div>

            <!-- Right Column: Leadership -->
            <div class="flex justify-start lg:justify-end">
                @if($initiative->organizer_name)
                <div class="bg-white/5 backdrop-blur-2xl border border-white/10 p-10 rounded-[2.5rem] group/lead max-w-sm w-full shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full -mr-16 -mt-16 blur-3xl group-hover/lead:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-6 mb-8">
                            <div class="w-24 h-24 rounded-full border-4 border-orange-500 overflow-hidden shadow-2xl group-hover/lead:scale-105 transition-transform duration-500">
                                <img src="{{ $initiative->organizer_image_url }}" alt="{{ $initiative->organizer_name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mb-2">Strategic Leadership</h4>
                                <div class="text-2xl font-black text-white uppercase tracking-tight leading-none mb-1">{{ $initiative->organizer_name }}</div>
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $initiative->organizer_role }}</div>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            @if($initiative->organizer_email)
                            <a href="mailto:{{ $initiative->organizer_email }}" class="flex-1 flex items-center justify-center gap-2 bg-white text-secondary py-4 rounded-xl font-black text-[9px] uppercase tracking-widest hover:bg-primary hover:text-white transition-all">
                                <span class="material-icons text-sm">mail</span> Connect
                            </a>
                            @endif
                            @if($initiative->organizer_linkedin)
                            <a href="{{ $initiative->organizer_linkedin }}" target="_blank" class="w-12 h-12 flex items-center justify-center bg-white/10 text-white rounded-xl hover:bg-blue-600 transition-all border border-white/10">
                                <span class="material-icons shadow-sm">link</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Content Architecture -->
<section class="py-24 bg-white dark:bg-background-dark">
    <div class="container mx-auto px-4 lg:px-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            <!-- Main Content Area -->
            <div class="lg:col-span-8">
                <!-- Main Banner above Content -->
                <div class="mb-10 rounded-[2.5rem] overflow-hidden shadow-2xl border border-slate-100 dark:border-slate-800">
                    <img src="{{ $initiative->banner_url }}" class="w-full h-auto object-cover max-h-[500px]" alt="{{ $initiative->title }} Banner">
                </div>

                <div class="initiative-content prose prose-lg dark:prose-invert max-w-none">
                    {!! $initiative->content !!}
                </div>

                @if($initiative->youtube_link)
                <div class="mt-16 space-y-6">
                    <h3 class="text-xl font-black text-secondary dark:text-white uppercase tracking-tight flex items-center gap-3">
                        <span class="material-icons text-red-600">play_circle</span>
                        Project Overview & Roadmap
                    </h3>
                    <div class="aspect-video rounded-3xl overflow-hidden shadow-2xl bg-black">
                        @php
                            $videoId = null;
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $initiative->youtube_link, $matches)) {
                                $videoId = $matches[1];
                            }
                        @endphp
                        
                        @if($videoId)
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white/50 flex-col gap-4">
                                <span class="material-icons text-6xl">video_library</span>
                                <a href="{{ $initiative->youtube_link }}" target="_blank" class="text-primary font-bold underline">Watch Video on YouTube</a>
                            </div>
                        @endif
                    </div>
                </div>
                @endif


                @if($initiative->pdf_path)
                <div class="mt-16 p-10 bg-slate-50 dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-8 group">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-red-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-red-500/20 group-hover:scale-110 transition-transform">
                            <span class="material-icons text-3xl">picture_as_pdf</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-secondary dark:text-white uppercase tracking-tight">Full Initiative Pdf</h3>
                            <p class="text-sm font-medium text-slate-500">Access the detailed project framework and strategic roadmap.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('public.initiatives.view', $initiative->slug) }}" class="bg-white border-2 border-slate-200 text-secondary px-8 py-5 rounded-xl font-black text-xs uppercase tracking-widest hover:border-primary transition-all flex items-center gap-3">
                            View <span class="material-icons text-sm">visibility</span>
                        </a>
                        <a href="{{ route('public.initiatives.download', $initiative->slug) }}" class="bg-secondary text-white px-8 py-5 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-primary transition-all shadow-premium flex items-center gap-3">
                            Download <span class="material-icons text-sm">download</span>
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar Intel -->
            <div class="lg:col-span-4 space-y-10">
                <!-- Contact Leadership (Simplified) -->
                @if($initiative->organizer_email || $initiative->organizer_linkedin)
                <div class="bg-slate-50 dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800">
                    <h4 class="text-[10px] font-black text-secondary dark:text-white uppercase tracking-[0.2em] mb-6">Contact Leadership</h4>
                    <div class="flex flex-col gap-4">
                        @if($initiative->organizer_email)
                        <a href="mailto:{{ $initiative->organizer_email }}" class="flex items-center gap-4 bg-white dark:bg-white/5 p-4 rounded-xl text-slate-600 dark:text-slate-300 hover:text-primary transition-all shadow-sm">
                            <span class="material-icons text-primary">mail</span>
                            <span class="text-[10px] font-black uppercase tracking-widest">Send Inquiry</span>
                        </a>
                        @endif
                        @if($initiative->organizer_linkedin)
                        <a href="{{ $initiative->organizer_linkedin }}" target="_blank" class="flex items-center gap-4 bg-white dark:bg-white/5 p-4 rounded-xl text-slate-600 dark:text-slate-300 hover:text-blue-500 transition-all shadow-sm">
                            <span class="material-icons text-blue-500">link</span>
                            <span class="text-[10px] font-black uppercase tracking-widest">Leadership LinkedIn</span>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Other Initiatives -->
                <div class="space-y-6">
                    <h4 class="text-[11px] font-black text-secondary dark:text-white uppercase tracking-[0.2em] px-2 flex justify-between items-center">
                        Explore Ecosystem
                        <span class="w-12 h-[1px] bg-slate-200"></span>
                    </h4>
                    
                    <div class="space-y-4">
                        @foreach($otherInitiatives as $other)
                        <a href="{{ route('public.initiatives.show', $other->slug) }}" class="flex items-center gap-5 p-4 bg-slate-50/50 dark:bg-white/5 rounded-2xl border border-transparent hover:border-primary/20 hover:bg-white dark:hover:bg-slate-800 transition-all group">
                            <div class="w-12 h-12 rounded-xl bg-white dark:bg-slate-700 flex items-center justify-center text-primary shadow-sm group-hover:bg-primary group-hover:text-white transition-all">
                                <span class="material-icons text-xl">{{ $other->icon }}</span>
                            </div>
                            <div class="flex-1">
                                <h5 class="text-[11px] font-black text-secondary dark:text-white uppercase tracking-tight mb-0.5">{{ $other->title }}</h5>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Explore Priority</p>
                            </div>
                            <span class="material-icons text-slate-200 group-hover:text-primary transition-colors">chevron_right</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- CTA -->
                <div class="p-10 bg-primary rounded-[2.5rem] text-white relative overflow-hidden group">
                    <div class="absolute bottom-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <h3 class="text-2xl font-black uppercase tracking-tight mb-4 relative z-10">Unleash Your Potential</h3>
                    <p class="text-xs text-white/70 font-bold uppercase tracking-widest mb-8 relative z-10">Join IBSEA today and be part of India's growth engine.</p>
                    <a href="{{ url('/register') }}" class="inline-flex items-center gap-3 bg-white text-secondary px-8 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-amber-500 transition-all shadow-xl relative z-10">
                        Join Membership <span class="material-icons text-xs">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
