@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 pt-32 pb-20">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <header class="text-center mb-16 max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-black text-primary dark:text-white mb-6 tracking-tight uppercase">
                Institutional <span class="text-orange-500">Media Vault</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-bold text-lg leading-relaxed">
                Exploring IBSEA's strategic footprint through organized visual portfolios.
            </p>
        </header>

        <!-- Category Filters -->
        <div class="flex flex-wrap justify-center gap-4 mb-16">
            <a href="{{ route('gallery.index') }}" 
               class="px-8 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ !request('category') ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-105' : 'bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 border border-slate-100 dark:border-slate-800 hover:border-primary/30' }}">
                All Discovery
            </a>
            @foreach(['Event Highlights', 'Institutional Operations', 'Others'] as $cat)
            <a href="{{ route('gallery.index', ['category' => $cat]) }}" 
               class="px-8 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ request('category') === $cat ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-105' : 'bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 border border-slate-100 dark:border-slate-800 hover:border-primary/30' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>

        <!-- Gallery Folders -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-12">
            @forelse($folders as $folder)
            <div class="group relative">
                <a href="{{ route('gallery.show', $folder->title) }}" class="block p-4 bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-premium border border-slate-100 dark:border-slate-800 transition-all hover:-translate-y-4 hover:shadow-2xl hover:border-primary/30 relative">
                    
                    <!-- Folder Stack Effect -->
                    <div class="aspect-square relative overflow-hidden rounded-[2rem] bg-slate-50 dark:bg-slate-800 mb-6">
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 to-transparent"></div>
                        <img src="{{ asset($folder->cover_image) }}" 
                             alt="{{ $folder->title }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                        
                        <!-- Folder Badge -->
                        <div class="absolute top-4 right-4 bg-primary text-white w-10 h-10 rounded-2xl flex items-center justify-center shadow-xl">
                            <span class="text-xs font-black">{{ $folder->image_count }}</span>
                        </div>
                    </div>

                    <!-- Meta -->
                    <div class="px-2 pb-2">
                        <span class="text-[9px] font-black text-orange-500 uppercase tracking-widest mb-1 block">{{ $folder->category }}</span>
                        <h3 class="text-slate-800 dark:text-white font-black text-sm uppercase leading-tight group-hover:text-primary transition-colors line-clamp-2 min-h-[2.5rem]">{{ $folder->title }}</h3>
                        
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">View Portfolio</span>
                            <div class="w-8 h-8 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-300 group-hover:bg-primary group-hover:text-white transition-all">
                                <span class="material-icons text-sm">arrow_forward</span>
                            </div>
                        </div>
                    </div>

                    <!-- Visual Decorations -->
                    <div class="absolute -top-2 -left-2 w-full h-full bg-slate-100 dark:bg-slate-900 rounded-[2.5rem] -z-10 transition-transform group-hover:-translate-x-2 group-hover:-translate-y-2 opacity-50"></div>
                </a>
            </div>
            @empty
            <div class="col-span-full py-24 text-center">
                <div class="w-24 h-24 bg-slate-100 dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-icons text-4xl text-slate-300">folder_off</span>
                </div>
                <h3 class="text-slate-800 dark:text-white font-black text-xl uppercase tracking-widest">Media Hub Empty</h3>
                <p class="text-slate-500 dark:text-slate-400 font-bold mt-2">No institutional dispatches archived yet.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($folders->hasPages())
        <div class="mt-20">
            {{ $folders->links() }}
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .shadow-premium {
        box-shadow: 0 20px 50px -15px rgba(0, 74, 149, 0.08);
    }
    .dark .shadow-premium {
        box-shadow: 0 20px 50px -15px rgba(0, 0, 0, 0.5);
    }
</style>
@endpush
@endsection
