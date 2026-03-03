@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Institutional Resource Hub</h2>
            <p class="text-slate-500 font-semibold italic">Manage official PDFs, templates, and mission-essential documents.</p>
        </div>
        <a href="{{ route('admin.resources.create') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-premium hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-3">
            <span class="material-icons text-sm">add_circle</span>
            Upload New Resource
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

    <div class="bg-white rounded-[3rem] shadow-premium border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-8 py-6 text-[11px] font-black text-slate-400 uppercase tracking-widest">Document Intelligence</th>
                    <th class="px-8 py-6 text-[11px] font-black text-slate-400 uppercase tracking-widest">Global Sector</th>
                    <th class="px-8 py-6 text-[11px] font-black text-slate-400 uppercase tracking-widest">Operational Status</th>
                    <th class="px-8 py-6 text-[11px] font-black text-slate-400 uppercase tracking-widest">Created At</th>
                    <th class="px-8 py-6 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Strategic Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($resources as $resource)
                <tr class="group hover:bg-slate-50/50 transition-all">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-20 bg-slate-50 border border-slate-100 rounded-lg flex items-center justify-center overflow-hidden shrink-0 shadow-sm relative group/thumb">
                                @if($resource->cover_image)
                                    <img src="{{ asset($resource->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-icons opacity-20">description</span>
                                @endif
                                <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover/thumb:opacity-100 transition-opacity"></div>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">{{ $resource->title }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Resource ID: #{{ str_pad($resource->id, 5, '0', STR_PAD_LEFT) }}</p>
                                @if(!$resource->cover_image)
                                    <span class="text-[9px] font-black text-amber-500 uppercase tracking-widest mt-1 block">Branding Pending</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="bg-slate-100 text-slate-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-slate-200">
                            {{ $resource->resourceCategory->name ?? $resource->category }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        @if($resource->is_active)
                        <span class="bg-ibsea-green/10 text-ibsea-green px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-ibsea-green/20 flex items-center gap-2 w-fit">
                            <span class="w-1.5 h-1.5 bg-ibsea-green rounded-full animate-pulse"></span>
                            Active
                        </span>
                        @else
                        <span class="bg-slate-100 text-slate-400 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-slate-200">
                            Offline
                        </span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-sm font-bold text-slate-500">
                        {{ $resource->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all text-right">
                            <a href="{{ url($resource->file_path) }}" target="_blank" class="p-3 bg-blue-50 text-blue-500 rounded-xl hover:bg-blue-500 hover:text-white transition-all shadow-sm">
                                <span class="material-icons text-sm">visibility</span>
                            </a>
                            <a href="{{ route('admin.resources.edit', $resource->id) }}" class="p-3 bg-amber-50 text-amber-500 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                <span class="material-icons text-sm">edit</span>
                            </a>
                            <form action="{{ route('admin.resources.destroy', $resource->id) }}" method="POST" class="inline" onsubmit="return confirm('Archive this strategic resource?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                    <span class="material-icons text-sm">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <span class="material-icons text-6xl text-slate-200">folder_open</span>
                            <p class="text-slate-400 font-bold uppercase tracking-widest">No strategic resources deployed yet.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($resources->hasPages())
        <div class="p-8 border-t border-slate-50">
            {{ $resources->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
