@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="pt-32 pb-20 bg-secondary relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6 uppercase tracking-tight">Mission Updates & News</h1>
            <p class="text-xl text-slate-300 max-w-2xl mx-auto font-medium">Stay informed about IBSEA's progress towards Viksit Bharat @2047 and the growth of India's entrepreneurial ecosystem.</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-24 bg-white dark:bg-[#1a120b]">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Category Filters -->
            <div class="flex flex-wrap justify-center gap-4 mb-20" data-aos="fade-up">
                @foreach($categories as $cat)
                    <a href="{{ route('news.index', ['category' => $cat]) }}" 
                       class="px-8 py-3 rounded-full font-black text-[11px] uppercase tracking-[0.15em] transition-all {{ $category === $cat ? 'bg-primary text-white shadow-xl shadow-primary/30 scale-105' : 'bg-slate-50 dark:bg-slate-800 text-slate-500 hover:bg-slate-100 hover:text-primary' }}">
                       {{ $cat }}
                    </a>
                @endforeach
            </div>

            @if($posts->isEmpty())
                <div class="text-center py-32 bg-slate-50 dark:bg-slate-800/50 rounded-[3rem] border-2 border-dashed border-slate-100 dark:border-slate-700" data-aos="zoom-in">
                    <span class="material-symbols-outlined text-8xl text-slate-200 dark:text-slate-700 mb-6">article</span>
                    <h3 class="text-2xl font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">No updates found</h3>
                    <p class="text-slate-400 dark:text-slate-600 mt-2 font-medium">Check back soon for the latest mission reports.</p>
                </div>
            @else
                <!-- Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach($posts as $post)
                        <article class="bg-white dark:bg-slate-800 rounded-[2.5rem] overflow-hidden shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group flex flex-col border border-slate-100 dark:border-slate-700" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="h-64 relative overflow-hidden">
                                @if($post->featured_image)
                                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                                @else
                                    <div class="w-full h-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-300 dark:text-slate-600">
                                        <span class="material-symbols-outlined text-6xl">inventory_2</span>
                                    </div>
                                @endif
                                <div class="absolute top-6 left-6">
                                    <span class="bg-primary text-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-lg">
                                        {{ $post->category }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-10 flex-1 flex flex-col">
                                <div class="flex items-center gap-2 text-slate-400 dark:text-slate-500 text-[10px] font-black uppercase tracking-[0.15em] mb-4">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                                </div>
                                <h3 class="text-2xl font-black text-secondary dark:text-white mb-4 line-clamp-2 leading-[1.4] group-hover:text-primary transition-colors uppercase tracking-tight">
                                    {{ $post->title }}
                                </h3>
                                <div class="text-slate-500 dark:text-slate-400 text-sm line-clamp-3 mb-8 leading-relaxed font-medium">
                                    {!! strip_tags($post->content) !!}
                                </div>
                                <div class="mt-auto pt-6 border-t border-slate-50 dark:border-slate-700/50">
                                    <a href="{{ route('news.show', $post->slug) }}" class="inline-flex items-center gap-3 text-primary font-black hover:gap-5 transition-all uppercase tracking-[0.2em] text-[11px]">
                                        Read Full Briefing
                                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-20 flex justify-center">
                    {{ $posts->appends(['category' => $category])->links() }}
                </div>
            @endif

        </div>
    </section>
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
