@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-32 pb-20">
    <div class="container mx-auto px-6">
        <!-- Breadcrumbs & Header -->
        <div class="mb-12">
            <a href="{{ route('gallery.index') }}" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 hover:text-primary transition-all mb-6">
                <span class="material-icons text-xs">arrow_back</span>
                Return to Media Vault
            </a>
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <header class="max-w-3xl">
                    <span class="text-orange-500 font-black text-[10px] uppercase tracking-[0.3em] mb-2 block">Institutional Portfolio</span>
                    <h1 class="text-3xl md:text-5xl font-black text-primary dark:text-white tracking-tight uppercase leading-tight">
                        {{ $folderTitle }}
                    </h1>
                </header>
                <div class="bg-white dark:bg-slate-900 px-8 py-4 rounded-[2rem] shadow-premium border border-slate-100 dark:border-slate-800 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-icons text-sm">photo_library</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Assets</p>
                        <p class="text-xl font-black text-primary dark:text-white leading-none">{{ $images->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($images as $item)
            <div class="gallery-item group relative bg-white dark:bg-slate-900 rounded-[2rem] overflow-hidden shadow-premium border border-slate-100 dark:border-slate-800 transition-all hover:shadow-2xl">
                <a href="{{ asset($item->image_path) }}" class="glightbox block relative aspect-[4/3] overflow-hidden">
                    <img src="{{ asset($item->image_path) }}" 
                         alt="{{ $item->title }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col justify-end p-8">
                        <p class="text-white/60 text-[8px] font-black uppercase tracking-widest">Expansion Mode Available</p>
                        <h3 class="text-white font-bold text-xs mt-1">Institutional Asset-{{ $loop->iteration }}</h3>
                    </div>
                </a>
                
                <div class="p-6 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/50">
                    <p class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest">Dispatch: {{ $item->created_at->format('M Y') }}</p>
                    <div class="w-8 h-8 rounded-lg bg-white dark:bg-slate-900 flex items-center justify-center text-slate-300 shadow-sm">
                        <span class="material-icons text-[12px]">zoom_out_map</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Call to Action -->
        <div class="mt-20 p-12 bg-primary rounded-[3rem] text-center relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
            <div class="relative z-10">
                <h3 class="text-2xl md:text-3xl font-black text-white uppercase tracking-tight mb-4">Strategic Visual Intelligence</h3>
                <p class="text-white/70 font-bold mb-8 max-w-2xl mx-auto">These assets are part of IBSEA's official institutional archive documenting international trade milestones and global alliance progressions.</p>
                <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-3 bg-white text-primary px-10 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:scale-105 transition-all">
                    Explore Other Vaults <span class="material-icons text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<style>
    .shadow-premium {
        box-shadow: 0 20px 50px -15px rgba(0, 74, 149, 0.08);
    }
    .dark .shadow-premium {
        box-shadow: 0 20px 50px -15px rgba(0, 0, 0, 0.5);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script>
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: true
    });
</script>
@endpush
@endsection
