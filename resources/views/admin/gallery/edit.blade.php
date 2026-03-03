@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="mb-10 flex justify-between items-end">
        <div>
            <a href="{{ route('admin.gallery.index') }}" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 hover:text-primary transition-all mb-4">
                <span class="material-icons text-xs">arrow_back</span>
                Return to Gallery Hub
            </a>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Refine Mission Folder</h2>
            <p class="text-slate-500 font-semibold italic">Managing assets for: <span class="text-slate-800">"{{ $title }}"</span></p>
        </div>
        <div class="bg-primary/5 px-6 py-3 rounded-2xl border border-primary/10">
            <p class="text-[10px] font-black text-primary uppercase tracking-widest">{{ $images->count() }} Institutional Assets</p>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Sidebar: Basic Info -->
        <div class="lg:col-span-1">
            <div class="bg-white p-10 rounded-[3rem] shadow-premium border-t-8 border-primary sticky top-10">
                <form action="{{ route('admin.gallery.update', $current->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Folder Designation (Title)</label>
                        <input type="text" name="title" value="{{ $title }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                        <p class="text-[9px] text-slate-400 font-bold italic px-1">Note: Changing this updates ALL images in this folder.</p>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Asset Category</label>
                        <select name="category" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                            @foreach(['Event Highlights', 'Institutional Operations', 'Global Alliance', 'Press & Media', 'Strategic Partner - MOU', 'Strategic Partner - National', 'Strategic Partner - International'] as $cat)
                                <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Add More Visuals</label>
                        <div class="relative group">
                            <input type="file" name="images[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="bg-slate-50 border-2 border-dashed border-slate-100 rounded-2xl p-8 text-center group-hover:bg-primary/5 group-hover:border-primary/20 transition-all">
                                <span class="material-icons text-3xl text-slate-300 group-hover:text-primary mb-2">add_a_photo</span>
                                <p class="text-slate-400 font-bold uppercase text-[9px] tracking-widest">Select extra images</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all flex items-center justify-center gap-4 mt-6">
                        Sync Mission Folder <span class="material-icons text-sm">sync</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Area: Content Pruning -->
        <div class="lg:col-span-2 space-y-8">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                @foreach($images as $img)
                <div class="relative group bg-white p-3 rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl transition-all">
                    <div class="aspect-square rounded-2xl overflow-hidden bg-slate-50">
                        <img src="{{ asset($img->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="absolute inset-0 bg-red-500/80 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center p-6 text-center">
                        <p class="text-white font-black text-[9px] uppercase tracking-widest mb-4">Prune this asset?</p>
                        <form action="{{ route('admin.gallery.remove-image', $img->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-12 h-12 bg-white text-red-500 rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all">
                                <span class="material-icons">delete_forever</span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            @if($images->isEmpty())
                <div class="bg-white p-20 rounded-[3rem] text-center border-2 border-dashed border-slate-100">
                    <span class="material-icons text-5xl text-slate-200 mb-4">folder_off</span>
                    <p class="text-slate-400 font-bold uppercase tracking-widest">This Mission folder has no assets.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
