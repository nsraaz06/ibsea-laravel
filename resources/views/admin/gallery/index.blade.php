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
        @forelse($galleries as $folder)
        <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-100 overflow-hidden group hover:border-primary transition-all relative">
            <div class="aspect-square relative overflow-hidden bg-slate-50">
                <!-- Stacked Effect for Folder -->
                <div class="absolute inset-0 flex items-center justify-center p-6">
                    <div class="w-full h-full bg-slate-200 rounded-2xl rotate-3 translate-x-1 translate-y-1 opacity-50"></div>
                    <div class="absolute inset-0 bg-white border border-slate-100 rounded-3xl m-6 p-1 shadow-inner overflow-hidden">
                        <img src="{{ asset($folder->image_path) }}" class="w-full h-full object-cover rounded-2xl">
                    </div>
                </div>

                <div class="absolute top-4 left-4 right-4 flex justify-between items-start z-10">
                    <span class="bg-primary text-secondary px-3 py-1 rounded-full text-[7px] font-black uppercase tracking-widest shadow-lg">
                        {{ $folder->category }}
                    </span>
                    <div class="w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center text-[10px] font-black shadow-lg">
                        {{ $folder->image_count }}
                    </div>
                </div>

                <div class="absolute bottom-4 left-4 right-4 translate-y-0 group-hover:translate-y-0 transition-all opacity-0 group-hover:opacity-100 z-10">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('admin.gallery.edit', $folder->id) }}" class="p-3 bg-primary text-white rounded-xl hover:bg-accent transition-all shadow-xl flex items-center gap-2">
                            <span class="material-icons text-sm">folder_open</span>
                            <span class="text-[9px] font-black uppercase">Open Folder</span>
                        </a>
                        <form action="{{ route('admin.gallery.destroy', $folder->id) }}" method="POST" class="inline" onsubmit="return confirm('Erase this MISSION FOLDER and all its contents?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-3 bg-white text-red-500 border border-slate-100 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-xl">
                                <span class="material-icons text-sm">delete_sweep</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="p-6 pt-2">
                <p class="text-xs font-black text-slate-800 uppercase tracking-tight line-clamp-2 min-h-[2.5rem]">{{ $folder->title }}</p>
                <div class="mt-2 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-slate-400">
                        <span class="material-icons text-xs">category</span>
                        <p class="text-[8px] font-bold uppercase tracking-widest truncate max-w-[100px]">{{ $folder->category }}</p>
                    </div>
                    <p class="text-[9px] font-black text-primary opacity-50 uppercase tracking-widest">{{ $folder->image_count }} Visuals</p>
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
