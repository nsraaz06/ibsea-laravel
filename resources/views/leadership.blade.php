@extends('layouts.app')

@push('styles')
<style>
    .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .hover-lift:hover { transform: translateY(-5px); }
    
    /* Mobile Sidebar Transitions */
    @media (max-width: 1023px) {
        #filter-sidebar { 
            transition: transform 0.3s ease-in-out; 
            transform: translateX(-100%);
        }
        #filter-sidebar.visible-mobile { 
            transform: translateX(0); 
        }
    }

    @media (min-width: 1024px) {
        #filter-sidebar {
            transform: none !important;
            visibility: visible !important;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="bg-slate-900 pt-32 pb-20 px-6 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500 rounded-full -mr-48 -mt-48 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500 rounded-full -ml-32 -mb-32 blur-3xl"></div>
    </div>
    <div class="w-full px-6 md:px-16 relative z-10 text-center">
        <h1 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tight uppercase">IBSEA <span class="text-orange-500">Leadership</span></h1>
        <p class="text-slate-400 max-w-2xl mx-auto text-lg font-medium leading-relaxed">Meet the visionaries, advisors, and mission heads driving the India @ 2047 initiative across the globe.</p>
    </div>
</section>

<!-- Mobile Sticky Bar -->
<div class="lg:hidden sticky top-[72px] z-40 bg-white/80 backdrop-blur-md border-b border-slate-100 px-4 py-3 shadow-sm">
    <div class="flex items-center gap-3">
        <div class="relative flex-1">
            <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input type="text" id="mobile-search-trigger" value="{{ $filters['search'] }}" placeholder="Search visionary..." class="w-full bg-slate-100 border-none rounded-xl pl-9 pr-4 py-2.5 text-xs font-bold focus:ring-2 focus:ring-orange-500 transition-all">
        </div>
        <button onclick="toggleSidebar(true)" class="bg-slate-900 text-white p-2.5 rounded-xl flex items-center gap-2 active:scale-95 transition-all">
            <span class="material-icons text-sm">tune</span>
            <span class="text-[10px] font-black uppercase tracking-widest">Filter</span>
        </button>
    </div>
</div>

<div class="max-w-[1600px] mx-auto px-4 md:px-8 lg:px-16 py-12 lg:py-20">
    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Sidebar Filters -->
        <div id="sidebar-overlay" onclick="toggleSidebar(false)" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[55] hidden opacity-0 transition-opacity"></div>

        <aside id="filter-sidebar" class="fixed lg:sticky top-0 lg:top-24 left-0 h-full lg:h-auto w-[85%] sm:w-[320px] lg:w-1/4 bg-white lg:bg-transparent z-[60] lg:z-10 p-6 lg:p-0 overflow-y-auto lg:overflow-visible">
            <div class="bg-white lg:bg-white/50 dark:bg-slate-900/50 p-6 lg:p-8 rounded-3xl lg:border lg:border-slate-100 lg:dark:border-slate-800 lg:backdrop-blur-md">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Filter Global Network</h3>
                    <button onclick="toggleSidebar(false)" class="lg:hidden w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                        <span class="material-icons text-sm">close</span>
                    </button>
                </div>
                
                <form id="filter-form" action="{{ route('leadership') }}" method="GET" class="space-y-6">
                    <!-- Name Search -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 px-1">Search Leader</label>
                        <input type="text" id="sidebar-search" name="search" value="{{ $filters['search'] }}" placeholder="Enter name..." class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-orange-500 transition-all">
                    </div>

                    <!-- Chapter Filter -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 px-1">Institutional Chapter</label>
                        <select name="chapter" onchange="this.form.submit()" class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-orange-500 transition-all">
                            <option value="">All Regions</option>
                            @foreach($chapters as $chapter)
                                <option value="{{ $chapter->id }}" {{ $filters['chapter'] == $chapter->id ? 'selected' : '' }}>{{ $chapter->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Council Filter -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 px-1">Strategic Council</label>
                        <select name="council" onchange="this.form.submit()" class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-orange-500 transition-all">
                            <option value="">All Councils</option>
                            @foreach($councils as $council)
                                <option value="{{ $council->id }}" {{ $filters['council'] == $council->id ? 'selected' : '' }}>{{ $council->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Role Filter -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 px-1">Mission Role</label>
                        <select name="designation" onchange="this.form.submit()" class="w-full bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-orange-500 transition-all">
                            <option value="">All Leadership Roles</option>
                            @foreach($filter_roles as $role)
                                <option value="{{ $role }}" {{ $filters['designation'] == $role ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('leadership') }}" class="block w-full text-center py-4 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">Reset Filters</a>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Leadership Grid -->
        <main class="lg:w-3/4">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8">
                @forelse($leaders as $leader)
                    <div class="bg-white dark:bg-white/5 border-2 border-orange-500 rounded-md overflow-hidden group hover:shadow-2xl hover:shadow-blue-500/20 hover:-translate-y-3 hover:scale-[1.01] hover:border-blue-600 transition-all duration-500 ease-out premium-shadow">
                        <div class="aspect-square bg-slate-100 relative overflow-hidden">
                            @if($leader->profile_image)
                                <img src="{{ asset($leader->profile_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700" alt="{{ $leader->name }}">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                    <span class="material-icons text-8xl text-slate-300">person</span>
                                </div>
                            @endif
                            
                            <!-- Role Badge -->
                            <div class="absolute bottom-2 right-2 md:bottom-4 md:right-4 bg-orange-600 px-2.5 py-1 md:px-4 md:py-1.5 rounded-full shadow-lg">
                                <p class="text-[8px] md:text-[10px] font-black text-white uppercase tracking-widest">{{ $leader->dynamic_role_name ?? $leader->role }}</p>
                            </div>

                            @php
                                $linkedin = $leader->linkedin ?? $leader->linkedin_url;
                            @endphp

                            @if($linkedin)
                                <div class="absolute top-2 right-2">
                                    <a href="{{ $linkedin }}" target="_blank" class="flex items-center justify-center w-7 h-7 md:w-9 md:h-9 rounded-full bg-blue-600 text-white font-bold hover:bg-orange-600 transition-all group/link">
                                        <i class="fa-brands fa-linkedin-in text-sm md:text-xl"></i>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="p-3 md:p-4 text-center">
                            <h3 class="text-sm md:text-sm font-bold dark:text-orange-500 text-slate-800 mb-0.5 md:mb-1 leading-tight">{{ $leader->name }}</h3>
                            <p class="text-[8px] md:text-[10px] dark:text-white font-bold text-orange-500 uppercase tracking-widest mb-1">
                                @switch($leader->card_display_pattern)
                                    @case('alliance')
                                        {{ $leader->alliance_name }}
                                        @break
                                    @case('chapter')
                                        {{ $leader->chapter_name ?? 'Global Core' }} {{ $leader->chapter_name ? 'Chapter' : '' }}
                                        @break
                                    @case('council')
                                        {{ $leader->council_name }}
                                        @break
                                    @case('designation')
                                        <!-- Only Designation Title Visible -->
                                        @break
                                    @default
                                        {{ $leader->chapter_name ?? 'Global Core' }} {{ $leader->chapter_name ? 'Chapter' : '' }}
                                        @if($leader->council_name)
                                            {{ $leader->chapter_name ? ' • ' : '' }} {{ $leader->council_name }}
                                        @endif
                                @endswitch
                            </p>
                            
                            @if($leader->short_description)
                                <p class="text-[10px] md:text-sm text-slate-500 font-medium pb-1 md:pb-2 line-clamp-2 leading-relaxed h-8 md:h-10">
                                    {{ $leader->short_description }}
                                </p>
                            @endif

                            <a href="{{ url('/leadership/'.$leader->id) }}" class="w-full bg-slate-900 text-white font-black py-2 md:py-3 rounded-lg md:rounded-xl text-[8px] md:text-[10px] uppercase tracking-widest dark:bg-orange-600 dark:text-white hover:bg-orange-600 transition-all mt-1 block uppercase">Know More</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 text-center space-y-6">
                        <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto">
                            <span class="material-icons text-4xl text-slate-300">person_search</span>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tight">No Leaders Found</h3>
                            <p class="text-slate-500 dark:text-slate-400 font-medium max-w-sm mx-auto">Try adjusting your filters to find visionaries in other chapters or councils.</p>
                        </div>
                        <a href="{{ route('leadership') }}" class="inline-flex items-center gap-2 bg-orange-500 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-orange-500/20 active:scale-95 transition-all">Clear All Filters</a>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleSidebar(show) {
        const sidebar = document.getElementById('filter-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        if (show) {
            sidebar.classList.add('visible-mobile');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
            document.body.style.overflow = 'hidden';
        } else {
            sidebar.classList.remove('visible-mobile');
            overlay.classList.remove('opacity-100');
            setTimeout(() => {
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }
    }

    // Sync Mobile Search with Sidebar Search
    const mobileST = document.getElementById('mobile-search-trigger');
    const sidebarSI = document.getElementById('sidebar-search');
    const filterForm = document.getElementById('filter-form');

    if (mobileST && sidebarSI) {
        mobileST.addEventListener('input', (e) => {
            sidebarSI.value = e.target.value;
        });

        mobileST.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                filterForm.submit();
            }
        });
    }
</script>
@endpush
