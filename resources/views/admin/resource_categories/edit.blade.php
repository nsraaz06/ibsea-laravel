@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="mb-10">
        <a href="{{ route('admin.resource-categories.index') }}" class="text-slate-400 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 hover:text-primary transition-all mb-4">
            <span class="material-icons text-xs">arrow_back</span>
            Intelligence Branches
        </a>
        <h2 class="text-3xl font-bold text-primary tracking-tight">Refine Operational Sector</h2>
        <p class="text-slate-500 font-semibold italic">Update the strategic parameters for this categorization branch.</p>
    </header>

    <div class="max-w-4xl bg-white p-10 md:p-16 rounded-[3rem] shadow-premium border-t-8 border-amber-500 relative overflow-hidden">
        <form action="{{ route('admin.resource-categories.update', $resource_category->id) }}" method="POST" class="space-y-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Sector Name</label>
                    <input type="text" name="name" value="{{ $resource_category->name }}" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all">
                    @error('name') <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Material Icon (ID)</label>
                    <div class="flex gap-4">
                        <input type="text" name="icon" value="{{ $resource_category->icon }}" required class="flex-1 bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all">
                        <div class="w-16 h-[62px] bg-slate-50 border border-slate-100 rounded-2xl flex items-center justify-center text-amber-500">
                            <span class="material-icons text-2xl" id="icon-preview">{{ $resource_category->icon }}</span>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-4">
                    <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Strategic Description</label>
                    <textarea name="description" rows="4" class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] px-8 py-6 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all leading-relaxed">{{ $resource_category->description }}</textarea>
                </div>
            </div>

            <div class="pt-10 flex justify-end">
                <button type="submit" class="bg-amber-500 text-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-4">
                    Update Intelligence Branch <span class="material-icons text-sm">published_with_changes</span>
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
