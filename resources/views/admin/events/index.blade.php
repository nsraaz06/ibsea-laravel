@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Mission Events Hub</h2>
            <p class="text-slate-500 font-medium">Orchestrate and manage institutional gatherings and conferences.</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 active:scale-95 transition-all flex items-center gap-2">
            <span class="material-icons text-sm">event_available</span>
            Orchestrate New Event
        </a>
    </header>

    <!-- Filter Bar -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8 flex flex-col md:flex-row gap-6">
        <form action="{{ route('admin.events.index') }}" method="GET" class="flex-1 flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or location..." class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
            </div>
            
            <select name="status" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-2xl px-6 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                <option value="">All Statuses</option>
                <option value="Upcoming" {{ request('status') == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <button type="submit" class="bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all hover:bg-black">
                Apply Filters
            </button>
            
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('admin.events.index') }}" class="bg-slate-100 text-slate-500 px-6 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Events Grid/Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);" class="text-xs font-bold text-primary tracking-wide">
                    <tr>
                        <th class="px-8 py-6 uppercase tracking-widest">Mission Initiative</th>
                        <th class="px-8 py-6 uppercase tracking-widest">Location</th>
                        <th class="px-8 py-6 uppercase tracking-widest text-center">Sold</th>
                        <th class="px-8 py-6 uppercase tracking-widest">Mission Clock</th>
                        <th class="px-8 py-6 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-6 text-right uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($events as $event)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-12 rounded-xl overflow-hidden bg-slate-100 border border-slate-100 relative shadow-inner">
                                    @if($event->featured_image)
                                        <img src="{{ str_starts_with($event->featured_image, 'uploads/') ? asset($event->featured_image) : asset('storage/' . $event->featured_image) }}" class="w-full h-full object-cover" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <span class="material-icons text-xl">event</span>
                                        </div>
                                    @endif
                                    @if($event->is_featured)
                                        <div class="absolute top-0 right-0 bg-accent text-white p-0.5 rounded-bl-lg">
                                            <span class="material-icons text-[10px]">star</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-base font-bold text-slate-800">{{ $event->name }}</div>
                                    <div class="text-xs font-bold mt-0.5 text-accent">{{ $event->is_featured ? 'Global Highlight' : 'Standard Mission' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2 text-slate-500">
                                <span class="material-icons text-xs">place</span>
                                <span class="text-xs font-semibold">{{ $event->city ?? $event->venue ?? 'TBD' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-600 px-4 py-2 rounded-xl border border-indigo-100 font-black text-xs">
                                <span class="material-icons text-sm">confirmation_number</span>
                                {{ $event->confirmed_bookings_count }}
                            </div>
                        </td>
                        <td class="px-8 py-6 text-nowrap">
                            <div class="text-xs font-semibold text-slate-600">{{ $event->event_date->format('d M, Y') }}</div>
                            <div class="text-[10px] font-semibold text-slate-400">{{ $event->event_date->format('h:i A') }}</div>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusClasses = [
                                    'Upcoming' => 'bg-green-50 text-green-600',
                                    'Completed' => 'bg-slate-100 text-slate-500',
                                    'Cancelled' => 'bg-red-50 text-red-600'
                                ];
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $statusClasses[$event->status] ?? 'bg-slate-50 text-slate-600' }}">
                                {{ $event->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2 text-right">
                                <a href="{{ route('public.events.show', $event->id) }}" target="_blank" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white transition-all flex items-center justify-center shadow-sm" title="View Public Page">
                                    <span class="material-icons">visibility</span>
                                </a>
                                <a href="{{ route('admin.events.sales', $event) }}" class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 hover:bg-indigo-500 hover:text-white transition-all flex items-center justify-center shadow-sm" title="Sales Analytics">
                                    <span class="material-icons">analytics</span>
                                </a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="w-10 h-10 rounded-xl bg-orange-50 text-accent hover:bg-accent hover:text-white transition-all flex items-center justify-center shadow-sm" title="Edit Event">
                                    <span class="material-icons">edit</span>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Archive this event records?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center shadow-sm" title="Delete Event">
                                        <span class="material-icons">delete_outline</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                                <span class="material-icons text-4xl">event_busy</span>
                            </div>
                            <h3 class="text-lg font-black text-slate-400 uppercase tracking-widest">No Events Orchestrated</h3>
                            <p class="text-slate-400 text-sm">Initiate your first mission event to engage with the alliance.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($events->hasPages())
        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
            {{ $events->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
