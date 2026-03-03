@extends('layouts.app')

@section('content')
<main class="py-32 px-6 bg-[#f8f7f5] dark:bg-slate-950 min-h-screen flex items-center justify-center">
    <div class="max-w-xl w-full">
        <div class="text-center mb-12">
            <div class="w-20 h-20 bg-orange-500 rounded-3xl mx-auto flex items-center justify-center mb-6 shadow-xl shadow-orange-500/20">
                <span class="material-icons text-white text-4xl">verified_user</span>
            </div>
            <h1 class="text-4xl font-black text-slate-800 dark:text-white uppercase tracking-tight mb-4">Ticket Verification</h1>
            <p class="text-slate-500 font-medium">Scan the QR code on your ticket or manually enter your official Ticket Number to verify authenticity.</p>
        </div>

        @if(isset($error) && $error)
            <div class="bg-red-50 text-red-500 border border-red-200 p-6 rounded-2xl mb-8 flex items-start gap-4">
                <span class="material-icons mt-1">error_outline</span>
                <div>
                    <h4 class="font-black uppercase tracking-widest text-sm mb-1">Verification Failed</h4>
                    <p class="text-sm font-medium">{{ $error }}</p>
                </div>
            </div>
        @endif

        @if(isset($result) && $result)
            <div class="bg-white dark:bg-slate-900 border-2 border-green-500 p-8 rounded-[2rem] shadow-premium mb-8 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-green-500/5"></div>
                
                <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 relative z-10">
                    <span class="material-icons text-3xl">check_circle</span>
                </div>
                
                <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tight mb-2 relative z-10">Official Verified Ticket</h2>
                <p class="text-green-600 font-bold uppercase tracking-widest text-[10px] mb-8 relative z-10">Valid Registration under IBSEA Mission</p>

                <div class="space-y-4 text-left relative z-10 bg-slate-50 dark:bg-slate-800 p-6 rounded-2xl">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Attendee Name</p>
                        <p class="font-black text-slate-800 dark:text-white">{{ $result->member->name ?? 'Guest' }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Event Name</p>
                        <p class="font-bold text-slate-600 dark:text-slate-300">{{ $result->event->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Ticket Class</p>
                        <p class="font-bold text-slate-600 dark:text-slate-300">{{ $result->ticket->ticket_name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="{{ route('public.verify-ticket') }}" class="text-slate-500 hover:text-orange-500 font-bold text-sm transition-all">Verify Another Ticket</a>
            </div>
        @else
            <div class="bg-white dark:bg-slate-900 p-10 rounded-[2.5rem] shadow-premium border border-slate-100 dark:border-slate-800">
                <form action="{{ route('public.verify-ticket') }}" method="GET" class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Ticket Number</label>
                        <input type="text" name="ticket_no" placeholder="e.g. TCKT-2026-000001-ABCD" class="w-full bg-slate-50 border-0 rounded-2xl px-6 py-4 outline-none focus:ring-2 focus:ring-orange-500 font-mono text-center uppercase text-slate-700 font-bold placeholder:font-normal placeholder:lowercase placeholder:text-slate-300" required>
                    </div>
                    <button type="submit" class="w-full bg-slate-900 hover:bg-orange-500 text-white font-black py-5 rounded-2xl uppercase tracking-[0.2em] text-xs transition-all shadow-lg hover:shadow-orange-500/25">
                        Validate Now
                    </button>
                </form>
            </div>
        @endif
    </div>
</main>
@endsection
