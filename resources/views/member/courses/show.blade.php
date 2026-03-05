@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <main class="flex-1 p-8 md:p-12">
        <header class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <a href="{{ route('user.courses.index') }}" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 hover:text-primary transition-all mb-4">
                    <span class="material-icons text-xs">arrow_back</span>
                    Institutional Catalog
                </a>
                <h2 class="text-4xl font-black text-navy-accent dark:text-white tracking-tight mb-2">{{ $course->title }}</h2>
                <div class="flex items-center gap-6">
                    <span class="bg-primary/10 text-primary px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest">{{ $course->category }}</span>
                    <span class="text-xs font-bold text-slate-400 flex items-center gap-2">
                        <span class="material-icons text-sm">schedule</span> 
                        {{ $course->modules->count() }} Modules • {{ $totalLessonsCount }} Strategic Lessons
                        @if($course->duration)
                             • {{ $course->duration }}
                        @endif
                    </span>
                </div>
            </div>

            @if($enrollment)
            <div class="w-full md:w-72">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-[10px] font-black text-primary uppercase tracking-widest">Strategic Progress</h4>
                    <span class="text-[10px] font-black text-slate-800 dark:text-slate-200">{{ $progress }}%</span>
                </div>
                <div class="w-full h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-primary to-accent transition-all duration-1000" style="width: {{ $progress }}%"></div>
                </div>
            </div>
            @endif
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Curriculum Overview -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-slate-900 p-10 rounded-[3rem] shadow-premium border border-slate-100 dark:border-slate-800">
                    <h3 class="text-sm font-black text-primary uppercase tracking-widest mb-6 flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-accent"></span> Program Curriculum
                    </h3>

                    <div class="space-y-6">
                        @foreach($course->modules as $module)
                        <div x-data="{ open: true }" class="border border-slate-100 dark:border-slate-800 rounded-[2rem] overflow-hidden">
                            <button @click="open = !open" class="w-full flex justify-between items-center px-8 py-6 bg-slate-50/50 dark:bg-white/5 hover:bg-slate-50 transition-all text-left">
                                <div class="flex items-center gap-4">
                                    <span class="w-8 h-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center font-black text-xs">{{ $loop->iteration }}</span>
                                    <h4 class="font-bold text-slate-800 dark:text-white">{{ $module->title }}</h4>
                                </div>
                                <span class="material-icons transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                            </button>
                            <div x-show="open" x-transition class="p-6 space-y-3">
                                @foreach($module->lessons as $lesson)
                                <a href="{{ route('user.courses.watch', [$course->slug, $lesson->id]) }}" class="flex items-center justify-between p-4 rounded-2xl hover:bg-primary/5 transition-all group">
                                    <div class="flex items-center gap-4">
                                        <span class="material-icons text-slate-300 group-hover:text-primary text-sm">
                                            @if($enrollment || $course->access_type == 'free' || $lesson->is_preview)
                                                {{ $lesson->video_type == 'youtube' ? 'play_circle' : 'article' }}
                                            @else
                                                lock
                                            @endif
                                        </span>
                                        <p class="text-[13px] font-bold text-slate-600 dark:text-slate-400 group-hover:text-primary">{{ $lesson->title }}</p>
                                    </div>
                                    @if($lesson->is_preview)
                                        <span class="text-[9px] font-black text-ibsea-green uppercase tracking-widest bg-ibsea-green/10 px-3 py-1 rounded-full border border-ibsea-green/20 flex items-center gap-1">
                                            <span class="material-icons text-[10px]">lock_open</span> Preview Available
                                        </span>
                                    @elseif(!$enrollment && $course->access_type != 'free')
                                        <span class="material-icons text-slate-300 text-xs">lock</span>
                                    @endif
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Enrollment Asset -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-slate-900 p-10 rounded-[3rem] shadow-premium border-t-8 border-primary sticky top-10 space-y-8">
                    <div class="aspect-video rounded-3xl overflow-hidden border border-slate-100 dark:border-slate-800 shadow-inner">
                        <img src="{{ asset($course->thumbnail ?? 'images/course-placeholder.jpg') }}" class="w-full h-full object-cover">
                    </div>

                    <div class="space-y-2 text-center pb-4 border-b border-slate-50 dark:border-slate-800">
                        @if($course->access_type == 'free')
                            <p class="text-3xl font-black text-ibsea-green tracking-tighter uppercase">Open Access</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Institutional Grant</p>
                        @else
                            <p class="text-3xl font-black text-slate-800 dark:text-white tracking-tighter uppercase">₹{{ number_format($course->price, 2) }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Strategic Investment</p>
                        @endif
                    </div>

                    <div class="space-y-4">
                        @if($enrollment)
                            @if($progress == 100)
                                <a href="{{ route('user.courses.certificate', $course->slug) }}" class="block w-full text-center bg-ibsea-green text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all">
                                    Download Certificate <span class="material-icons text-sm ml-2">workspace_premium</span>
                                </a>
                            @endif
                            <a href="{{ route('user.courses.watch', [$course->slug, $course->modules->first()->lessons->first()->id ?? 0]) }}" class="block w-full text-center bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all">
                                Resume Learning Hub <span class="material-icons text-sm ml-2">rocket_launch</span>
                            </a>
                        @else
                            <a href="{{ route('payment.checkout', ['type' => 'Course', 'item_id' => $course->id]) }}" class="block w-full text-center bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all">
                                Authorize Enrollment <span class="material-icons text-sm ml-1">security</span>
                            </a>
                        @endif
                    </div>

                    <div class="pt-4 space-y-4">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Curriculum Highlights</h4>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-xs font-bold text-slate-500">
                                <span class="material-icons text-primary text-sm">verified</span> Lifetime Portal Access
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-slate-500">
                                <span class="material-icons text-primary text-sm">verified</span> Direct Mentorship Video
                            </li>
                            <li class="flex items-center gap-3 text-xs font-bold text-slate-500">
                                <span class="material-icons text-primary text-sm">verified</span> Integrated Attachments
                            </li>
                            @if($course->duration)
                                <li class="flex items-center gap-3 text-xs font-bold text-slate-500">
                                    <span class="material-icons text-primary text-sm">event</span> {{ $course->duration }} Strategy
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
