@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 dark:bg-slate-950 overflow-hidden">
    <!-- Sidebar (Included via directive or manual include) -->
    @include('partials.member_sidebar')

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-4 md:p-12">
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-8 mb-12">
            <div>
                <h2 class="text-3xl font-bold text-navy-accent dark:text-white tracking-tight leading-none mb-3">Institutional Resource Hub</h2>
                <p class="text-sm text-slate-500 font-medium italic">Access official IBSEA policy indices, mission templates, and strategic guides.</p>
            </div>

            <!-- Search Bar -->
            <form action="{{ route('user.resources.index') }}" method="GET" class="relative group max-w-md w-full">
                <span class="material-icons absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search intelligence PDFs..." class="w-full bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl pl-14 pr-6 py-4 text-sm font-bold shadow-sm outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
            </form>
        </header>

        <!-- Category Filter -->
        <div class="flex flex-wrap gap-3 mb-12">
            <a href="{{ route('user.resources.index') }}" class="px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ !request('category') || request('category') == 'All' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-white dark:bg-slate-900 text-slate-400 border border-slate-100 dark:border-slate-800 hover:text-slate-600' }}">
                All PDFs
            </a>
            @foreach($categories as $category)
                <a href="{{ route('user.resources.index', ['category' => $category]) }}" class="px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ request('category') == $category ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-white dark:bg-slate-900 text-slate-400 border border-slate-100 dark:border-slate-800 hover:text-slate-600' }}">
                    {{ $category }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($resources as $resource)
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl group hover:border-primary transition-all relative overflow-hidden">
                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex items-center justify-between mb-8">
                        <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary transition-transform group-hover:scale-95">
                            <span class="material-icons text-3xl">picture_as_pdf</span>
                        </div>
                        <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] bg-slate-50 dark:bg-slate-800 px-3 py-1 rounded-full">{{ $resource->category }}</span>
                    </div>

                    <h4 class="text-xl font-bold text-navy-accent dark:text-white mb-3 italic tracking-tight">{{ $resource->title }}</h4>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8 flex-1">
                        {{ \Illuminate\Support\Str::limit($resource->description, 100) }}
                    </p>

                    <div class="pt-6 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Released</span>
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">{{ $resource->created_at->format('M Y') }}</span>
                        </div>
                        <a href="{{ route('user.resources.download', $resource->id) }}" class="bg-slate-900 dark:bg-white text-white dark:text-slate-950 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary hover:text-white transition-all">
                            Access PDF
                        </a>
                    </div>
                </div>
                <!-- Abstract Decor -->
                <div class="absolute -right-8 -bottom-8 opacity-[0.03] group-hover:opacity-[0.08] transition-all">
                    <span class="material-icons text-9xl">inventory_2</span>
                </div>
            </div>
            @empty
            <div class="col-span-full py-32 text-center bg-white dark:bg-slate-900 rounded-[3rem] border-2 border-dashed border-slate-100 dark:border-slate-800 col-span-full">
                <div class="flex flex-col items-center gap-6">
                    <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center text-slate-200">
                        <span class="material-icons text-5xl">folder_off</span>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-slate-800 dark:text-white uppercase italic tracking-tighter">No resources found</h4>
                        <p class="text-slate-500 font-bold uppercase tracking-widest mt-2 text-xs">Try adjusting your filters or search intelligence.</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        @if($resources->hasPages())
        <div class="mt-12">
            {{ $resources->links() }}
        </div>
        @endif
    </main>
</div>
@endsection
