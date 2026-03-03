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
            placeholder: 'Detailed intelligence report goes here...',
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
            <h2 class="text-3xl font-bold text-primary tracking-tight">Refine Mission Dispatch</h2>
            <p class="text-slate-500 font-semibold italic">Update intelligence criteria for "{{ $post->title }}".</p>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="bg-slate-100 text-slate-500 px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-primary hover:text-white transition-all shadow-sm">
            Back to Dispatches Hub
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
        <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
        
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            @csrf
            @method('PUT')
            
            <!-- Metadata & Config Section -->
            <div class="lg:col-span-1 space-y-8">
                <div class="space-y-4">
                    <div class="flex items-center justify-between px-1">
                        <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">Institutional Banner (A4 Ratio)</label>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest italic">Landscape recommended</span>
                    </div>
                    <div class="relative group">
                        <div class="aspect-[297/210] bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-accent/40 relative shadow-inner">
                            @if($post->featured_image)
                                <img id="banner-preview" src="{{ asset($post->featured_image) }}" class="absolute inset-0 w-full h-full object-cover" />
                            @else
                                <div id="banner-placeholder" class="text-center p-6">
                                    <span class="material-icons text-4xl text-slate-200 mb-2">add_photo_alternate</span>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Upload Banner</p>
                                </div>
                                <img id="banner-preview" class="absolute inset-0 w-full h-full object-cover hidden" />
                            @endif
                        </div>
                        <input type="file" name="featured_image" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewBanner(this)">
                    </div>
                </div>

                <div class="bg-slate-50/80 backdrop-blur-sm p-8 rounded-[2rem] border border-slate-100 space-y-8 shadow-inner">
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] block px-1">Dispatch Status</label>
                        <select name="status" class="w-full bg-white border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all shadow-sm cursor-pointer appearance-none">
                            <option value="Published" {{ $post->status === 'Published' ? 'selected' : '' }}>Broadcast (Published)</option>
                            <option value="Draft" {{ $post->status === 'Draft' ? 'selected' : '' }}>Archive (Draft)</option>
                        </select>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] block px-1">Mission Category</label>
                        <select name="category" class="w-full bg-white border border-slate-200 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all shadow-sm cursor-pointer appearance-none">
                            <option value="News" {{ $post->category === 'News' ? 'selected' : '' }}>News Dispatch</option>
                            <option value="Blog" {{ $post->category === 'Blog' ? 'selected' : '' }}>Leadership Blog</option>
                            <option value="Announcement" {{ $post->category === 'Announcement' ? 'selected' : '' }}>Key Announcement</option>
                        </select>
                    </div>

                    <label class="flex items-center justify-between cursor-pointer group bg-white/80 p-6 rounded-2xl border border-transparent hover:border-accent/20 transition-all shadow-sm">
                        <div class="pr-4">
                            <div class="text-[11px] font-black text-slate-800 uppercase tracking-widest">Feature Broadcast</div>
                            <div class="text-[10px] font-semibold text-slate-400 leading-tight">Elevate to homepage slider.</div>
                        </div>
                        <div class="relative inline-flex items-center">
                            <input type="checkbox" name="show_on_slider" value="1" {{ $post->show_on_slider ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-12 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-accent after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all shadow-inner"></div>
                        </div>
                    </label>
                </div>

                <!-- SEO Section -->
                <div class="bg-primary/5 p-8 rounded-[2rem] border border-primary/10 space-y-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-icons text-primary text-sm">search</span>
                        <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em]">SEO Configuration</h3>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block px-1">URL Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}" class="w-full bg-white border border-slate-200 rounded-xl px-5 py-3 text-xs font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block px-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" class="w-full bg-white border border-slate-200 rounded-xl px-5 py-3 text-xs font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block px-1">Meta Keywords</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $post->meta_keywords) }}" class="w-full bg-white border border-slate-200 rounded-xl px-5 py-3 text-xs font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block px-1">Meta Description</label>
                        <textarea name="meta_description" rows="3" class="w-full bg-white border border-slate-200 rounded-xl px-5 py-3 text-xs font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="lg:col-span-2 space-y-10">
                <div class="space-y-4">
                    <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] px-1">Dispatch Intelligence Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-lg font-bold text-slate-800 placeholder:text-slate-300 focus:bg-white focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all shadow-inner">
                </div>

                <div class="space-y-4">
                    <label class="text-[11px] font-black text-primary uppercase tracking-[0.2em] px-1">Mission Intel Content</label>
                    <textarea name="content" id="editor" class="w-full">{{ old('content', $post->content) }}</textarea>
                </div>

                <div class="pt-10 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:bg-accent hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-4">
                        Refine Intelligence Dispatch <span class="material-icons text-sm">rocket_launch</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewBanner(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('banner-preview');
                const placeholder = document.getElementById('banner-placeholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto-generate slug (only if title is changed and slug is empty or matches previous title slug)
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
