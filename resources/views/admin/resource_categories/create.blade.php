@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="mb-10">
        <a href="{{ route('admin.resource-categories.index') }}" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 hover:text-primary transition-all mb-4">
            <span class="material-icons text-xs">arrow_back</span>
            Intelligence Branches
        </a>
        <h2 class="text-3xl font-bold text-primary tracking-tight">Define Strategic Sector</h2>
        <p class="text-slate-500 font-semibold italic">Establish a new operational category for institutional dossiers.</p>
    </header>

    <div class="max-w-4xl bg-white p-10 md:p-16 rounded-[3rem] shadow-premium border-t-8 border-primary relative overflow-hidden">
        <form action="{{ route('admin.resource-categories.store') }}" method="POST" class="space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Sector Name</label>
                    <input type="text" name="name" required placeholder="e.g. Maritime Logistics" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                    @error('name') <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Material Icon (ID)</label>
                    <div class="flex gap-4">
                        <input type="text" name="icon" value="auto_stories" required placeholder="e.g. anchor" class="flex-1 bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                        <div class="w-16 h-[62px] bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-primary">
                            <span class="material-icons text-2xl" id="icon-preview">auto_stories</span>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest px-1 italic">Use any <a href="https://fonts.google.com/icons" target="_blank" class="text-primary underline">Google Material Icon</a> name.</p>
                </div>

                <div class="md:col-span-2 space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Strategic Description</label>
                    <textarea name="description" rows="4" placeholder="Briefly summarize the intelligence scope of this sector branch..." class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] px-8 py-6 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all leading-relaxed"></textarea>
                </div>
            </div>

            <div class="pt-10 flex justify-end">
                <button type="submit" class="bg-primary text-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-4">
                    Initialize Sector <span class="material-icons text-sm">rocket_launch</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelector('input[name="icon"]').addEventListener('input', function(e) {
        document.getElementById('icon-preview').textContent = e.target.value || 'auto_stories';
    });
</script>
@endsection
