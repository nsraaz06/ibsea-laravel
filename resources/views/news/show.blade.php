@extends('layouts.app')

@section('content')
    <!-- Hero Header -->
    <section class="pt-48 pb-24 bg-slate-50 dark:bg-[#1a120b] relative border-b border-slate-100 dark:border-slate-800">
        <div class="max-w-4xl mx-auto px-6" data-aos="fade-up">
            <div class="flex flex-wrap items-center gap-4 mb-8">
                <span class="bg-primary text-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-lg">
                    {{ $post->category }}
                </span>
                <span class="text-slate-400 dark:text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                </span>
            </div>
            <h1 class="text-3xl md:text-5xl font-black text-secondary dark:text-white leading-[1.3] mb-12 uppercase tracking-tight">
                {{ $post->title }}
            </h1>
            
            <div class="flex items-center gap-5 border-t border-slate-100 dark:border-slate-800 pt-8 mt-12">
                <div class="w-14 h-14 rounded-full overflow-hidden bg-slate-200 dark:bg-slate-800 border-4 border-white dark:border-slate-700 shadow-xl">
                    @if($post->author && $post->author->profile_image)
                        <img src="{{ asset($post->author->profile_image) }}" alt="{{ $post->author->name }}" class="w-full h-full object-cover">
                    @elseif($post->author_image)
                        <img src="{{ asset($post->author_image) }}" alt="Author" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100 dark:bg-slate-800">
                            <span class="material-symbols-outlined text-2xl">person</span>
                        </div>
                    @endif
                </div>
                <div>
                    <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em] mb-1">Published By</p>
                    <p class="font-black text-secondary dark:text-white text-lg">{{ $post->author ? $post->author->name : ($post->author_name ?: 'Dr. Anshumaan Singh') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Area -->
    <article class="py-24 bg-white dark:bg-[#15100c]">
        <div class="max-w-4xl mx-auto px-6">
            @if($post->featured_image)
                <div class="rounded-[3rem] overflow-hidden shadow-2xl -mt-48 mb-20 border-[12px] border-white dark:border-slate-800 relative z-20" data-aos="zoom-in">
                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto">
                </div>
            @endif

            <div class="prose prose-lg dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 leading-[1.8] font-medium" data-aos="fade-up">
                {!! $post->content !!}
            </div>

            <!-- Interactivity Sidebar -->
            <div class="mt-24 pt-12 border-t border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-8" data-aos="fade-up">
                <div class="flex items-center gap-8">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Share This Mission</p>
                    <div class="flex gap-4">
                        <button class="size-11 rounded-full bg-slate-50 dark:bg-slate-800 text-slate-400 flex items-center justify-center hover:bg-primary hover:text-white hover:-translate-y-1 hover:shadow-lg hover:shadow-primary/30 transition-all duration-300">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </button>
                        <button class="size-11 rounded-full bg-slate-50 dark:bg-slate-800 text-slate-400 flex items-center justify-center hover:bg-primary hover:text-white hover:-translate-y-1 hover:shadow-lg hover:shadow-primary/30 transition-all duration-300">
                            <i class="fa-brands fa-twitter text-sm"></i>
                        </button>
                        <button class="size-11 rounded-full bg-slate-50 dark:bg-slate-800 text-slate-400 flex items-center justify-center hover:bg-primary hover:text-white hover:-translate-y-1 hover:shadow-lg hover:shadow-primary/30 transition-all duration-300">
                            <i class="fa-brands fa-linkedin-in text-sm"></i>
                        </button>
                    </div>
                </div>
                <a href="{{ route('news.index') }}" class="text-[10px] font-black text-slate-400 hover:text-primary uppercase tracking-[0.2em] flex items-center gap-3 transition-all">
                    <span class="material-symbols-outlined text-sm">grid_view</span>
                    Back to Archive
                </a>
            </div>
        </div>
    </article>

    <!-- Related Section -->
    @if($related->isNotEmpty())
    <section class="py-24 bg-slate-50 dark:bg-[#1a120b] border-t border-slate-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between mb-16">
                <div>
                    <h3 class="text-3xl font-black text-secondary dark:text-white uppercase tracking-tight">Related <span class="text-primary">Insights</span></h3>
                    <p class="text-slate-400 dark:text-slate-500 font-medium mt-2">More from mission intelligence</p>
                </div>
                <a href="{{ route('news.index', ['category' => $post->category]) }}" class="text-[10px] font-black text-primary uppercase tracking-[0.2em] border-b-2 border-primary/20 hover:border-primary transition-all">View All</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @foreach($related as $rel)
                    <a href="{{ route('news.show', $rel->slug) }}" class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="aspect-video rounded-[2rem] overflow-hidden mb-8 bg-slate-200 dark:bg-slate-800 border-4 border-white dark:border-slate-700 shadow-xl relative">
                            @if($rel->featured_image)
                                <img src="{{ asset($rel->featured_image) }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-600">
                                    <span class="material-symbols-outlined text-4xl">inventory_2</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-secondary/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <p class="text-[9px] font-black text-primary uppercase tracking-[0.2em] mb-3">
                             {{ $rel->published_at ? $rel->published_at->format('M d, Y') : $rel->created_at->format('M d, Y') }}
                        </p>
                        <h4 class="text-xl font-black text-secondary dark:text-white group-hover:text-primary transition-colors line-clamp-2 leading-relaxed uppercase tracking-tight">
                            {{ $rel->title }}
                        </h4>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1000,
                easing: 'ease-out-cubic',
                once: true,
                offset: 100
            });
        });
    </script>
@endpush
