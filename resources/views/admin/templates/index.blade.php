@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Design Templates</h1>
            <p class="text-slate-500 text-sm">Manage customizable layouts for Certificates, ID Cards, and Tickets.</p>
        </div>
        <a href="{{ route('admin.design-templates.create') }}" 
           class="flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-primary/20 hover:scale-105 transition-all">
            <span class="material-icons text-sm">add</span>
            New Template
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-xl">
            <p class="text-emerald-700 text-sm font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $template)
        <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-xl shadow-slate-200/50 flex flex-col group">
            <div class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center p-4">
                @if($template->background_path)
                    <img src="{{ $template->background_url }}" class="w-full h-full object-contain opacity-80 group-hover:opacity-100 transition-opacity">
                @else
                    <div class="text-slate-300 flex flex-col items-center">
                        <span class="material-icons text-5xl">image</span>
                        <span class="text-[10px] font-bold uppercase mt-2">No Background</span>
                    </div>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-primary border border-primary/10">
                        {{ str_replace('_', ' ', $template->type) }}
                    </span>
                </div>
            </div>
            
            <div class="p-6 flex-1 flex flex-col">
                <h3 class="font-black text-slate-800 uppercase tracking-tight mb-4">{{ $template->name }}</h3>
                
                <div class="mt-auto flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.design-templates.builder', $template->id) }}" 
                           class="bg-primary/10 text-primary p-2 rounded-xl hover:bg-primary hover:text-white transition-all flex items-center gap-2 px-4 text-xs font-black uppercase tracking-widest">
                            <span class="material-icons text-sm">palette</span>
                            Edit Design
                        </a>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.design-templates.edit', $template->id) }}" 
                           class="p-2 text-slate-400 hover:text-primary transition-all">
                            <span class="material-icons">settings</span>
                        </a>
                        <form action="{{ route('admin.design-templates.destroy', $template->id) }}" method="POST" onsubmit="return confirm('Archive this template?')">
                            @csrf @method('DELETE')
                            <button class="p-2 text-slate-400 hover:text-red-500 transition-all">
                                <span class="material-icons">delete_outline</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-center">
            <span class="material-icons text-slate-300 text-6xl mb-4">architecture</span>
            <h3 class="font-bold text-slate-500">No design templates yet</h3>
            <p class="text-slate-400 text-xs mt-1">Start by clicking the "New Template" button above.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
