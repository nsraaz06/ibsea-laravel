@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Mission Intelligence (News & Blog)</h2>
            <p class="text-slate-500 font-semibold italic">Broadcast institutional progress and generic updates.</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="bg-accent text-white px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-primary shadow-lg shadow-accent/20 transition-all flex items-center gap-3">
            <span class="material-icons text-sm">edit_note</span> Compose Dispatch
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
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Dispatch Title</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Visibility</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($posts as $post)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center shrink-0">
                                    <span class="material-icons text-slate-400">article</span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-800 line-clamp-1">{{ $post->title }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">{{ $post->created_at->format('d M, Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-blue-50 text-primary rounded-full text-[9px] font-black uppercase tracking-widest">{{ $post->category }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 {{ $post->show_on_slider ? 'bg-accent' : 'bg-slate-300' }} rounded-full"></span>
                                <span class="text-[10px] font-bold text-slate-600 uppercase">{{ $post->show_on_slider ? 'Featured' : 'Standard' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 {{ $post->status === 'Published' ? 'bg-ibsea-green/10 text-ibsea-green' : 'bg-amber-50 text-amber-600' }} rounded-full text-[9px] font-black uppercase tracking-widest">
                                {{ $post->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="w-10 h-10 bg-white shadow-sm border border-slate-100 rounded-xl text-primary hover:bg-primary hover:text-white transition-all flex items-center justify-center">
                                    <span class="material-icons text-base">edit</span>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Archive this dispatch permanently?')">
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
                            <span class="material-icons text-4xl text-slate-200 mb-2">post_add</span>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No Intelligence Dispatches Found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
