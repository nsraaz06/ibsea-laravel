@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.events.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 hover:text-slate-600 transition-all border border-slate-100 shadow-sm">
                <span class="material-icons">arrow_back</span>
            </a>
            <div>
                <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Sales <span class="text-primary">Analytics</span></h2>
                <p class="text-slate-500 font-medium italic">Protocol: {{ $event->name }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-primary/10 text-primary px-5 py-3 rounded-2xl border border-primary/20 flex items-center gap-3">
                <span class="material-icons text-lg">payments</span>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-60 leading-none mb-1">Total Revenue</p>
                    <p class="text-xl font-black leading-none">₹{{ number_format($totalRevenue) }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Analytics Cards -->
    <div class="grid md:grid-cols-3 gap-8 mb-10">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tickets Sold</p>
                <h4 class="text-4xl font-black text-slate-800">{{ $totalTicketsSold }}</h4>
                <p class="text-[10px] text-green-500 font-bold mt-4 uppercase tracking-widest flex items-center gap-1">
                    <span class="material-icons text-xs">trending_up</span>
                    Mission Engagement
                </p>
            </div>
            <span class="material-icons absolute -right-4 -bottom-4 text-8xl opacity-5 text-slate-900">confirmation_number</span>
        </div>

        <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Average Booking</p>
                <h4 class="text-4xl font-black">₹{{ $totalTicketsSold > 0 ? number_format($totalRevenue / $totalTicketsSold) : 0 }}</h4>
                <p class="text-[10px] text-primary font-bold mt-4 uppercase tracking-widest">Revenue Velocity</p>
            </div>
            <span class="material-icons absolute -right-4 -bottom-4 text-8xl opacity-10 text-white">insights</span>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-center">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                    <span class="material-icons">place</span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Environment</p>
                    <p class="text-sm font-bold text-slate-800">{{ $event->venue ?? $event->city }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4 mt-6">
                <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                    <span class="material-icons">calendar_month</span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Mission Date</p>
                    <p class="text-sm font-bold text-slate-800">{{ $event->event_date->format('d M, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Ticket Breakdown -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-black text-slate-800 uppercase tracking-tight">Ticket Distribution</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                        <tr>
                            <th class="px-8 py-5">Ticket Type</th>
                            <th class="px-8 py-5 text-center">Sold</th>
                            <th class="px-8 py-5 text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($event->tickets as $ticket)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="text-xs font-bold text-slate-800">{{ $ticket->ticket_name }}</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase mt-1">₹{{ number_format($ticket->offer_price ?? $ticket->original_price) }} / unit</div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="text-sm font-black text-slate-700">{{ $ticket->bookings_count }}</div>
                                <div class="w-20 h-1.5 bg-slate-100 rounded-full mx-auto mt-2 overflow-hidden">
                                    @php 
                                        $capacity = $ticket->ticket_quantity > 0 ? $ticket->ticket_quantity : 1;
                                        $percent = ($ticket->bookings_count / $capacity) * 100;
                                    @endphp
                                    <div class="h-full bg-primary rounded-full" style="width: {{ min(100, $percent) }}%"></div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-xs font-black text-primary">₹{{ number_format($ticket->bookings_count * ($ticket->offer_price ?? $ticket->original_price)) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Attendees -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-black text-slate-800 uppercase tracking-tight">Recent Enlistments</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                        <tr>
                            <th class="px-8 py-5">Agent</th>
                            <th class="px-8 py-5">Ticket</th>
                            <th class="px-8 py-5 text-right">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($event->bookings->take(10) as $booking)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="text-xs font-bold text-slate-800">{{ $booking->member->name ?? 'Guest' }}</div>
                                <div class="text-[9px] font-medium text-slate-400">{{ $booking->member->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 bg-slate-50 text-slate-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-slate-100">
                                    {{ $booking->ticket->ticket_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-tight">{{ $booking->created_at->diffForHumans() }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-12 text-center text-slate-400 text-xs font-bold uppercase tracking-widest">No bookings logged yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
