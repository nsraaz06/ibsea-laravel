@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-900 overflow-hidden">
    <!-- Sidebar: Course Navigator -->
    <aside class="w-1/4 h-full bg-slate-800 border-r border-slate-700 flex flex-col hidden lg:flex shadow-2xl">
        <div class="p-8 border-b border-slate-700 flex justify-between items-center">
            <div>
                <a href="{{ route('user.courses.show', $course->slug) }}" class="text-slate-400 hover:text-white transition-all">
                    <span class="material-icons">arrow_back</span>
                </a>
            </div>
            <h4 class="text-xs font-black text-slate-200 uppercase tracking-[0.2em]">Curriculum Nav</h4>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-4">
            @foreach($course->modules as $module)
            <div x-data="{ open: {{ $module->lessons->contains($lesson) ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 rounded-2xl hover:bg-slate-700 transition-all text-left">
                    <span class="text-xs font-bold text-slate-100 uppercase tracking-tight">{{ $loop->iteration }}. {{ $module->title }}</span>
                    <span class="material-icons text-slate-500 text-sm" :class="open ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div x-show="open" x-transition class="mt-2 space-y-1">
                    @foreach($module->lessons as $navLesson)
                    <a href="{{ route('user.courses.watch', [$course->slug, $navLesson->id]) }}" class="flex items-center justify-between px-8 py-3 rounded-xl transition-all {{ $navLesson->id == $lesson->id ? 'bg-primary/20 text-white border border-primary/20 shadow-lg' : 'text-slate-400 hover:text-slate-200' }}">
                        <div class="flex items-center gap-4">
                            <span class="material-icons text-sm opacity-50">
                                @if($enrollment || $course->access_type == 'free' || $navLesson->is_preview)
                                    @if($navLesson->is_pdf_lesson)
                                        picture_as_pdf
                                    @else
                                        {{ $navLesson->video_type == 'youtube' ? 'play_circle' : ($navLesson->video_type == 'upload' ? 'movie' : 'article') }}
                                    @endif
                                @else
                                    lock
                                @endif
                            </span>
                            <div class="flex flex-col">
                                <span class="text-[11px] font-bold">{{ $navLesson->title }}</span>
                                @if($navLesson->duration)
                                    <span class="text-[9px] opacity-40 font-black uppercase tracking-widest">{{ $navLesson->duration }}</span>
                                @endif
                            </div>
                        </div>
                        @if($navLesson->is_preview)
                            <span class="material-icons text-[10px] text-ibsea-green">lock_open</span>
                        @elseif(!$enrollment && $course->access_type != 'free')
                            <span class="material-icons text-[10px] text-slate-500">lock</span>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </aside>

    <!-- Main Player Canvas -->
    <main class="flex-1 h-full flex flex-col">
        <div class="flex-1 bg-black relative flex items-center justify-center group">
            @if($lesson->is_pdf_lesson && $lesson->attachment_path)
                <div class="w-full h-full bg-slate-100 flex flex-col">
                    <iframe src="{{ asset($lesson->attachment_path) }}#toolbar=0" class="w-full flex-1 border-none shadow-premium"></iframe>
                    <div class="bg-primary/10 p-4 border-t border-primary/10 flex justify-center items-center">
                        <p class="text-[10px] text-primary font-black uppercase tracking-[0.3em]">Institutional Asset: PDF Strategy Document</p>
                    </div>
                </div>
            @elseif($lesson->video_type == 'youtube')
                @php 
                    $youtubeId = '';
                    if (preg_match('/(v=|\/embed\/|\/watch\?v=|youtu.be\/)([a-zA-Z0-9_-]{11})/', $lesson->video_url, $match)) {
                        $youtubeId = $match[2];
                    }
                @endphp
                @if($youtubeId)
                    <iframe class="w-full h-full border-none shadow-2xl" 
                        src="https://www.youtube-nocookie.com/embed/{{ $youtubeId }}?modestbranding=1&rel=0&iv_load_policy=3&showinfo=0&disablekb=1&autoplay=1" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
                @else
                    <div class="text-slate-500 font-bold uppercase tracking-widest text-xs">Architectural Error: Invalid Video Stream</div>
                @endif
            @elseif($lesson->video_type == 'upload')
                <div class="w-full h-full flex items-center justify-center bg-black">
                    <video class="w-full h-full max-h-screen outline-none shadow-2xl" controls controlsList="nodownload" oncontextmenu="return false;" autoplay>
                        <source src="{{ asset($lesson->video_url) }}" type="video/mp4">
                        <p class="text-white text-xs uppercase tracking-widest">Structural Update: Your browser does not support HTML5 video.</p>
                    </video>
                </div>
            @elseif($lesson->video_type == 'vimeo')
                <div class="text-slate-200 font-bold uppercase tracking-widest text-xs">Vimeo Engine Initializing...</div>
            @else
                <div class="text-slate-200 font-bold uppercase tracking-widest text-xs">Direct Embed Logic Initializing...</div>
            @endif
        </div>

        <!-- Lesson Meta Overlay -->
        <div class="bg-slate-800 p-10 flex justify-between items-center shadow-premium-dark overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-primary to-transparent"></div>
            <div>
                <p class="text-[10px] text-slate-500 font-black uppercase tracking-[0.3em] mb-2">{{ $lesson->module->title }}</p>
                <h2 class="text-2xl font-black text-white tracking-tight">{{ $lesson->title }}</h2>
            </div>
            
            <div class="flex gap-4">
                @if($lesson->attachment_path)
                    <a href="{{ asset($lesson->attachment_path) }}" target="_blank" class="bg-slate-700/50 hover:bg-slate-700 text-slate-300 px-6 py-4 rounded-2xl flex items-center gap-3 transition-all">
                        <span class="material-icons text-sm">attachment</span>
                        <span class="font-bold text-[10px] uppercase tracking-widest">Asset Dossier</span>
                    </a>
                @endif
                
                @if(!$isCompleted)
                    <form action="{{ route('user.courses.complete', [$course->slug, $lesson->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-ibsea-green text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-2">
                            @if($lesson->module->lessons->last()->id == $lesson->id && $lesson->module->quiz)
                                Finalize & Start Assessment <span class="material-icons text-sm">assignment</span>
                            @else
                                Mark Strategic Phase Complete <span class="material-icons text-sm">check_circle</span>
                            @endif
                        </button>
                    </form>
                @else
                    <div class="flex gap-4">
                        <div class="bg-ibsea-green/20 text-ibsea-green px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] flex items-center gap-2 border border-ibsea-green/20">
                            Strategic Phase Finalized <span class="material-icons text-sm">verified</span>
                        </div>
                        @if($lesson->module->lessons->last()->id == $lesson->id && $lesson->module->quiz)
                            <a href="{{ route('user.courses.quiz', [$course->slug, $lesson->module->quiz->id]) }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-2">
                                Start Strategic Assessment <span class="material-icons text-sm">quiz</span>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>

<style>
    .shadow-premium-dark {
        box-shadow: 0 -10px 30px rgba(0,0,0,0.4);
    }
</style>
@endsection
