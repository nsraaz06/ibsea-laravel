@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="mb-10 flex justify-between items-end">
        <div>
            <a href="{{ route('admin.courses.index') }}" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 hover:text-primary transition-all mb-4">
                <span class="material-icons text-xs">arrow_back</span>
                Return to Learning Hub
            </a>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Refine Curriculum</h2>
            <p class="text-slate-500 font-semibold italic">Architecting the learning path for: <span class="text-slate-800">"{{ $course->title }}"</span></p>
        </div>
        <div class="flex gap-4">
            <button onclick="document.getElementById('module-modal').classList.toggle('hidden')" class="bg-primary/5 text-primary border border-primary/20 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-primary hover:text-white transition-all flex items-center gap-3 shadow-sm">
                <span class="material-icons text-sm">add_box</span>
                New Learning Module
            </button>
        </div>
    </header>

    @if(session('success'))
        <div class="bg-ibsea-green/10 text-ibsea-green p-8 rounded-[2.5rem] mb-10 border border-ibsea-green/20 flex items-center gap-4">
            <div class="w-10 h-10 bg-ibsea-green/20 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-icons">verified</span>
            </div>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        <!-- Sidebar: Global Course Settings -->
        <div class="lg:col-span-1">
            <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-10 rounded-[3rem] shadow-premium border-t-8 border-primary sticky top-10 space-y-8">
                @csrf
                @method('PUT')
                <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] mb-4 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-accent"></span> Core Strategy
                </h3>

                <div class="space-y-4">
                    <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Institutional Title</label>
                    <input type="text" name="title" value="{{ $course->title }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all">
                </div>

                <div class="space-y-4">
                    <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Curriculum Visual</label>
                    <div class="aspect-video rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 relative group">
                        @if($course->thumbnail)
                            <img src="{{ asset($course->thumbnail) }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all cursor-pointer">
                            <span class="material-icons text-white">edit</span>
                            <input type="file" name="thumbnail" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Institutional Duration</label>
                        <input type="text" name="duration" value="{{ $course->duration }}" placeholder="e.g., 12 Weeks / 40 Hours" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-800">
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Pricing (₹)</label>
                        <input type="number" name="price" value="{{ $course->price }}" step="0.01" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-800">
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Certificate Template</label>
                        <select name="certificate_template_id" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all">
                            <option value="">Default Institutional Certificate</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}" {{ $course->certificate_template_id == $template->id ? 'selected' : '' }}>{{ $template->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all">
                        Sync Changes <span class="material-icons text-sm ml-2">sync</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Main Curriculum Builder -->
        <div class="lg:col-span-3 space-y-8">
            <h3 class="text-[13px] font-black text-primary uppercase tracking-[0.3em] flex items-center gap-4 mb-4">
                Curriculum Architecture
                <span class="flex-1 h-[1px] bg-slate-100"></span>
            </h3>

            <div id="module-container" class="space-y-8">
            @forelse($course->modules()->orderBy('order')->get() as $module)
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden module-item" data-id="{{ $module->id }}">
                <div class="bg-slate-50/50 px-8 py-6 flex justify-between items-center border-b border-slate-100">
                    <div class="flex items-center gap-4">
                        <span class="material-icons text-slate-300 cursor-move module-handle">drag_indicator</span>
                        <h4 class="font-bold text-slate-800">{{ $module->title }}</h4>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="document.getElementById('lesson-modal-{{ $module->id }}').classList.toggle('hidden')" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-all" title="Add Lesson">
                            <span class="material-icons text-sm">add_circle</span>
                        </button>
                        <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-red-400 hover:text-red-500 rounded-lg" onclick="return confirm('Archive this entire module?')">
                                <span class="material-icons text-sm">delete</span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="p-6 space-y-4 lesson-container" data-module-id="{{ $module->id }}">
                    @foreach($module->lessons()->orderBy('order')->get() as $lesson)
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100 group lesson-item" data-id="{{ $lesson->id }}">
                        <div class="flex items-center gap-4">
                            <span class="material-icons text-slate-300 cursor-move lesson-handle">drag_indicator</span>
                            <span class="material-icons text-slate-300 text-sm">
                                {{ $lesson->video_type == 'youtube' ? 'play_circle' : ($lesson->video_type == 'upload' ? 'movie' : 'article') }}
                            </span>
                            <div>
                                <p class="text-[13px] font-bold text-slate-700">{{ $lesson->title }}</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $lesson->video_type }} Asset</p>
                                    @if($lesson->is_preview)
                                        <span class="material-icons text-[10px] text-ibsea-green" title="Open Preview">lock_open</span>
                                    @else
                                        <span class="material-icons text-[10px] text-slate-400" title="Locked (Enrollment Required)">lock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-all">
                            <button onclick="document.getElementById('edit-lesson-modal-{{ $lesson->id }}').classList.toggle('hidden')" class="text-primary hover:text-navy-accent">
                                <span class="material-icons text-xs">edit</span>
                            </button>
                            <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-500" onclick="return confirm('Archive this lesson?')">
                                    <span class="material-icons text-xs">close</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Edit Lesson Modal -->
                    <div id="edit-lesson-modal-{{ $lesson->id }}" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-6 hidden">
                        <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-xl p-10 relative">
                            <button onclick="document.getElementById('edit-lesson-modal-{{ $lesson->id }}').classList.add('hidden')" class="absolute top-8 right-8 text-slate-300 hover:text-slate-600 transition-all">
                                <span class="material-icons">close</span>
                            </button>
                            <h3 class="text-xl font-bold text-primary mb-2">Refine Strategic Lesson</h3>
                            <p class="text-slate-500 font-semibold italic text-xs mb-8 uppercase tracking-widest text-center">Modifying: {{ $lesson->title }}</p>
                            
                            <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ videoType: '{{ $lesson->video_type }}' }">
                                @csrf
                                @method('PUT')
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Lesson Directive (Title)</label>
                                    <input type="text" name="title" value="{{ $lesson->title }}" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-6 py-4 text-sm font-bold text-slate-800">
                                </div>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Asset Intelligence</label>
                                        <select name="video_type" x-model="videoType" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-4 text-xs font-bold uppercase tracking-widest">
                                            <option value="youtube">YouTube Embed</option>
                                            <option value="vimeo">Vimeo Stream</option>
                                            <option value="upload">White-Label (Host on Site)</option>
                                            <option value="embed">Custom Iframe</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Engagement Logic</label>
                                        <div class="flex items-center gap-3 bg-slate-50 px-4 py-4 rounded-xl border border-slate-100">
                                            <input type="checkbox" name="is_preview" value="1" {{ $lesson->is_preview ? 'checked' : '' }} class="w-4 h-4 rounded-lg accent-primary">
                                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Open Preview?</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2" x-show="videoType !== 'upload'">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Asset Locator (URL/ID)</label>
                                    <input type="text" name="video_url" value="{{ $lesson->video_url }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-6 py-4 text-sm font-bold text-slate-800">
                                </div>

                                <div class="space-y-2" x-show="videoType === 'upload'">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Update Video Asset (Leave blank to keep current)</label>
                                    <input type="file" name="video_file" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-6 py-4 text-sm font-bold text-slate-800">
                                    @if($lesson->video_type == 'upload')
                                        <p class="text-[9px] text-ibsea-green font-bold uppercase pl-2 italic">Current: {{ basename($lesson->video_url) }}</p>
                                    @endif
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Time Commitment</label>
                                        <input type="text" name="duration" value="{{ $lesson->duration }}" placeholder="e.g., 45 mins" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-4 text-xs font-bold text-slate-800">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Lesson Mode</label>
                                        <div class="flex items-center gap-3 bg-slate-50 px-4 py-4 rounded-xl border border-slate-100">
                                            <input type="checkbox" name="is_pdf_lesson" value="1" {{ $lesson->is_pdf_lesson ? 'checked' : '' }} class="w-4 h-4 rounded-lg accent-primary">
                                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Integrated PDF?</span>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all">
                                    Authorize Refinement
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach

                    @if($module->lessons->isEmpty())
                        <p class="text-[10px] text-slate-400 font-bold italic text-center py-4 uppercase tracking-widest">Architectural void: No lessons added yet.</p>
                    @endif
                </div>

                <!-- Strategic Quiz Section -->
                <div class="px-8 py-4 bg-slate-50/30 border-t border-slate-50 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="material-icons text-primary text-sm">quiz</span>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Module Assessment</span>
                    </div>
                    @if($module->quiz)
                        <div class="flex items-center gap-4">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $module->quiz->title }} ({{ $module->quiz->questions->count() }} Questions)</span>
                            <button onclick="document.getElementById('quiz-modal-{{ $module->id }}').classList.toggle('hidden')" class="btn-quiz-manage text-xs font-bold text-primary hover:underline uppercase">Manage Quiz</button>
                        </div>
                    @else
                        <button onclick="document.getElementById('quiz-modal-{{ $module->id }}').classList.toggle('hidden')" class="text-[10px] font-black text-primary hover:bg-primary/10 px-3 py-1 rounded-full border border-primary/20 transition-all uppercase tracking-widest">
                            + Initialize Quiz
                        </button>
                    @endif
                </div>
            </div>

            <!-- Quiz Management Modal -->
            <div id="quiz-modal-{{ $module->id }}" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[60] flex items-center justify-center p-6 hidden">
                <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-2xl p-10 relative overflow-hidden">
                    <button onclick="document.getElementById('quiz-modal-{{ $module->id }}').classList.add('hidden')" class="absolute top-8 right-8 text-slate-300 hover:text-slate-600 transition-all">
                        <span class="material-icons">close</span>
                    </button>
                    
                    <h3 class="text-xl font-bold text-primary mb-6 text-center">Strategic Module Assessment</h3>

                    @if(!$module->quiz)
                        <form action="{{ route('admin.quizzes.store', $module->id) }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Assessment Title</label>
                                <input type="text" name="title" required placeholder="e.g., Final Proficiency Check" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-6 py-4 text-sm font-bold text-slate-800">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Proficiency Threshold (%)</label>
                                <input type="number" name="pass_percentage" value="80" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-6 py-4 text-sm font-bold text-slate-800">
                            </div>
                            <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium">Deploy Assessment Engine</button>
                        </form>
                    @else
                        <div class="space-y-8 max-h-[60vh] overflow-y-auto pr-4 scrollbar-premium">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                                <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Current Strategic Inquiries</h4>
                                <form action="{{ route('admin.quizzes.destroy', $module->quiz->id) }}" method="POST" onsubmit="return confirm('Archive this strategic assessment?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[9px] font-black text-red-400 hover:text-red-600 uppercase tracking-widest">Archive Quiz</button>
                                </form>
                            </div>

                            <!-- Question List -->
                            <div class="space-y-4">
                                @forelse($module->quiz->questions as $question)
                                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 flex justify-between items-start group">
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 mb-2">{{ $question->question }}</p>
                                            <div class="grid grid-cols-2 gap-x-8 gap-y-2">
                                                @foreach($question->answers as $answer)
                                                    <div class="text-[10px] flex items-center gap-2 {{ $answer->is_correct ? 'text-ibsea-green font-black' : 'text-slate-400' }}">
                                                        <span class="material-icons text-[12px]">{{ $answer->is_correct ? 'check_circle' : 'radio_button_unchecked' }}</span>
                                                        {{ $answer->answer }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.quizzes.remove-question', $question->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-300 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100">
                                                <span class="material-icons text-sm">delete_sweep</span>
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="text-center py-10 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                                        <span class="material-icons text-slate-200 text-4xl mb-2">find_in_page</span>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No strategic questions integrated yet.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Add Question Form -->
                            <div class="p-8 bg-primary/5 rounded-[2rem] border border-primary/10">
                                <h4 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] mb-4">Integrate Strategic Question</h4>
                                <form action="{{ route('admin.quizzes.add-question', $module->quiz->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="text" name="question" required placeholder="State your strategic inquiry..." class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-primary/10 transition-all">
                                    <div class="grid grid-cols-2 gap-4">
                                        <input type="text" name="answers[]" required placeholder="Option A" class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800">
                                        <input type="text" name="answers[]" required placeholder="Option B" class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800">
                                        <input type="text" name="answers[]" placeholder="Option C (Optional)" class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800">
                                        <input type="text" name="answers[]" placeholder="Option D (Optional)" class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800">
                                    </div>
                                    <div class="flex items-center justify-between pt-4">
                                        <div class="flex items-center gap-3">
                                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Correct Key Index (0-3)</label>
                                            <input type="number" name="correct_index" value="0" min="0" max="3" class="w-16 bg-white border border-slate-100 rounded-lg px-2 py-1 text-xs font-bold text-slate-800 text-center focus:ring-4 focus:ring-primary/10 transition-all">
                                        </div>
                                        <input type="hidden" name="type" value="multiple_choice">
                                        <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-premium hover:-translate-y-0.5 transition-all">Push to Quiz</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Lesson Modal (Module Specific) -->
            <div id="lesson-modal-{{ $module->id }}" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-6 hidden">
                <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-xl p-10 relative">
                    <button onclick="document.getElementById('lesson-modal-{{ $module->id }}').classList.add('hidden')" class="absolute top-8 right-8 text-slate-300 hover:text-slate-600 transition-all">
                        <span class="material-icons">close</span>
                    </button>
                    <h3 class="text-xl font-bold text-primary mb-2">Deploy Strategic Lesson</h3>
                    <p class="text-slate-500 font-semibold italic text-xs mb-8 uppercase tracking-widest">Adding asset to: {{ $module->title }}</p>
                    
                    <form action="{{ route('admin.lessons.store', $module->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ videoType: 'youtube' }">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Lesson Directive (Title)</label>
                            <input type="text" name="title" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-6 py-4 text-sm font-bold text-slate-800">
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Asset Intelligence</label>
                                <select name="video_type" x-model="videoType" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-4 text-xs font-bold uppercase tracking-widest">
                                    <option value="youtube">YouTube Embed</option>
                                    <option value="vimeo">Vimeo Stream</option>
                                    <option value="upload">White-Label (Host on Site)</option>
                                    <option value="embed">Custom Iframe</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Engagement Logic</label>
                                <div class="flex items-center gap-3 bg-slate-50 px-4 py-4 rounded-xl border border-slate-100">
                                    <input type="checkbox" name="is_preview" value="1" class="w-4 h-4 rounded-lg accent-primary">
                                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Open Preview?</span>
                                </div>
                            </div>
                        </div>

                        <!-- Dynamic Input based on Video Type -->
                        <div class="space-y-2" x-show="videoType !== 'upload'">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Asset Locator (URL/ID)</label>
                            <input type="text" name="video_url" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-6 py-4 text-sm font-bold text-slate-800" placeholder="https://youtube.com/watch?v=...">
                        </div>

                        <div class="space-y-2" x-show="videoType === 'upload'">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Institutional Video Upload (MP4/WebM)</label>
                            <input type="file" name="video_file" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-6 py-4 text-sm font-bold text-slate-800">
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Time Commitment</label>
                                <input type="text" name="duration" placeholder="e.g., 45 mins" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-4 text-xs font-bold text-slate-800">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Lesson Mode</label>
                                <div class="flex items-center gap-3 bg-slate-50 px-4 py-4 rounded-xl border border-slate-100">
                                    <input type="checkbox" name="is_pdf_lesson" value="1" class="w-4 h-4 rounded-lg accent-primary">
                                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Integrated PDF?</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Support Dossier (PDF/ZIP/DOC)</label>
                            <input type="file" name="attachment" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-6 py-4 text-sm font-bold text-slate-800">
                        </div>

                        <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all">
                            Authorize Lesson Deployment
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white p-20 rounded-[3rem] text-center border-2 border-dashed border-slate-100">
                <span class="material-icons text-5xl text-slate-200 mb-4">architecture</span>
                <p class="text-slate-400 font-bold uppercase tracking-widest">Curriculum structure is currently undefined.</p>
                <p class="text-slate-300 text-[10px] font-bold mt-2 uppercase">Create your first module to begin deployment.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add Module Modal -->
