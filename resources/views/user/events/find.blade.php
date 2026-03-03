@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <main class="flex-1 overflow-y-auto p-4 md:p-12">
        <div class="max-w-6xl mx-auto space-y-12">
            <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 text-left">
                <div>
                    <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">
                        <span class="material-icons text-xs">explore</span>
                        Opportunity Radar
                    </div>
                    <h1 class="text-4xl font-black text-slate-800 dark:text-white uppercase tracking-tight">Event Board</h1>
                    <p class="text-slate-500 font-medium mt-2">Discover upcoming summits, training and global networking events.</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Global Status:</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 dark:bg-green-900/20 text-green-600 rounded-full text-[9px] font-black uppercase tracking-widest">
                        <span class="w-1 h-1 rounded-full bg-current animate-pulse"></span>
                        Live Ops
                    </span>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($events as $event)
                    <div class="group bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 overflow-hidden shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col h-full">
                        <!-- Event Image -->
                        <div class="relative h-48 overflow-hidden">
                            @php
                                $imagePath = $event->featured_image;
                                $finalUrl = 'https://images.unsplash.com/photo-1540575861501-7ad05823c93e?q=80&w=2070&auto=format&fit=crop';
                                if ($imagePath) {
                                    if (str_starts_with($imagePath, 'uploads/') || str_starts_with($imagePath, '/uploads/')) {
                                        $finalUrl = asset($imagePath);
                                    } elseif (str_starts_with($imagePath, 'events/')) {
                                        $finalUrl = asset('storage/' . $imagePath);
                                    } else {
                                        $finalUrl = asset('uploads/events/' . $imagePath);
                                    }
                                }
                            @endphp
                            <img src="{{ $finalUrl }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-4 left-4 flex gap-2">
                                <span class="px-3 py-1 bg-white/90 dark:bg-slate-900/90 backdrop-blur rounded-lg text-[9px] font-black text-primary uppercase tracking-widest shadow-sm">
                                    {{ $event->category ?? 'General' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-8 flex-1 flex flex-col">
                            <div class="flex items-center gap-2 text-[10px] font-black text-primary uppercase tracking-widest mb-3">
                                <span class="material-icons text-xs">calendar_today</span>
                                {{ $event->event_date->format('d M, Y') }}
                            </div>
                            
                            <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tight mb-4 group-hover:text-primary transition-colors line-clamp-2">{{ $event->title }}</h3>
                            
                            <div class="space-y-3 mb-8 flex-1 text-left">
                                <div class="flex items-start gap-2 text-slate-500 dark:text-slate-400">
                                    <span class="material-icons text-sm mt-0.5">place</span>
                                    <span class="text-xs font-bold leading-relaxed line-clamp-2 text-left">{{ $event->venue }}</span>
                                </div>
                            </div>

                            <a href="{{ route('public.events.show', $event->id) }}" class="w-full bg-slate-50 dark:bg-slate-800 hover:bg-primary hover:text-white text-slate-800 dark:text-white px-6 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all text-center flex items-center justify-center gap-2 group/btn">
                                Intelligence Report
                                <span class="material-icons text-sm group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 border-dashed">
                        <span class="material-icons text-6xl text-slate-200 dark:text-slate-800 mb-4">radar</span>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">No active events detected. Check back later.</p>
                    </div>
                @endforelse
            </div>

            @if($events->hasPages())
                <div class="pt-8">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
