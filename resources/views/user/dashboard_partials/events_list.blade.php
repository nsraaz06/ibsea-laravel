<div class="flex items-center justify-between px-2">
    <h3 class="text-xl font-bold text-navy-accent dark:text-white flex items-center gap-3">
        <span class="material-icons text-primary">calendar_today</span>
        Upcoming Events
    </h3>
</div>

<div class="space-y-6">
    @foreach($upcomingEvents as $event)
        <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-lg flex gap-6 group hover:border-primary transition-all">
            <div class="flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-800 rounded-2xl px-5 py-4 min-w-[80px] border border-slate-100 dark:border-slate-800 group-hover:bg-primary/10 group-hover:border-primary/20 transition-all">
                <span class="text-[10px] font-black text-primary uppercase tracking-widest">{{ $event->event_date->format('M') }}</span>
                <span class="text-2xl font-black text-slate-800 dark:text-white italic tracking-tighter leading-none mt-1">{{ $event->event_date->format('d') }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-md font-bold text-navy-accent dark:text-white truncate italic tracking-tighter leading-none mb-2 group-hover:text-primary transition-colors">{{ $event->name }}</h4>
                <p class="text-[10px] font-bold text-slate-400 flex items-center gap-1.5 uppercase transition-all">
                    <span class="material-icons text-[12px]">place</span>
                    {{ $event->venue }}
                </p>
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">{{ $event->event_date->format('h:i A') }}</span>
                    <a href="{{ route('public.events.show', $event->id) }}" class="bg-slate-900 text-white dark:bg-white dark:text-slate-950 px-5 py-2 rounded-xl text-[9px] font-bold uppercase tracking-widest transition-all hover:bg-primary hover:text-white">Détails</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
