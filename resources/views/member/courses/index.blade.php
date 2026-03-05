@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <main class="flex-1 p-8 md:p-12">
        <header class="mb-12">
            <h2 class="text-3xl font-bold text-navy-accent dark:text-white tracking-tight">Institutional Learning Hub</h2>
            <p class="text-slate-500 dark:text-slate-400 font-semibold italic">Advance your expertise with IBSEA curated curriculum.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-premium border border-slate-100 dark:border-slate-800 overflow-hidden group hover:-translate-y-2 transition-all duration-500">
                <div class="aspect-video relative overflow-hidden">
                    <img src="{{ asset($course->thumbnail ?? 'images/course-placeholder.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 flex justify-between items-center">
                        <span class="bg-primary text-white text-[10px] font-black uppercase tracking-widest px-4 py-1.5 rounded-full border border-white/20">
                            {{ $course->category ?? 'Program' }}
                        </span>
                        @if(in_array($course->id, $enrolledCourseIds))
                            <span class="bg-ibsea-green text-white text-[10px] font-black uppercase tracking-widest px-4 py-1.5 rounded-full">Enrolled</span>
                        @endif
                    </div>
                </div>

                <div class="p-8 space-y-4">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white leading-tight">{{ $course->title }}</h3>
                    <div class="flex items-center gap-4 text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                        <span class="flex items-center gap-1"><span class="material-icons text-xs">list</span> {{ $course->modules_count }} Modules</span>
                        <span class="flex items-center gap-1"><span class="material-icons text-xs">payments</span> {{ $course->access_type == 'free' ? 'Open Access' : 'Strategic' }}</span>
                    </div>
                    
                    <a href="{{ route('user.courses.show', $course->slug) }}" class="block w-full text-center bg-slate-50 dark:bg-slate-800 text-primary dark:text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-primary hover:text-white transition-all">
                        {{ in_array($course->id, $enrolledCourseIds) ? 'Continue Learning' : 'View Curriculum' }}
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center">
                <span class="material-icons text-6xl text-slate-200 dark:text-slate-800 mb-4">school</span>
                <p class="text-slate-400 font-bold uppercase tracking-widest">The Curriculum Hub is being populated.</p>
            </div>
            @endforelse
        </div>
    </main>
</div>
@endsection
