@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Strategic Initiatives</h2>
            <p class="text-slate-500 font-semibold italic">Manage key focus areas and institutional programs.</p>
        </div>
        <a href="{{ route('admin.initiatives.create') }}" class="bg-accent text-white px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-primary shadow-lg shadow-accent/20 transition-all flex items-center gap-3">
            <span class="material-icons text-sm">add_task</span> Launch New Initiative
        </a>
    </header>

    @if(session('success'))
        <div class="bg-ibsea-green/10 text-ibsea-green p-8 rounded-[2rem] mb-10 border border-ibsea-green/20 flex items-center gap-4">
            <div class="w-10 h-10 bg-ibsea-green/20 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-icons">check_circle</span>
            </div>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Initiative Details</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Organizer</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Assets</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($initiatives as $initiative)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center shrink-0 text-primary">
                                    <span class="material-icons">{{ $initiative->icon }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-800 line-clamp-1">{{ $initiative->title }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">Slug: {{ $initiative->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @if($initiative->organizer_name)
                                <div class="flex items-center gap-3">
                                    <img src="{{ $initiative->organizer_image_url }}" class="w-8 h-8 rounded-full object-cover">
                                    <div>
                                        <div class="text-[11px] font-bold text-slate-700">{{ $initiative->organizer_name }}</div>
                                        <div class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">{{ $initiative->organizer_role }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Not Assigned</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex gap-2">
                                @if($initiative->banner_path)
                                    <span class="material-icons text-emerald-500 text-sm" title="Banner Image">image</span>
                                @endif
                                @if($initiative->pdf_path)
                                    <span class="material-icons text-red-500 text-sm" title="PDF Dossier">description</span>
                                @endif
                                @if(!$initiative->banner_path && !$initiative->pdf_path)
                                    <span class="text-[9px] font-bold text-slate-300 uppercase">None</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 {{ $initiative->is_active ? 'bg-ibsea-green/10 text-ibsea-green' : 'bg-slate-100 text-slate-500' }} rounded-full text-[9px] font-black uppercase tracking-widest">
                                {{ $initiative->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.initiatives.edit', $initiative) }}" class="w-10 h-10 bg-white shadow-sm border border-slate-100 rounded-xl text-primary hover:bg-primary hover:text-white transition-all flex items-center justify-center">
                                    <span class="material-icons text-base">edit</span>
                                </a>
                                <form action="{{ route('admin.initiatives.destroy', $initiative) }}" method="POST" onsubmit="return confirm('Archive this initiative permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 bg-white shadow-sm border border-slate-100 rounded-xl text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center">
                                        <span class="material-icons text-base">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <span class="material-icons text-4xl text-slate-200 mb-2">flag</span>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No Strategic Initiatives Found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($initiatives->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
            {{ $initiatives->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
