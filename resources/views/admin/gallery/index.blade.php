@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Mission Media Gallery</h2>
            <p class="text-slate-500 font-semibold italic">Manage high-authority visual assets and event-based photographic history.</p>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-premium hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-3">
            <span class="material-icons text-sm">add_photo_alternate</span>
            Upload Mission Assets
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

    <div class="mb-10">
        <div class="flex flex-wrap gap-4 items-center">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mr-2">Quick Filter:</span>
            <a href="{{ route('admin.gallery.index') }}" class="px-6 py-2 rounded-full border {{ !request('category') ? 'bg-primary text-white border-primary' : 'bg-white text-slate-500 border-slate-100' }} text-[10px] font-black uppercase tracking-widest transition-all">All Media</a>
            @foreach(['Event Highlights', 'Institutional Operations', 'Global Alliance', 'Press & Media', 'Strategic Partner - MOU', 'Strategic Partner - National', 'Strategic Partner - International'] as $cat)
                <a href="{{ route('admin.gallery.index', ['category' => $cat]) }}" 
                   class="px-6 py-2 rounded-full border {{ request('category') == $cat ? 'bg-primary text-white border-primary' : 'bg-white text-slate-500 border-slate-100 hover:border-primary/30' }} text-[10px] font-black uppercase tracking-widest transition-all">
                    {{ str_replace('Strategic Partner - ', '', $cat) }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($galleries as $item)
        <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-100 overflow-hidden group hover:border-primary transition-all">
            <div class="aspect-square relative overflow-hidden bg-slate-50">
                <img src="{{ asset($item->image_path) }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 p-4">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-30"></div>
                
                <div class="absolute top-4 left-4 right-4 flex justify-between items-start">
                    <span class="bg-primary text-secondary px-3 py-1 rounded-full text-[7px] font-black uppercase tracking-widest shadow-lg">
                        {{ $item->category }}
                    </span>
                </div>

                <div class="absolute bottom-4 left-4 right-4 translate-y-2 group-hover:translate-y-0 transition-all opacity-0 group-hover:opacity-100">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('admin.gallery.edit', $item->id) }}" class="p-3 bg-white/20 backdrop-blur-md text-white rounded-xl hover:bg-white hover:text-primary transition-all shadow-xl">
                            <span class="material-icons text-sm">edit</span>
                        </a>
                        <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Erase this mission asset?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-3 bg-white/20 backdrop-blur-md text-white rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-xl">
                                <span class="material-icons text-sm">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-xs font-black text-slate-800 uppercase tracking-tight truncate">{{ $item->title ?? 'Untitled Asset' }}</p>
                <div class="mt-3 flex items-center gap-2 text-slate-400">
                    <span class="material-icons text-xs">event</span>
                    <p class="text-[9px] font-bold uppercase tracking-widest">{{ $item->event->name ?? 'Global Operation' }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
            <div class="flex flex-col items-center gap-4">
                <span class="material-icons text-6xl text-slate-200">photo_library</span>
                <p class="text-slate-400 font-bold uppercase tracking-widest">No mission visual history available.</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
    <div class="mt-12">
        {{ $galleries->links() }}
    </div>
    @endif
</div>
@endsection
