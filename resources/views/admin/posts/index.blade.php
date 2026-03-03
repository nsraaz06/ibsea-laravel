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

    <!-- Search & Filters -->
    <div class="bg-white p-8 rounded-[3rem] shadow-premium mb-10 border border-slate-100">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-6">
            <div class="md:col-span-2">
                <label class="text-[10px] font-black text-primary uppercase tracking-widest mb-2 block px-1">Search Dispatch</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title..." class="w-full bg-slate-50 border-none rounded-2xl px-12 py-4 text-sm font-bold focus:ring-4 focus:ring-primary/10 transition-all text-slate-800 placeholder:text-slate-300">
                    <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-lg">search</span>
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black text-primary uppercase tracking-widest mb-2 block px-1">Category</label>
                <select name="category" onchange="this.form.submit()" class="w-full bg-slate-50 border-none rounded-2xl px-12 py-4 text-sm font-bold focus:ring-4 focus:ring-primary/10 transition-all text-slate-800 appearance-none cursor-pointer">
                    <option value="">All Categories</option>
                    <option value="News" {{ request('category') === 'News' ? 'selected' : '' }}>News</option>
                    <option value="Blog" {{ request('category') === 'Blog' ? 'selected' : '' }}>Blog</option>
                    <option value="Announcement" {{ request('category') === 'Announcement' ? 'selected' : '' }}>Announcement</option>
                </select>
            </div>

            <div>
                <label class="text-[10px] font-black text-primary uppercase tracking-widest mb-2 block px-1">Status</label>
                <select name="status" onchange="this.form.submit()" class="w-full bg-slate-50 border-none rounded-2xl px-12 py-4 text-sm font-bold focus:ring-4 focus:ring-primary/10 transition-all text-slate-800 appearance-none cursor-pointer">
                    <option value="">All Status</option>
                    <option value="Published" {{ request('status') === 'Published' ? 'selected' : '' }}>Published</option>
                    <option value="Draft" {{ request('status') === 'Draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div>
                <label class="text-[10px] font-black text-primary uppercase tracking-widest mb-2 block px-1">Posting Date</label>
                <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-4 focus:ring-primary/10 transition-all text-slate-800 cursor-pointer">
            </div>
        </form>
    </div>

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
                                <div class="w-16 h-10 bg-slate-100 rounded-lg flex items-center justify-center shrink-0 overflow-hidden shadow-inner">
                                    @if($post->featured_image)
                                        <img src="{{ asset($post->featured_image) }}" class="w-full h-full object-cover" alt="{{ $post->title }}">
                                    @else
                                        <span class="material-icons text-slate-200 text-sm">image</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-800 line-clamp-1 truncate max-w-xs">{{ $post->title }}</div>
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
