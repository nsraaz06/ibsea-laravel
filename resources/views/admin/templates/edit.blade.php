@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.design-templates.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-slate-400 hover:text-primary transition-all">
            <span class="material-icons">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Edit Template</h1>
            <p class="text-slate-500 text-sm">Update the basic settings for <strong>{{ $designTemplate->name }}</strong>.</p>
        </div>
    </div>

    <form action="{{ route('admin.design-templates.update', $designTemplate->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 space-y-8">
            
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                    <ul class="list-disc list-inside text-red-700 text-sm font-bold">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Name -->
                <div class="space-y-2 md:col-span-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Template Name</label>
                    <input type="text" name="name" required value="{{ old('name', $designTemplate->name) }}"
                        class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                </div>

                <!-- Type -->
                <div class="space-y-2 md:col-span-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Template Type</label>
                    <select name="type" required
                        class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        <option value="certificate" {{ $designTemplate->type == 'certificate' ? 'selected' : '' }}>Certificate</option>
                        <option value="id_card" {{ $designTemplate->type == 'id_card' ? 'selected' : '' }}>ID Card</option>
                        <option value="ticket" {{ $designTemplate->type == 'ticket' ? 'selected' : '' }}>Event Ticket</option>
                    </select>
                </div>

                <!-- Width -->
                <div class="space-y-2 md:col-span-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Canvas Width (px)</label>
                    <input type="number" name="width" value="{{ old('width', $designTemplate->width) }}"
                        class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                </div>

                <!-- Height -->
                <div class="space-y-2 md:col-span-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Canvas Height (px)</label>
                    <input type="number" name="height" value="{{ old('height', $designTemplate->height) }}"
                        class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                </div>
            </div>

            <!-- Background Image -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Update Background Image (Leave blank to keep current)</label>
                <div class="relative group">
                    <input type="file" name="background" id="background_input" class="hidden" accept="image/*" onchange="previewImage(this)">
                    <label for="background_input" class="flex flex-col items-center justify-center w-full h-64 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl cursor-pointer hover:bg-slate-100 hover:border-primary/30 transition-all overflow-hidden" id="dropzone">
                        @if($designTemplate->background_path)
                            <img id="image_preview" src="{{ $designTemplate->background_url }}" class="w-full h-full object-contain p-4">
                            <div id="upload_prompt" class="hidden flex flex-col items-center text-center px-6">
                                <span class="material-icons text-slate-300 text-5xl mb-4 group-hover:scale-110 transition-transform">cloud_upload</span>
                                <h4 class="font-bold text-slate-500">Replace Template Base</h4>
                            </div>
                        @else
                            <div id="upload_prompt" class="flex flex-col items-center text-center px-6">
                                <span class="material-icons text-slate-300 text-5xl mb-4 group-hover:scale-110 transition-transform">cloud_upload</span>
                                <h4 class="font-bold text-slate-500">Upload Template Base</h4>
                            </div>
                            <img id="image_preview" class="hidden w-full h-full object-contain p-4">
                        @endif
                    </label>
                </div>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="flex-1 bg-primary text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    Save Changes
                </button>
                <a href="{{ route('admin.design-templates.builder', $designTemplate->id) }}" 
                   class="flex-1 bg-slate-800 text-white py-4 rounded-2xl font-black uppercase tracking-widest text-center shadow-lg shadow-slate-800/20 hover:scale-[1.02] active:scale-95 transition-all">
                    Open Designer
                </a>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image_preview');
    const prompt = document.getElementById('upload_prompt');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if(prompt) prompt.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
