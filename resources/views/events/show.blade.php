@extends('layouts.app')

@section('content')
<style>
    .hero-gradient { 
        background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.95)), url('{{ $event->featured_image ? (str_starts_with($event->featured_image, 'uploads/') ? asset($event->featured_image) : asset('storage/' . $event->featured_image)) : asset('images/default-event.jpg') }}'); 
        background-size: cover; 
        background-position: center; 
    }
    .ticket-card { border: 1px solid rgba(0,0,0,0.05); transition: all 0.4s ease; }
    .ticket-card:hover { border-color: #f6790b; transform: translateY(-5px); box-shadow: 0 20px 40px -10px rgba(246,121,11,0.1); }
</style>

<!-- Event Hero -->
<section class="hero-gradient pt-48 pb-32 px-6 text-white text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500 rounded-full -mr-48 -mt-48 blur-3xl"></div>
    </div>
    <div class="max-w-4xl mx-auto relative z-10">
        <div class="inline-flex items-center gap-2 bg-orange-500 text-[10px] font-bold uppercase tracking-[0.2em] px-4 py-2 rounded-full mb-8 shadow-lg">
            <span class="material-icons text-sm">stars</span> IBSEA Global Mission
        </div>
        <h1 class="text-4xl md:text-7xl font-bold mb-8 leading-tight tracking-tight uppercase" data-aos="fade-up">
            {{ $event->name }}
        </h1>
        <div class="flex flex-wrap justify-center gap-8 text-slate-300 font-bold" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center gap-3"><span class="material-icons text-orange-500">calendar_today</span> {{ $event->event_date->format('D, M d, Y') }}</div>
            <div class="flex items-center gap-3"><span class="material-icons text-orange-500">location_on</span> {{ $event->venue }}, {{ $event->city }}</div>
            <div class="flex items-center gap-3"><span class="material-icons text-orange-500">business</span> Organized by IBSEA</div>
        </div>
    </div>
</section>

<main class="py-20 px-6 bg-[#f8f7f5] dark:bg-slate-950">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-3 gap-16">
            
            <!-- Left: Description -->
            <div class="lg:col-span-2 space-y-12" data-aos="fade-right">
                <div class="bg-white dark:bg-slate-900 p-10 md:p-16 rounded-[2.5rem] shadow-premium border border-slate-100 dark:border-slate-800 overflow-hidden">
                    @if($event->featured_image)
                        <div class="mb-10 -mx-10 md:-mx-16 -mt-10 md:-mt-16 overflow-hidden aspect-video">
                            <img src="{{ $event->featured_image ? (str_starts_with($event->featured_image, 'uploads/') ? asset($event->featured_image) : asset('storage/' . $event->featured_image)) : asset('images/default-event.jpg') }}" 
                                 alt="{{ $event->name }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                        </div>
                    @endif

                    <h2 class="text-3xl font-black text-slate-800 dark:text-white mb-8 flex items-center gap-4 uppercase tracking-tight">
                        <span class="w-2 h-10 bg-orange-500 rounded-full"></span>
                        Event Mission & Overview
                    </h2>
                    <div class="prose prose-slate dark:prose-invert max-w-none text-slate-500 dark:text-slate-400 font-medium leading-[2] text-lg">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                    
                    <div class="mt-12 pt-12 border-t border-slate-50 dark:border-slate-800 flex flex-wrap gap-4">
                        @if($event->pdf_link)
                            <a href="{{ $event->pdf_link }}" target="_blank" class="bg-slate-900 text-white font-black px-10 py-5 rounded-2xl flex items-center gap-3 hover:bg-orange-500 transition-all shadow-xl text-xs uppercase tracking-widest">
                                <span class="material-icons">download</span> Download Program PDF
                            </a>
                        @endif
                        <button class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-black px-10 py-5 rounded-2xl flex items-center gap-3 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all text-xs uppercase tracking-widest">
                            <span class="material-icons">share</span> Invite Others
                        </button>
                    </div>
                </div>

                <!-- Strategic Focus -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-slate-900 p-10 rounded-[2.5rem] text-white shadow-premium" data-aos="zoom-in">
                        <span class="material-icons text-orange-500 text-5xl mb-6">rocket_launch</span>
                        <h4 class="text-xl font-black mb-4 uppercase tracking-tight">Strategic Advocacy</h4>
                        <p class="text-slate-400 text-sm font-medium leading-relaxed">Providing a platform for MSMEs and corporate entities to align with the national vision of 2047.</p>
                    </div>
                    <div class="bg-orange-500 p-10 rounded-[2.5rem] text-white shadow-premium" data-aos="zoom-in" data-aos-delay="100">
                        <span class="material-icons text-white text-5xl mb-6">groups</span>
                        <h4 class="text-xl font-black mb-4 uppercase tracking-tight">Global Networking</h4>
                        <p class="text-white/80 text-sm font-medium leading-relaxed">Direct access to industry vets, investors, and diplomatic heads in a closed-door environment.</p>
                    </div>
                </div>
            </div>

            <!-- Right: Ticketing Hub -->
            <div id="tickets" class="lg:col-span-1" data-aos="fade-left">
                <div class="sticky top-24 space-y-8">
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white flex items-center gap-3 px-4 uppercase tracking-tight">
                        <span class="material-icons text-orange-500">confirmation_number</span>
                        Ticketing Hub
                    </h3>

                    @if($event->tickets->isEmpty())
                        <div class="bg-white dark:bg-slate-900 p-10 rounded-[2.5rem] text-center shadow-premium border border-slate-100 dark:border-slate-800">
                            <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <span class="material-icons text-slate-300">event_busy</span>
                            </div>
                            <p class="text-slate-400 font-black uppercase tracking-widest text-[10px]">Registration Opening Soon</p>
                        </div>
                    @else
                        @foreach($event->tickets as $ticket)
                            @php 
                                $today = now();
                                $has_offer = (!empty($ticket->offer_price) && $ticket->offer_price > 0);
                                $is_offer_valid = $has_offer && (empty($ticket->last_date_to_buy) || $today->lte($ticket->last_date_to_buy));
                                $display_price = $is_offer_valid ? $ticket->offer_price : $ticket->original_price;
                                $is_sold_out = ($ticket->ticket_quantity !== null && $ticket->ticket_quantity <= 0);
                            @endphp
                            <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-premium ticket-card group relative overflow-hidden {{ $is_sold_out ? 'opacity-60 grayscale' : '' }}">
                                @if($is_sold_out)
                                    <div class="absolute inset-0 bg-white/40 dark:bg-slate-900/40 z-10 flex items-center justify-center">
                                        <span class="bg-red-500 text-white font-black px-6 py-2 rounded-xl rotate-12 uppercase tracking-widest shadow-2xl">Sold Out</span>
                                    </div>
                                @endif
                                
                                @if($is_offer_valid && !$is_sold_out)
                                    <div class="absolute -right-12 top-6 bg-green-500 text-white text-[9px] font-black px-12 py-1 uppercase tracking-widest rotate-45 shadow-sm">Early Bird</div>
                                @endif

                                <div class="flex justify-between items-start mb-6">
                                    <div>
                                        <h4 class="text-lg font-black text-slate-800 dark:text-white mb-1 uppercase tracking-tight">{{ $ticket->ticket_name }}</h4>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                            @if($ticket->ticket_quantity > 0)
                                                <span class="text-orange-500">Only {{ $ticket->ticket_quantity }} slots left</span>
                                            @else
                                                Official Entry Pass
                                            @endif
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-black text-slate-900 dark:text-white leading-none">₹{{ number_format($display_price) }}</p>
                                        @if($is_offer_valid)
                                            <p class="text-[10px] text-slate-400 font-bold line-through mt-1">₹{{ number_format($ticket->original_price) }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="space-y-4 mb-8">
                                    @php $benefits = explode(',', $ticket->benefits); @endphp
                                    @foreach($benefits as $benefit) 
                                        @if(trim($benefit))
                                            <div class="flex items-start gap-3">
                                                <span class="material-icons text-green-500 text-sm mt-0.5">check_circle</span>
                                                <span class="text-sm font-bold text-slate-600 dark:text-slate-400">{{ trim($benefit) }}</span>
                                            </div>
                                        @endif 
                                    @endforeach
                                </div>

                                @if($is_offer_valid)
                                    <div class="bg-orange-50 dark:bg-orange-950/30 p-4 rounded-2xl mb-6 flex items-center gap-3 text-orange-600 dark:text-orange-400">
                                        <span class="material-icons text-sm">timer</span>
                                        <p class="text-[9px] font-black uppercase tracking-widest">
                                            @if($ticket->last_date_to_buy)
                                                Offer ends {{ $ticket->last_date_to_buy->format('M d') }}
                                            @else
                                                Limited Time Offer
                                            @endif
                                        </p>
                                    </div>
                                @endif

                                @if(!$is_sold_out)
                                    <form action="{{ route('payment.checkout') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="Event">
                                        <input type="hidden" name="item_id" value="{{ $ticket->id }}">
                                        <input type="hidden" name="amount" value="{{ $display_price }}">

                                        <button type="submit" class="w-full text-center bg-slate-900 text-white font-black py-5 rounded-2xl shadow-premium hover:bg-orange-500 transition-all active:scale-95 text-xs uppercase tracking-[0.2em]">
                                            Purchase Ticket
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full text-center bg-slate-100 dark:bg-slate-800 text-slate-400 font-black py-5 rounded-2xl cursor-not-allowed text-xs uppercase tracking-[0.2em]">
                                        Sold Out
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    @endif

                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] shadow-premium border border-slate-100 dark:border-slate-800">
                        <h4 class="text-sm font-black text-slate-800 dark:text-white mb-4 uppercase tracking-widest">Support & Inquiries</h4>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 text-slate-400 hover:text-orange-500 transition-all cursor-pointer">
                                <span class="material-icons text-lg">phone</span>
                                <span class="text-xs font-bold font-mono">+91-7651876071</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-400 hover:text-orange-500 transition-all cursor-pointer">
                                <span class="material-icons text-lg">email</span>
                                <span class="text-xs font-bold font-mono">events@ibsea.org</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
