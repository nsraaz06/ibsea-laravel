@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-slate-900 pt-32 pb-20 px-6 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500 rounded-full -mr-48 -mt-48 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500 rounded-full -ml-32 -mb-32 blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto relative z-10 text-center">
        <h1 class="text-4xl md:text-6xl font-black text-white mb-6 uppercase tracking-tight">Events <span class="text-orange-500">Hub</span></h1>
        <p class="text-slate-400 max-w-2xl mx-auto text-lg font-medium leading-relaxed">
            Discover upcoming missions, conclaves, and networking sessions designed to power your entrepreneurial journey.
        </p>
    </div>
</section>

<!-- Events Grid -->
<section class="py-20 px-6 bg-white dark:bg-background-dark">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                <div class="bg-white dark:bg-slate-800 rounded-3xl overflow-hidden border border-slate-100 dark:border-slate-700 shadow-xl hover:shadow-2xl transition-all group">
                    <div class="aspect-video relative overflow-hidden">
                        <img src="{{ $event->featured_image ? (str_starts_with($event->featured_image, 'uploads/') ? asset($event->featured_image) : asset('storage/' . $event->featured_image)) : 'https://images.unsplash.com/photo-1540575861501-7ad05823c93e?q=80&w=2070&auto=format&fit=crop' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $event->name }}">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl text-center shadow-lg">
                            <span class="block text-xs font-black text-slate-400 uppercase tracking-widest">{{ date('M', strtotime($event->event_date)) }}</span>
                            <span class="block text-xl font-black text-slate-900">{{ date('d', strtotime($event->event_date)) }}</span>
                        </div>
                    </div>
                    <div class="p-8 space-y-4">
                        <div class="flex items-center gap-2 text-[10px] font-black text-orange-500 uppercase tracking-[0.2em]">
                            <span class="material-icons text-sm">location_on</span>
                            {{ $event->city }}, {{ $event->state }}
                        </div>
                        <h3 class="text-xl font-black text-slate-800 dark:text-white leading-tight line-clamp-2 uppercase">
                            {{ $event->name }}
                        </h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium line-clamp-3">
                            {{ $event->description }}
                        </p>
                        <div class="pt-4 border-t border-slate-50 dark:border-slate-700 flex items-center justify-between">
                            <div class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">
                                Status: <span class="{{ $event->status == 'Upcoming' ? 'text-green-500' : 'text-slate-500' }}">{{ $event->status }}</span>
                            </div>
                            <a href="{{ route('public.events.show', $event->id) }}" class="inline-flex items-center gap-2 text-orange-500 font-black text-xs uppercase tracking-widest hover:gap-4 transition-all">
                                View Details <span class="material-icons text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center space-y-4">
                    <span class="material-icons text-6xl text-slate-200">event_busy</span>
                    <h3 class="text-2xl font-black text-slate-400 uppercase tracking-widest">No Upcoming Events</h3>
                    <p class="text-slate-500">Stay tuned for future missions and conclaves.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