<div id="module-modal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-6 hidden">
    <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-lg p-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 blur-xl"></div>
        <button onclick="document.getElementById('module-modal').classList.add('hidden')" class="absolute top-8 right-8 text-slate-300 hover:text-slate-600 transition-all">
            <span class="material-icons">close</span>
        </button>
        <h3 class="text-2xl font-bold text-primary mb-2 tracking-tight">Establish New Module</h3>
        <p class="text-slate-500 font-semibold italic text-xs mb-10 uppercase tracking-widest leading-loose">Define a new strategic phase for this curriculum.</p>
        
        <form action="{{ route('admin.modules.store', $course->id) }}" method="POST" class="space-y-8">
            @csrf
            <div class="space-y-4">
                <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Module Designation (Title)</label>
                <input type="text" name="title" required placeholder="e.g., Phase I: Foundation & Strategy" class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all shadow-inner">
            </div>
            <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.15em] shadow-premium hover:-translate-y-1 transition-all flex items-center justify-center gap-4">
                Integrate Module <span class="material-icons text-sm">add_task</span>
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Module Reordering
    const moduleContainer = document.getElementById('module-container');
    if (moduleContainer) {
        new Sortable(moduleContainer, {
            animation: 150,
            handle: '.module-handle',
            ghostClass: 'bg-primary/5',
            onEnd: function() {
                const ids = Array.from(moduleContainer.querySelectorAll('.module-item')).map(el => el.dataset.id);
                fetch('{{ route("admin.modules.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids: ids })
                });
            }
        });
    }

    // Lesson Reordering (within and between modules)
    document.querySelectorAll('.lesson-container').forEach(container => {
        new Sortable(container, {
            group: 'lessons',
            animation: 150,
            handle: '.lesson-handle',
            ghostClass: 'bg-primary/5',
            onEnd: function(evt) {
                const moduleId = evt.to.dataset.moduleId;
                const ids = Array.from(evt.to.querySelectorAll('.lesson-item')).map(el => el.dataset.id);
                
                fetch('{{ route("admin.lessons.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        module_id: moduleId,
                        ids: ids 
                    })
                });
            }
        });
    });
});
</script>
@endpush
@endsection
