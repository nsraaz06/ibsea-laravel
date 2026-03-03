@extends('layouts.admin')

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        border-radius: 2rem !important;
        border: 1px solid #f1f5f9 !important;
        background: #f8fafc !important;
        overflow: hidden;
    }
    .note-toolbar {
        background: #f8fafc !important;
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 1rem !important;
    }
</style>
@endpush

@push('scripts')
<!-- jQuery (required for Summernote) -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editor').summernote({
            placeholder: 'Detailed initiative content goes here...',
            tabsize: 2,
            height: 500,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6']
        });
    });
</script>
@endpush

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Launch Strategic Initiative</h2>
            <p class="text-slate-500 font-semibold italic">Initialize a new key focus area for the institution.</p>
        </div>
        <a href="{{ route('admin.initiatives.index') }}" class="bg-slate-100 text-slate-500 px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-primary hover:text-white transition-all shadow-sm">
            Back to Initiatives Hub
        </a>
    </header>

    @if ($errors->any())
        <div class="bg-red-50/50 backdrop-blur-sm text-red-600 p-8 rounded-[2.5rem] mb-10 border border-red-100 flex items-start gap-4">
            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-icons">report_problem</span>
            </div>
            <div>
                <h3 class="font-black uppercase text-[10px] tracking-widest mb-1">Attention Required</h3>
                <ul class="list-disc pl-5 text-sm font-semibold opacity-80">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white p-10 md:p-16 rounded-[2.5rem] shadow-premium border-t-8 border-primary relative overflow-hidden">
        <form action="{{ route('admin.initiatives.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Left Column: Settings & Assets -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Banner Upload -->
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] block px-1">Institutional Banner</label>
                        <div class="relative group">
                            <div class="aspect-video bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-primary/40 relative shadow-inner">
                                <div id="banner-placeholder" class="text-center p-6">
                                    <span class="material-icons text-4xl text-slate-200 mb-2">add_photo_alternate</span>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Upload Banner</p>
                                </div>
                                <img id="banner-preview" class="absolute inset-0 w-full h-full object-cover hidden" />
                            </div>
                            <input type="file" name="banner" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this, 'banner-preview', 'banner-placeholder')">
                        </div>
                    </div>

                    <!-- Logo Upload -->
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] block px-1">Institutional Logo / Badge</label>
                        <div class="relative group">
                            <div class="w-full h-32 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-primary/40 relative shadow-inner">
                                <div id="logo-placeholder" class="text-center p-4">
                                    <span class="material-icons text-3xl text-slate-200 mb-1">add_circle</span>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Small Badge / Logo</p>
                                </div>
                                <img id="logo-preview" class="absolute inset-0 w-full h-full object-contain p-4 hidden" />
                            </div>
                            <input type="file" name="logo" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this, 'logo-preview', 'logo-placeholder')">
                        </div>
                    </div>

                    <!-- PDF Upload -->
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] block px-1">Initiative PDF Dossier</label>
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 flex items-center gap-4 group hover:border-red-500/30 transition-all">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-red-500 shadow-sm border border-slate-100 transition-transform group-hover:scale-110">
                                <span class="material-icons">picture_as_pdf</span>
                            </div>
                            <div class="flex-1">
                                <input type="file" name="pdf" class="w-full text-xs font-bold text-slate-500 cursor-pointer file:hidden">
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Select PDF (Max 10MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- YouTube Project Video -->
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] block px-1">YouTube Project Video</label>
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 flex items-center gap-4 group hover:border-red-500/30 transition-all">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-red-600 shadow-sm border border-slate-100 transition-transform group-hover:scale-110">
                                <span class="material-icons">play_circle</span>
                            </div>
                            <div class="flex-1">
                                <input type="text" name="youtube_link" value="{{ old('youtube_link') }}" class="w-full bg-transparent border-none p-0 text-xs font-bold text-slate-600 focus:ring-0 placeholder:text-slate-300" placeholder="https://youtube.com/watch?v=...">
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Video Roadmap Link</p>
                            </div>
                        </div>
                    </div>

                    <!-- General Settings -->
                    <div class="bg-slate-50/80 backdrop-blur-sm p-8 rounded-[2rem] border border-slate-100 space-y-8 shadow-inner">
                        <div class="space-y-4">
                            <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] block px-1">Material Icon</label>
                            <div class="flex gap-4">
                                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-primary shadow-sm border border-slate-100">
                                    <span id="icon-preview" class="material-icons text-2xl">flag</span>
                                </div>
                                <input type="text" name="icon" id="icon-input" value="flag" class="flex-1 bg-white border border-slate-200 rounded-xl px-5 text-sm font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all uppercase" placeholder="e.g. school, hub, flag">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] block px-1">Manual Sort Order</label>
                            <input type="number" name="sort_order" value="0" class="w-full bg-white border border-slate-200 rounded-xl px-6 py-4 text-sm font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm">
                        </div>

                        <label class="flex items-center justify-between cursor-pointer group bg-white/80 p-6 rounded-2xl border border-transparent hover:border-primary/20 transition-all shadow-sm">
                            <div class="pr-4">
                                <div class="text-[11px] font-black text-slate-800 uppercase tracking-widest">Active Status</div>
                                <div class="text-[10px] font-semibold text-slate-400 leading-tight">Visible in menu and home.</div>
                            </div>
                            <div class="relative inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                                <div class="w-12 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-primary after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all shadow-inner"></div>
                            </div>
                        </label>
                    </div>

                    <!-- SEO & Custom Routing -->
                    <div class="bg-primary/5 p-8 rounded-[2rem] border border-primary/10 space-y-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block px-1">URL Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required class="w-full bg-white border border-slate-200 rounded-xl px-5 py-3 text-xs font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block px-1">Custom Landing Page URL</label>
                            <input type="text" name="custom_url" value="{{ old('custom_url') }}" class="w-full bg-white border border-slate-200 rounded-xl px-5 py-3 text-xs font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all" placeholder="e.g. /pages/my-page or https://...">
                            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mt-1">If set, this will override the default page.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Content & Organizer -->
                <div class="lg:col-span-2 space-y-10">
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] px-1">Initiative Headline</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Center of Excellence (CoE)" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-lg font-bold text-slate-800 placeholder:text-slate-300 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-inner">
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] px-1">Summary (Short Description)</label>
                        <textarea name="summary" rows="3" required placeholder="A brief description for the homepage tabs..." class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-4 text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-inner">{{ old('summary') }}</textarea>
                    </div>

                    <!-- Organizer Info -->
                    <div class="bg-slate-50/50 p-10 rounded-[2.5rem] border border-slate-100 grid md:grid-cols-2 gap-8">
                        <div class="md:col-span-2">
                             <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] mb-2 px-1">Organizer / Head Details</h3>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="relative group w-32 h-32 mx-auto md:mx-0">
                                <div class="w-full h-full rounded-full bg-white border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-primary/40 relative">
                                    <div id="org-placeholder" class="text-center p-2">
                                        <span class="material-icons text-2xl text-slate-200">person_add</span>
                                    </div>
                                    <img id="org-preview" class="absolute inset-0 w-full h-full object-cover hidden" />
                                </div>
                                <input type="file" name="organizer_image" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this, 'org-preview', 'org-placeholder')">
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block px-1">Organizer Name</label>
                                <input type="text" name="organizer_name" value="{{ old('organizer_name') }}" class="w-full bg-white border border-slate-200 rounded-xl px-5 py-3 text-xs font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block px-1">Role / Designation</label>
                                <input type="text" name="organizer_role" value="{{ old('organizer_role') }}" class="w-full bg-white border border-slate-200 rounded-xl px-5 py-3 text-xs font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block px-1">Email Address</label>
                            <input type="email" name="organizer_email" value="{{ old('organizer_email') }}" class="w-full bg-white border border-slate-200 rounded-xl px-5 py-3 text-xs font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block px-1">LinkedIn Profile (URL)</label>
                            <input type="text" name="organizer_linkedin" value="{{ old('organizer_linkedin') }}" class="w-full bg-white border border-slate-200 rounded-xl px-5 py-3 text-xs font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] px-1">Main Detailed Content</label>
                        <textarea name="content" id="editor" class="w-full">{{ old('content') }}</textarea>
                    </div>

                    <div class="pt-10 flex justify-end">
                        <button type="submit" class="bg-primary text-secondary px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:bg-black hover:text-white hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-4">
                            Launch Initiative <span class="material-icons text-sm">rocket_launch</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input, previewId, placeholderId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Icon preview
    document.getElementById('icon-input').addEventListener('input', function() {
        document.getElementById('icon-preview').innerText = this.value || 'flag';
    });

    // Auto-generate slug
    document.getElementById('title').addEventListener('input', function() {
        const slugInput = document.getElementById('slug');
        if (slugInput && this.value) {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });
</script>
@endsection
