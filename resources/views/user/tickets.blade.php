@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <main class="flex-1 overflow-y-auto p-4 md:p-12">
        <div class="max-w-6xl mx-auto space-y-12">
            <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">
                        <span class="material-icons text-xs">confirmation_number</span>
                        Event Command Center
                    </div>
                    <h1 class="text-4xl font-black text-slate-800 dark:text-white uppercase tracking-tight">Event Passes</h1>
                    <p class="text-slate-500 font-medium mt-2">Manage your active registrations and download unique QR entry passes.</p>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($bookings as $booking)
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl group hover:border-primary transition-all relative overflow-hidden">
                        <!-- Unique Token Display -->
                        @php
                            $ticketNo = app(\App\Services\DocumentService::class)->getUniqueDocumentNo(auth('member')->user(), 'ticket', $booking->id);
                        @endphp
                        <div class="absolute top-6 right-6">
                            <span class="text-[9px] font-black text-slate-400 bg-slate-50 dark:bg-slate-800 px-3 py-1 rounded-full uppercase tracking-widest">
                                {{ $ticketNo }}
                            </span>
                        </div>

                        <div class="flex flex-col h-full">
                            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-8 group-hover:scale-110 transition-transform">
                                <span class="material-icons text-3xl">event_available</span>
                            </div>

                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                {{ $booking->event->event_date->format('d M, Y') }} @ {{ $booking->event->event_time }}
                            </p>
                            
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2 leading-tight">
                                {{ $booking->event->title }}
                            </h3>
                            
                            <p class="text-sm text-slate-500 font-medium mb-8 flex-1">
                                <span class="material-icons text-xs align-middle">location_on</span>
                                {{ $booking->event->venue }}
                            </p>

                            <div class="pt-6 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Ticket Type</span>
                                    <span class="text-xs font-bold text-primary">{{ $booking->ticket->ticket_name }}</span>
                                </div>
                                <a href="{{ route('user.assets.preview', ['type' => 'ticket', 'id' => $booking->id]) }}" class="bg-slate-900 dark:bg-white text-white dark:text-slate-950 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary hover:text-white transition-all flex items-center gap-2">
                                    Download
                                    <span class="material-icons text-sm">qr_code_2</span>
                                </a>
                            </div>
                        </div>

                        <!-- Abstract Decor -->
                        <div class="absolute -right-8 -bottom-8 opacity-[0.03] group-hover:opacity-[0.08] transition-all">
                            <span class="material-icons text-9xl">confirmation_number</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center bg-white dark:bg-slate-900 rounded-[3rem] border-2 border-dashed border-slate-100 dark:border-slate-800">
                        <div class="flex flex-col items-center gap-6">
                            <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center text-slate-200">
                                <span class="material-icons text-5xl">local_activity</span>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-slate-800 dark:text-white uppercase italic tracking-tighter">No active passes</h4>
                                <p class="text-slate-500 font-bold uppercase tracking-widest mt-2 text-xs">You haven't booked any events yet.</p>
                                <a href="{{ route('events') }}" class="inline-block mt-8 bg-primary text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-105 transition-all">Explore Events</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection
