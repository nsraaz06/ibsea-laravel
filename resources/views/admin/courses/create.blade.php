@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="mb-10 flex justify-between items-end">
        <div>
            <a href="{{ route('admin.courses.index') }}" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 hover:text-primary transition-all mb-4">
                <span class="material-icons text-xs">arrow_back</span>
                Return to Learning Hub
            </a>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Deploy New Program</h2>
            <p class="text-slate-500 font-semibold italic">Drafting a new educational asset for the IBSEA global network.</p>
        </div>
    </header>

    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        @csrf
        
        <!-- Sidebar: Assets & Pricing -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-10 rounded-[3rem] shadow-premium border-t-8 border-primary sticky top-10">
                <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                    <span class="w-8 h-[2px] bg-accent"></span> Asset Logistics
                </h3>

                <div class="space-y-4">
                    <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Visual Identity (Thumbnail)</label>
                    <div class="relative group">
                        <input type="file" name="thumbnail" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewThumb(this)">
                        <div class="bg-slate-50 border-2 border-dashed border-slate-100 rounded-2xl p-8 text-center group-hover:bg-primary/5 group-hover:border-primary/20 transition-all overflow-hidden relative min-h-[160px] flex flex-col items-center justify-center">
                            <img id="thumb-preview" class="absolute inset-0 w-full h-full object-cover hidden">
                            <div id="thumb-placeholder">
                                <span class="material-icons text-3xl text-slate-300 group-hover:text-primary mb-2">add_a_photo</span>
                                <p class="text-slate-400 font-bold uppercase text-[9px] tracking-widest leading-tight">Click to upload<br>Program banner</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-4">
                    <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Program Pricing (INR)</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 font-bold text-slate-400">₹</span>
                        <input type="number" name="price" value="0" step="0.01" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-12 pr-6 py-4 text-sm font-black text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    </div>
                    <p class="text-[9px] text-slate-400 font-bold italic px-1">Set to 0.00 for Open Access curriculum.</p>
                </div>

                <div class="space-y-4 pt-4">
                    <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Access Protocol</label>
                    <select name="access_type" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                        <option value="free">Free for All Members</option>
                        <option value="paid">Premium (Individual Purchase)</option>
                        <option value="membership">Membership-Linked (Specific Tiers)</option>
                    </select>
                </div>

                <div class="space-y-4 pt-4">
                    <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Certificate Template</label>
                    <select name="certificate_template_id" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all">
                        <option value="">Default Institutional Certificate</option>
                        @foreach($templates as $template)
                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-[9px] text-slate-400 font-bold italic px-1">Design for the auto-generated completion certificate.</p>
                </div>

                <div class="pt-10">
                    <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 transition-all flex items-center justify-center gap-4">
                        Deploy Program <span class="material-icons text-sm">rocket_launch</span>
                    </button>
                    <p class="text-[9px] text-center text-slate-400 font-bold mt-4 uppercase tracking-widest">Initial draft deployment</p>
                </div>
            </div>
        </div>

        <!-- Main Curriculum Details -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-12 rounded-[3.5rem] shadow-premium border border-slate-100">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Program Designation (Title)</label>
                        <input type="text" name="title" required placeholder="e.g., Strategic Leadership in the Global South" class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] px-8 py-6 text-xl font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-inner">
                    </div>

                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Categorization</label>
                            <input type="text" name="category" placeholder="e.g., Mentorship" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-inner">
                        </div>
                        <div class="space-y-4">
                            <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Status</label>
                            <select name="is_published" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-inner">
                                <option value="0">Keep as Strategic Draft</option>
                                <option value="1">Publish Instantly</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Curriculum Narrative (Description)</label>
                        <textarea name="description" rows="12" placeholder="Define the learning objectives, outcomes, and value proposition..." class="w-full bg-slate-50 border border-slate-100 rounded-[2.5rem] px-8 py-8 text-sm font-medium text-slate-700 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-inner leading-relaxed"></textarea>
                    </div>
                </div>
            </div>

            <!-- Helpful Guidance -->
            <div class="bg-amber-50/50 p-10 rounded-[3rem] border border-amber-100 flex items-start gap-6">
                <span class="material-icons text-amber-400">tips_and_updates</span>
                <div>
                    <h4 class="text-xs font-black text-amber-800 uppercase tracking-widest mb-2">Administrative Tip</h4>
                    <p class="text-amber-700/70 text-xs font-bold leading-relaxed">After creating the program, you will be able to define **Learning Modules** and upload **Video Lessons (YouTube/Vimeo)** in the next step.</p>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewThumb(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('thumb-preview').src = e.target.result;
                document.getElementById('thumb-preview').classList.remove('hidden');
                document.getElementById('thumb-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
