@extends('layouts.admin')

@section('content')
<div class="p-10 max-w-4xl mx-auto">
    <header class="mb-10">
        <a href="{{ route('admin.plans.index') }}" class="inline-flex items-center text-slate-400 hover:text-primary mb-4 transition-colors">
            <span class="material-icons text-sm mr-2">arrow_back</span> Back to Architecture
        </a>
        <h2 class="text-3xl font-bold text-primary tracking-tight">Refine Intelligence</h2>
        <p class="text-slate-500 font-semibold italic">Adjusting value propositions for the {{ $plan->title }}.</p>
    </header>

    <div class="bg-white rounded-[2.5rem] shadow-premium p-10">
        <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- ID (Read only) -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block ml-4">Architectural ID (Locked)</label>
                    <input type="text" value="{{ $plan->id }}" class="w-full bg-slate-100 border-none rounded-2xl p-4 font-bold text-slate-400 cursor-not-allowed" disabled title="ID cannot be changed">
                </div>

                <!-- Title -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block ml-4">Display Title</label>
                    <input type="text" name="title" value="{{ old('title', $plan->title) }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-800 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="e.g. Booster Membership" required>
                    @error('title') <p class="text-red-500 text-[10px] font-bold uppercase ml-4 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tagline -->
                <div class="space-y-2 md:col-span-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block ml-4">Thematic Tagline</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $plan->tagline) }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-800 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="e.g. Start Growing Your Business with IBSEA">
                </div>

                <!-- Fee -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block ml-4">Fee Strategy (₹)</label>
                    <input type="number" name="fee_numeric" value="{{ old('fee_numeric', $plan->fee_numeric) }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-800 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="e.g. 1999" required>
                </div>

                <!-- Validity -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block ml-4">Validity Horizon (Days)</label>
                    <input type="number" name="validity_days" value="{{ old('validity_days', $plan->validity_days) }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-800 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="e.g. 365" required>
                </div>

                <!-- Event Passes -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-primary uppercase tracking-widest block ml-4">Event Pass Limit (Quota)</label>
                    <input type="number" name="event_passes_limit" value="{{ old('event_passes_limit', $plan->event_passes_limit) }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-800 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="e.g. 3" required>
                    <p class="text-[9px] text-slate-400 font-bold uppercase mt-1 ml-4">Free event tickets per annual cycle</p>
                </div>

                <!-- Theme -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block ml-4">Visual Theme</label>
                    <select name="theme" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-800 focus:ring-2 focus:ring-primary/20 transition-all">
                        <option value="primary" {{ $plan->theme == 'primary' ? 'selected' : '' }}>Primary (Teal)</option>
                        <option value="secondary" {{ $plan->theme == 'secondary' ? 'selected' : '' }}>Secondary (Blue)</option>
                        <option value="gold" {{ $plan->theme == 'gold' ? 'selected' : '' }}>Gold (Amber)</option>
                        <option value="platinum" {{ $plan->theme == 'platinum' ? 'selected' : '' }}>Platinum (Slate)</option>
                    </select>
                </div>

                <!-- ID Card Template -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block ml-4">ID Card Design</label>
                    <select name="id_card_template_id" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-800 focus:ring-2 focus:ring-primary/20 transition-all text-slate-600">
                        <option value="">Default Blade Design</option>
                        @foreach($idCardTemplates as $tmpl)
                            <option value="{{ $tmpl->id }}" {{ $plan->id_card_template_id == $tmpl->id ? 'selected' : '' }}>{{ $tmpl->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Certificate Template -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block ml-4">Certificate Design</label>
                    <select name="certificate_template_id" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-slate-800 focus:ring-2 focus:ring-primary/20 transition-all text-slate-600">
                        <option value="">Default Blade Design</option>
                        @foreach($certificateTemplates as $tmpl)
                            <option value="{{ $tmpl->id }}" {{ $plan->certificate_template_id == $tmpl->id ? 'selected' : '' }}>{{ $tmpl->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- JSON Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="text-[10px] font-black text-primary uppercase tracking-widest block ml-4 mb-2">Core Benefits (One per line)</label>
                    <textarea name="benefits_json" rows="4" class="w-full bg-slate-50 border-none rounded-2xl p-6 font-semibold text-slate-600 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Enter benefits, each on a new line...">{{ old('benefits_json', $formData['benefits_json'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="text-[10px] font-black text-accent uppercase tracking-widest block ml-4 mb-2">Strategic Highlights (One per line)</label>
                    <textarea name="highlights_json" rows="4" class="w-full bg-slate-50 border-none rounded-2xl p-6 font-semibold text-slate-600 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Enter highlights, each on a new line...">{{ old('highlights_json', $formData['highlights_json'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block ml-4 mb-2">Impact Statistics (Value | Label | Icon)</label>
                    <textarea name="stats_json" rows="4" class="w-full bg-slate-50 border-none rounded-2xl p-6 font-semibold text-slate-600 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="e.g. 50+ | Hours Training | school">{{ old('stats_json', $formData['stats_json'] ?? '') }}</textarea>
                    <p class="text-[9px] text-slate-400 font-bold uppercase mt-2 ml-4">Format: Value | Label | Material Icon (One per line)</p>
                </div>

                <div>
                    <label class="text-[10px] font-black text-ibsea-green uppercase tracking-widest block ml-4 mb-2">Detailed Value Propositions (JSON Code)</label>
                    <textarea name="detailed_benefits_json" rows="6" class="w-full bg-slate-50 border-none rounded-2xl p-6 font-mono text-xs text-slate-600 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Enter complex JSON here...">{{ old('detailed_benefits_json', $formData['detailed_benefits_json'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="text-[10px] font-black text-ibsea-navy uppercase tracking-widest block ml-4 mb-2">Premium Features (JSON Code)</label>
                    <textarea name="premium_features_json" rows="6" class="w-full bg-slate-50 border-none rounded-2xl p-6 font-mono text-xs text-slate-600 focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Enter complex JSON here...">{{ old('premium_features_json', $formData['premium_features_json'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-primary text-white py-6 rounded-3xl font-bold text-xs uppercase tracking-widest hover:bg-secondary shadow-xl shadow-primary/20 transition-all flex items-center justify-center gap-3">
                    <span class="material-icons">auto_fix_high</span> Update Intelligence Parameters
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
