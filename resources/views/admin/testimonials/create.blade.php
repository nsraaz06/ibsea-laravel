@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.testimonials.index') }}" class="w-10 h-10 rounded-xl bg-white shadow-sm border border-slate-200 flex items-center justify-center text-slate-500 hover:text-primary transition-colors">
            <span class="material-icons">arrow_back</span>
        </a>
        <div>
            <h2 class="text-3xl font-black text-secondary tracking-tight">Add Testimonial</h2>
            <p class="text-slate-500 font-medium mt-1">Highlight a member's experience on the homepage.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-6 py-4 rounded-2xl mb-8">
            <div class="font-bold flex items-center gap-2 mb-2">
                <span class="material-icons">error_outline</span> Please fix the following errors:
            </div>
            <ul class="list-disc pl-8 space-y-1 text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-premium border border-slate-100 p-8">
        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Member Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-medium text-slate-700" required>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Designation & Company</label>
                    <input type="text" name="designation" value="{{ old('designation') }}" placeholder="e.g. Founder, Tech Sol" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-medium text-slate-700">
                </div>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Testimonial Content *</label>
                <textarea name="content" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-700 font-medium" required>{{ old('content') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Profile Image (1:1 Ratio Ideal)</label>
                    <input type="file" name="image" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-medium text-slate-700">
                </div>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" class="w-5 h-5 rounded border-slate-300 text-primary focus:ring-primary" {{ old('is_active', true) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm font-bold text-slate-700 cursor-pointer">Visible on Homepage</label>
            </div>

            <div class="pt-8 border-t border-slate-100 flex justify-end">
                <button type="submit" class="bg-primary text-white px-8 py-4 rounded-xl font-bold hover:bg-blue-800 transition-all shadow-premium flex items-center gap-2">
                    <span class="material-icons">save</span> Create Testimonial
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
