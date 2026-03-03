@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Institutional Chapters</h2>
            <p class="text-slate-500 font-semibold italic">Manage regional and thematic mission clusters.</p>
        </div>
        <button class="bg-accent text-white px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-primary shadow-lg shadow-accent/20 transition-all flex items-center gap-3">
            <span class="material-icons text-sm">add_circle</span> Establish New Chapter
        </button>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($chapters as $chapter)
        <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-100 hover:border-accent/30 transition-all group">
            <div class="flex items-start justify-between mb-6">
                <div class="w-14 h-14 bg-blue-50 text-primary rounded-2xl flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all">
                    <span class="material-icons text-3xl">map</span>
                </div>
                <span class="px-4 py-1.5 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black uppercase tracking-widest">{{ $chapter->type ?? 'Regional' }}</span>
            </div>
            
            <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $chapter->name }}</h3>
            <p class="text-sm text-slate-500 font-medium mb-6">Active mission coordination for this sector.</p>
            
            <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-ibsea-green rounded-full"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Active</span>
                </div>
                <a href="#" class="text-accent hover:text-primary transition-colors">
                    <span class="material-icons">east</span>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-24 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-200">
            <span class="material-icons text-6xl text-slate-200 mb-4">map</span>
            <h3 class="text-xl font-bold text-slate-400">No Chapters Established</h3>
            <p class="text-slate-400 mt-2">Begin by establishing your first institutional chapter.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
