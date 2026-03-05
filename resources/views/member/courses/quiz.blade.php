@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-900 overflow-hidden">
    <main class="flex-1 p-8 md:p-16 flex flex-col items-center justify-center relative">
        <div class="absolute inset-0 overflow-hidden opacity-20 pointer-events-none">
            <div class="absolute top-[20%] left-[10%] w-[40rem] h-[40rem] bg-primary/20 rounded-full blur-[12rem]"></div>
            <div class="absolute bottom-[20%] right-[10%] w-[30rem] h-[30rem] bg-accent/20 rounded-full blur-[10rem]"></div>
        </div>

        <div class="w-full max-w-4xl relative z-10">
            <header class="text-center mb-16">
                <p class="text-[10px] text-primary font-black uppercase tracking-[0.4em] mb-4">Module Institutional Assessment</p>
                <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-4">{{ $quiz->title }}</h1>
                <div class="flex items-center justify-center gap-8">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-primary text-sm">ballot</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $quiz->questions->count() }} Strategic Inquiries</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-primary text-sm">verified_user</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $quiz->pass_percentage }}% Proficiency Required</span>
                    </div>
                </div>
            </header>

            <form action="{{ route('user.courses.quiz.submit', [$course->slug, $quiz->id]) }}" method="POST" class="space-y-12">
                @csrf
                <div class="space-y-8">
                    @foreach($quiz->questions as $question)
                    <div class="bg-slate-800/50 backdrop-blur-md p-10 rounded-[3rem] border border-slate-700/50 shadow-2xl group hover:border-primary/30 transition-all duration-500">
                        <div class="flex items-start gap-6">
                            <span class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center font-black text-xs border border-primary/20 group-hover:bg-primary group-hover:text-white transition-all duration-500">
                                {{ $loop->iteration }}
                            </span>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-slate-100 mb-8 leading-relaxed">{{ $question->question }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($question->answers as $answer)
                                    <label class="relative flex items-center p-6 rounded-2xl bg-slate-900/50 border border-slate-700 cursor-pointer hover:bg-slate-700/50 hover:border-primary/50 transition-all group/answer">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" required class="sr-only peer">
                                        <div class="w-6 h-6 rounded-full border-2 border-slate-600 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center transition-all mr-4">
                                            <span class="material-icons text-white text-[12px] opacity-0 peer-checked:opacity-100">check</span>
                                        </div>
                                        <span class="text-sm font-bold text-slate-400 peer-checked:text-white transition-all">{{ $answer->answer }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="flex flex-col items-center gap-6 pt-10">
                    <button type="submit" class="w-full md:w-80 bg-primary text-white py-6 rounded-3xl font-black text-xs uppercase tracking-[0.25em] shadow-premium hover:-translate-y-2 active:scale-95 transition-all duration-500">
                        Authenticate Strategy <span class="material-icons text-sm ml-2">rocket_launch</span>
                    </button>
                    <a href="{{ route('user.courses.watch', [$course->slug, $course->modules->where('id', $quiz->module_id)->first()->lessons->last()->id]) }}" class="text-[10px] font-black text-slate-500 hover:text-primary transition-all uppercase tracking-widest">
                        Re-evaluate Strategy (Back to Lesson)
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>

<style>
    .shadow-premium {
        box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 100px rgba(var(--primary-rgb), 0.1);
    }
</style>
@endsection
