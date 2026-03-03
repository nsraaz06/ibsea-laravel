@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="mb-10">
        <a href="{{ route('admin.gallery.index') }}" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 hover:text-primary transition-all mb-4">
            <span class="material-icons text-xs">arrow_back</span>
            Return to Gallery
        </a>
        <h2 class="text-3xl font-bold text-primary tracking-tight">Archive Mission Visuals</h2>
        <p class="text-slate-500 font-semibold italic">Upload high-resolution media from institutional operations and global events.</p>
    </header>

    <div class="max-w-4xl bg-white p-10 md:p-16 rounded-[3rem] shadow-premium border-t-8 border-primary relative overflow-hidden">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Asset Designation (Title)</label>
                    <input type="text" name="title" placeholder="e.g. IBSEA Global Summit - Opening Ceremony" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                </div>

                <div class="space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Media Category</label>
                    <select name="category" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                        <option value="Event Highlights">Event Highlights</option>
                        <option value="Institutional Operations">Institutional Operations</option>
                        <option value="Global Alliance">Global Alliance</option>
                        <option value="Press & Media">Press & Media</option>
                        <option value="Strategic Partner - MOU">Strategic Partner - MOU</option>
                        <option value="Strategic Partner - National">Strategic Partner - National</option>
                        <option value="Strategic Partner - International">Strategic Partner - International</option>
                    </select>
                </div>

                <div class="md:col-span-2 space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Associated Mission / Event</label>
                    <select name="event_id" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                        <option value="">Global Operation (No Specific Event)</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Visual Intelligence (Images)</label>
                    <div class="relative group">
                        <input type="file" name="images[]" multiple required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] p-12 text-center group-hover:bg-primary/5 group-hover:border-primary/30 transition-all">
                            <span class="material-icons text-5xl text-slate-300 group-hover:text-primary transition-all mb-4">add_a_photo</span>
                            <p class="text-slate-500 font-bold uppercase text-[11px] tracking-widest">Select Images or drag & drop</p>
                            <p class="text-[10px] text-slate-400 font-bold mt-2">Multiple Selection Supported. 200x100 for partners.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-10 flex justify-end">
                <button type="submit" class="bg-primary text-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-4">
                    Archive Media <span class="material-icons text-sm">auto_awesome</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
