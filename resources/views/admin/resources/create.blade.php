@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="mb-10">
        <a href="{{ route('admin.resources.index') }}" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 hover:text-primary transition-all mb-4">
            <span class="material-icons text-xs">arrow_back</span>
            Return to Hub
        </a>
        <h2 class="text-3xl font-bold text-primary tracking-tight">Deploy Strategic Resource</h2>
        <p class="text-slate-500 font-semibold italic">Upload mission-critical intelligence for our global alliance.</p>
    </header>

    <div class="max-w-4xl bg-white p-10 md:p-16 rounded-[3rem] shadow-premium border-t-8 border-primary relative overflow-hidden">
        <div id="upload-status" class="hidden mb-10 p-8 rounded-[2rem] border animate-pulse">
            <div class="flex items-center justify-between mb-4">
                <span id="status-text" class="text-[10px] font-black uppercase tracking-widest text-primary">Uploading Intelligence Document...</span>
                <span id="percent-text" class="text-[10px] font-black uppercase tracking-widest text-primary">0%</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden shadow-inner">
                <div id="progress-bar" class="bg-primary h-full w-0 transition-all duration-300 shadow-[0_0_15px_rgba(0,74,149,0.4)]"></div>
            </div>
        </div>

        <form id="resource-upload-form" action="{{ route('admin.resources.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Resource Title</label>
                    <input type="text" name="title" required placeholder="e.g. Export Policy Index 2026" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                </div>

                <div class="space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Strategic Global Sector</label>
                    <select name="category_id" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Dossier / Description</label>
                    <textarea name="description" rows="4" placeholder="Briefly summarize the intelligence contained in this document..." class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] px-8 py-6 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all leading-relaxed"></textarea>
                </div>

                <div class="md:col-span-2 space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Institutional Document (PDF/DOC/ZIP)</label>
                    <div class="relative group">
                        <input type="file" name="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] p-12 text-center group-hover:bg-primary/5 group-hover:border-primary/30 transition-all">
                            <span class="material-icons text-5xl text-slate-300 group-hover:text-primary transition-all mb-4">cloud_upload</span>
                            <p class="text-slate-500 font-bold uppercase text-[11px] tracking-widest">Select file or drag & drop</p>
                            <p class="text-[10px] text-slate-400 font-bold mt-2">Maximum file size: 100MB</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Manual Cover Image (Optional)</label>
                    <div class="relative group">
                        <input type="file" name="cover_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewCover(this)">
                        <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] p-8 text-center group-hover:bg-primary/5 group-hover:border-primary/30 transition-all relative overflow-hidden">
                            <div id="cover-placeholder">
                                <span class="material-icons text-4xl text-slate-300 group-hover:text-primary transition-all mb-2">add_photo_alternate</span>
                                <p class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Upload Custom Cover</p>
                                <p class="text-[9px] text-slate-400 font-bold mt-1 italic">Leave blank to auto-generate from dossier</p>
                            </div>
                            <img id="cover-preview" class="absolute inset-0 w-full h-full object-cover hidden" />
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 pt-6">
                    <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-black text-slate-800 uppercase tracking-tight">Immediate Deployment</p>
                            <p class="text-[10px] text-slate-400 font-bold italic uppercase tracking-widest">Make this resource visible to members instantly</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-ibsea-green"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-10 flex justify-end">
                <button type="submit" class="bg-primary text-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-4">
                    Deploy Resource <span class="material-icons text-sm">rocket_launch</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('resource-upload-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        const progressBar = document.getElementById('progress-bar');
        const percentText = document.getElementById('percent-text');
        const statusDiv = document.getElementById('upload-status');
        const submitBtn = form.querySelector('button[type="submit"]');

        // Show Progress
        statusDiv.classList.remove('hidden', 'bg-red-50', 'border-red-100', 'bg-green-50', 'border-green-100');
        statusDiv.classList.add('bg-primary/5', 'border-primary/10');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Starting Upload... <span class="material-icons animate-spin text-sm">sync</span>';

        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                percentText.textContent = percent + '%';
                
                if (percent === 100) {
                    document.getElementById('status-text').textContent = 'Processing & Optimizing File...';
                }
            }
        });

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200 || xhr.status === 201 || (xhr.status === 302 && xhr.getResponseHeader('Location'))) {
                    // Success or Redirect
                    statusDiv.classList.replace('bg-primary/5', 'bg-green-50');
                    statusDiv.classList.replace('border-primary/10', 'border-green-100');
                    document.getElementById('status-text').textContent = 'Success: Document Uploaded.';
                    document.getElementById('status-text').classList.replace('text-primary', 'text-green-600');
                    submitBtn.classList.replace('bg-primary', 'bg-green-600');
                    submitBtn.innerHTML = 'Success <span class="material-icons text-sm">verified</span>';
                    
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.resources.index') }}";
                    }, 1000);
                } else {
                    // Error handle
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Retry Upload <span class="material-icons text-sm">rocket_launch</span>';
                    statusDiv.classList.replace('bg-primary/5', 'bg-red-50');
                    statusDiv.classList.replace('border-primary/10', 'border-red-100');
                    statusDiv.classList.remove('animate-pulse');
                    
                    if (xhr.status === 413) {
                        document.getElementById('status-text').textContent = 'Error: File exceeds server limits (128MB).';
                    } else if (xhr.status === 500) {
                        document.getElementById('status-text').textContent = 'Server Error: The dossier could not be processed.';
                    } else {
                        document.getElementById('status-text').textContent = 'Upload Failed: Check your connection or file size.';
                    }

                    document.getElementById('status-text').classList.replace('text-primary', 'text-red-600');
                    percentText.classList.add('hidden');

                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            alert(Object.values(response.errors).flat().join('\n'));
                        }
                    } catch(e) {}
                }
            }
        };

        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(formData);
    });

    function previewCover(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('cover-preview');
                const placeholder = document.getElementById('cover-placeholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
