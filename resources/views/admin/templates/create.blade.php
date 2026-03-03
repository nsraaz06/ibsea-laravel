@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.design-templates.index') }}" class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-slate-400 hover:text-primary transition-all">
            <span class="material-icons">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">New Template</h1>
            <p class="text-slate-500 text-sm">Define the basic properties of your custom document design.</p>
        </div>
    </div>

    <form action="{{ route('admin.design-templates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Name -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Template Name</label>
                    <input type="text" name="name" required placeholder="e.g. Annual Summit Certificate"
                        class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                </div>

                <!-- Type -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Template Type</label>
                    <select name="type" required
                        class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        <option value="certificate">Certificate</option>
                        <option value="id_card">ID Card</option>
                        <option value="ticket">Event Ticket</option>
                    </select>
                </div>
            </div>

            <!-- Background Image -->
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Background Image (PNG/JPG)</label>
                <div class="relative group">
                    <input type="file" name="background" id="background_input" class="hidden" accept="image/*" onchange="previewImage(this)">
                    <label for="background_input" class="flex flex-col items-center justify-center w-full h-64 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl cursor-pointer hover:bg-slate-100 hover:border-primary/30 transition-all overflow-hidden" id="dropzone">
                        <div id="upload_prompt" class="flex flex-col items-center text-center px-6">
                            <span class="material-icons text-slate-300 text-5xl mb-4 group-hover:scale-110 transition-transform">cloud_upload</span>
                            <h4 class="font-bold text-slate-500">Upload Template Base</h4>
                            <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest">Recommended: A4 size for certificates, CR80 for ID cards</p>
                        </div>
                        <img id="image_preview" class="hidden w-full h-full object-contain p-4">
                    </label>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-primary text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    Create & Open Designer
                </button>
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
            prompt.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
