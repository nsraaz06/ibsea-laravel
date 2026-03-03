@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="mb-10">
        <a href="{{ route('admin.gallery.index') }}" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 hover:text-primary transition-all mb-4">
            <span class="material-icons text-xs">arrow_back</span>
            Return to Gallery
        </a>
        <h2 class="text-3xl font-bold text-primary tracking-tight">Modify Mission Asset</h2>
        <p class="text-slate-500 font-semibold italic">Refine metadata or replace institutional visual intelligence.</p>
    </header>

    <div class="max-w-4xl bg-white p-10 md:p-16 rounded-[3rem] shadow-premium border-t-8 border-amber-500 relative overflow-hidden">
        <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Asset Designation (Title)</label>
                    <input type="text" name="title" value="{{ $gallery->title }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all">
                </div>

                <div class="space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Media Category</label>
                    <select name="category" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all">
                        @foreach(['Event Highlights', 'Institutional Operations', 'Global Alliance', 'Press & Media', 'Strategic Partner - MOU', 'Strategic Partner - National', 'Strategic Partner - International'] as $cat)
                            <option value="{{ $cat }}" {{ $gallery->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Associated Mission / Event</label>
                    <select name="event_id" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all">
                        <option value="">Global Operation (No Specific Event)</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ $gallery->event_id == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Institutional Visual (Replace current)</label>
                    <div class="relative group">
                        <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] p-12 text-center group-hover:bg-amber-500/5 group-hover:border-amber-500/30 transition-all">
                            <span class="material-icons text-5xl text-slate-300 group-hover:text-amber-500 transition-all mb-4">refresh</span>
                            <p class="text-slate-500 font-bold uppercase text-[11px] tracking-widest">Select new asset to replace</p>
                            <img src="{{ asset($gallery->image_path) }}" class="w-32 h-20 object-cover mx-auto mt-4 rounded-xl border-4 border-white shadow-lg">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-10 flex justify-end">
                <button type="submit" class="bg-amber-500 text-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-4">
                    Update Asset <span class="material-icons text-sm">published_with_changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
