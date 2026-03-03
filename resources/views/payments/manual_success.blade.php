@extends('layouts.app')

@section('content')
<style>
    .shadow-premium {
        box-shadow: 0 10px 30px -10px rgba(0, 74, 149, 0.15);
    }
</style>
<div class="min-h-screen flex items-center justify-center p-6 bg-slate-50">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-[2.5rem] shadow-premium overflow-hidden border border-slate-100 p-10 md:p-16 text-center">
            <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-8 border border-green-100">
                <span class="material-icons text-green-500 text-5xl">check_circle</span>
            </div>
            
            <h1 class="text-3xl font-black text-[#004a95] tracking-tight mb-4">Request Received</h1>
            <p class="text-slate-500 font-bold uppercase tracking-widest text-[10px] mb-10">Manual Access Protocol Initiated</p>

            <div class="bg-slate-50 rounded-3xl p-8 mb-10 text-left space-y-4 border border-slate-100">
                <div class="flex justify-between items-center text-xs">
                    <span class="font-black text-slate-400 uppercase tracking-widest">Inquiry Item</span>
                    <span class="font-black text-slate-800 uppercase italic">{{ $item_name }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="font-black text-slate-400 uppercase tracking-widest">Order ID</span>
                    <span class="font-bold text-slate-600 tracking-wider">{{ $order_id }}</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="font-black text-slate-400 uppercase tracking-widest">Team Contact</span>
                    <span class="font-bold text-slate-600">{{ $mobile }}</span>
                </div>
            </div>

            <div class="mb-10">
                <p class="text-sm font-bold text-slate-600 leading-relaxed italic">
                    "Our Institutional Team has logged your interest. We will connect with you shortly via WhatsApp/Mobile to finalize your access."
                </p>
            </div>

            <div class="space-y-4">
                <a href="{{ route('home') }}" class="block w-full bg-[#004a95] text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-lg hover:bg-orange-600 hover:-translate-y-1 active:scale-95 transition-all">
                    Return to Mission Hub
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
