@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Strategic Sector Intelligence</h2>
            <p class="text-slate-500 font-semibold italic">Manage the global sectors used to categorize institutional intelligence.</p>
        </div>
        <a href="{{ route('admin.resource-categories.create') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-premium hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-3">
            <span class="material-icons text-sm">add_circle</span>
            Define New Sector
        </a>
    </header>

    @if(session('success'))
        <div class="bg-ibsea-green/10 text-ibsea-green p-8 rounded-[2.5rem] mb-10 border border-ibsea-green/20 flex items-center gap-4">
            <div class="w-10 h-10 bg-ibsea-green/20 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-icons">verified</span>
            </div>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-500/10 text-red-500 p-8 rounded-[2.5rem] mb-10 border border-red-500/20 flex items-center gap-4">
            <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-icons">report_problem</span>
            </div>
            <p class="font-bold text-sm">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($categories as $category)
        <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-100 p-8 group hover:border-primary transition-all relative overflow-hidden">
            <div class="flex items-start justify-between mb-6">
                <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                    <span class="material-icons text-3xl">{{ $category->icon ?? 'auto_stories' }}</span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.resource-categories.edit', $category->id) }}" class="p-2 text-slate-400 hover:text-amber-500 transition-all">
                        <span class="material-icons text-xl">edit</span>
                    </a>
                    <form action="{{ route('admin.resource-categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Archive this strategic sector intelligence branch? This cannot be undone if dossiers are linked.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-all">
                            <span class="material-icons text-xl">delete</span>
                        </button>
                    </form>
                </div>
            </div>

            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight mb-2">{{ $category->name }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Slug: {{ $category->slug }}</p>
            <p class="text-sm font-medium text-slate-500 leading-relaxed mb-8 italic line-clamp-3">
                {{ $category->description ?? 'No strategic summary defined for this sector branch.' }}
            </p>

            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                <div class="flex items-center gap-2">
                    <span class="material-icons text-sm text-primary">inventory_2</span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $category->resources_count }} Active Dossiers</span>
                </div>
                <span class="text-[10px] font-black text-slate-200 uppercase tracking-widest italic">Sector ID #{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
            
            <!-- Link Background Decor -->
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] rotate-12 transition-all group-hover:rotate-0">
                <span class="material-icons text-9xl">{{ $category->icon ?? 'auto_stories' }}</span>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border border-slate-100">
            <div class="flex flex-col items-center gap-4">
                <span class="material-icons text-6xl text-slate-200">category</span>
                <p class="text-slate-400 font-bold uppercase tracking-widest">No custom sectors have been defined yet.</p>
                <a href="{{ route('admin.resource-categories.create') }}" class="text-primary font-black uppercase text-[10px] tracking-widest mt-4 flex items-center gap-2">
                    <span class="material-icons text-sm">add_circle</span> Initialize First Sector
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
