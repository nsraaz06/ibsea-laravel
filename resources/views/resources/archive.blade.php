@extends('layouts.app')

@section('content')
<div class="bg-slate-50 dark:bg-slate-950 min-h-screen pb-20">
    <!-- Hero Section -->
    <div class="bg-navy-accent z-50 dark:bg-slate-900 pt-32 pb-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 bg-primary/10 border border-primary/20 px-4 py-2 rounded-full mb-6">
                    <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-primary dark:text-orange-500">Global Intelligence Hub</span>
                </span>
                <h1 class="text-4xl md:text-6xl font-black text-white leading-tight tracking-tighter italic mb-6">Strategic Global Sectors & Asset Archive</h1>
                <p class="text-slate-400 text-lg md:text-xl font-medium leading-relaxed">Access high-authority technical dossiers, sector reports, and institutional guides from our global network of professional alliances.</p>
            </div>
        </div>
        <!-- Abstract Decor -->
        <div class="absolute -right-20 -bottom-20 opacity-10 blur-3xl">
            <div class="w-96 h-96 bg-primary rounded-full"></div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 -mt-10 relative z-[60]">
        <!-- Guest Notification Prompt -->
        @guest('member')
        <div class="mb-8 bg-orange-500 border border-orange-500/20 p-4 rounded-3xl flex items-center justify-between gap-4 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <span class="material-icons text-white">lock</span>
                <p class="text-[10px] md:text-xs font-black uppercase tracking-widest text-white dark:text-orange-400">Please login for secure PDF downloads or high-authority controls.</p>
            </div>
            <a href="{{ route('login') }}" class="bg-white text-orange-500 px-6 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20">Login Now</a>
        </div>
        @endguest

        <!-- Filter Bar -->
        <div class="bg-white dark:bg-slate-900 p-4 rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center gap-6">
            <div class="flex-1 w-full overflow-x-auto no-scrollbar">
                <div class="flex items-center gap-3 whitespace-nowrap px-2">
                    <a href="{{ route('public.resources.index') }}" class="px-6 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ !request('sector') ? 'bg-primary text-white shadow-lg' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5' }}">
                        All Sectors
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('public.resources.index', ['sector' => $category->slug]) }}" class="px-6 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request('sector') == $category->slug ? 'bg-primary text-white shadow-lg' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            
            <div class="shrink-0 w-full md:w-auto px-2">
                <form action="{{ route('public.resources.index') }}" method="GET" class="relative">
                    @if(request('sector'))
                        <input type="hidden" name="sector" value="{{ request('sector') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search intelligence..." class="bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-12 py-3 text-xs font-bold text-slate-800 dark:text-white w-full md:w-64 focus:ring-2 focus:ring-primary transition-all">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                </form>
            </div>
        </div>

        <!-- Resources Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mt-12">
            @forelse($resources as $resource)
            <a href="{{ route('public.resources.show', $resource->slug) }}" class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-premium border border-slate-100 dark:border-slate-800 overflow-hidden group hover:border-primary transition-all flex flex-col">
                {{-- A4 Ratio implementation (1:1.41) --}}
                <div class="relative w-full overflow-hidden bg-slate-100 dark:bg-slate-800" style="padding-top: 141.42%;">
                    @php
                        $isPdf = \Illuminate\Support\Str::endsWith(strtolower($resource->file_path), '.pdf');
                    @endphp
                    
                    <div class="absolute inset-0">
                        @if($resource->cover_image)
                            <img src="{{ asset($resource->cover_image) }}" alt="{{ $resource->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center p-8 text-center text-slate-300">
                                <span class="material-icons text-6xl mb-4">{{ $resource->resourceCategory->icon ?? 'inventory_2' }}</span>
                                <p class="text-[10px] font-black uppercase tracking-widest">{{ $resource->title }}</p>
                            </div>
                        @endif
                        
                        <!-- Simple View Indicator (Always visible on mobile/hover) -->
                        <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-black/60 to-transparent flex justify-center opacity-0 group-hover:opacity-100 md:opacity-0 transition-opacity">
                            <span class="bg-white/20 backdrop-blur-md text-white border border-white/30 px-6 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2">
                                <span class="material-icons text-sm">visibility</span>
                                View Dossier
                            </span>
                        </div>

                        <div class="absolute top-6 left-6">
                            <span class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-slate-800 dark:text-white px-3 py-1.5 rounded-xl text-[8px] font-black uppercase tracking-widest border border-slate-200 dark:border-slate-700 shadow-sm">
                                 {{ $resource->resourceCategory->name ?? 'Unclassified' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-8 flex-grow">
                    <h3 class="text-xs md:text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight line-clamp-2 leading-tight mb-3 group-hover:text-primary transition-colors">{{ $resource->title }}</h3>
                    <p class="text-[10px] md:text-[11px] font-medium text-slate-500 line-clamp-2 italic mb-6 leading-relaxed">{{ $resource->description ?? 'Secure institutional document from the IBSEA Sector Alliance.' }}</p>
                    
                    <div class="flex items-center justify-between pt-6 border-t border-slate-50 dark:border-slate-800">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Access Granted</span>
                        </div>
                        <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">{{ \Carbon\Carbon::parse($resource->created_at)->format('M d, Y') }}</span>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full py-32 text-center bg-white dark:bg-slate-900 rounded-[3rem] border-2 border-dashed border-slate-100 dark:border-slate-800">
                <div class="flex flex-col items-center gap-4">
                    <span class="material-icons text-6xl text-slate-200 dark:text-slate-700">inventory_2</span>
                    <p class="text-slate-400 font-bold uppercase tracking-widest">No sector intelligence found in this category.</p>
                    <a href="{{ route('public.resources.index') }}" class="text-primary font-black uppercase text-[10px] tracking-widest mt-4">Reset Mission Filters</a>
                </div>
            </div>
            @endforelse
        </div>

        @if($resources->hasPages())
        <div class="mt-20">
            {{ $resources->links() }}
        </div>
        @endif
    </div>

    <!-- Floating Back Button -->
    <a href="{{ url()->previous() == url()->current() ? route('home') : url()->previous() }}" class="fixed bottom-10 right-10 z-[100] bg-white dark:bg-slate-800 text-slate-800 dark:text-white w-14 h-14 rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all border border-slate-200 dark:border-slate-700 group">
        <span class="material-icons group-hover:-translate-x-1 transition-transform">arrow_back</span>
        <div class="absolute right-full mr-4 bg-slate-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">
            Back to previous
        </div>
    </a>
</div>

<style>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
