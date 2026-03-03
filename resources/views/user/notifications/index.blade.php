@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <main class="flex-1 overflow-y-auto p-4 md:p-12">
        <div class="max-w-4xl mx-auto space-y-12">
            <header class="flex justify-between items-end">
                <div>
                    <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">
                        <span class="material-icons text-xs">notifications_active</span>
                        Intelligence Feed
                    </div>
                    <h1 class="text-4xl font-black text-slate-800 dark:text-white uppercase">Notifications</h1>
                </div>
                @if($notifications->where('is_read', false)->count() > 0)
                    <form action="{{ route('user.notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline flex items-center gap-2">
                            <span class="material-icons text-sm">done_all</span>
                            Mark all as acknowledged
                        </button>
                    </form>
                @endif
            </header>

            <div class="space-y-6">
                @forelse($notifications as $notify)
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border {{ $notify->is_read ? 'border-slate-100 dark:border-slate-800 opacity-75' : 'border-primary shadow-xl shadow-primary/5' }} transition-all">
                        <div class="flex flex-col md:flex-row justify-between gap-6">
                            <div class="space-y-4 flex-grow">
                                <div class="flex items-center gap-4">
                                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-[9px] font-black text-slate-500 uppercase tracking-widest rounded-md">
                                        {{ $notify->type }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                        {{ $notify->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white">{{ $notify->title }}</h3>
                                <div class="text-slate-500 dark:text-slate-400 leading-relaxed">
                                    {!! $notify->message !!}
                                </div>
                            </div>
                            
                            @if(!$notify->is_read)
                                <div class="shrink-0">
                                    <form action="{{ route('user.notifications.read', $notify->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-primary hover:bg-orange-600 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-primary/20 active:scale-95">
                                            Acknowledge
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-slate-900 py-20 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 text-center">
                        <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                            <span class="material-icons text-4xl">notifications_off</span>
                        </div>
                        <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">No institutional dispatches at this time</p>
                    </div>
                @endforelse

                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
