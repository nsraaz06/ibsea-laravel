@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Design New Form Protocol</h2>
            <p class="text-slate-500 font-medium">Define fields and settings for your strategic data collection.</p>
        </div>
        <a href="{{ route('admin.forms.index') }}" class="text-slate-500 hover:text-primary transition-all flex items-center gap-2 font-bold text-sm">
            <span class="material-icons text-lg">arrow_back</span>
            Back to Registry
        </a>
    </header>

    <form action="{{ route('admin.forms.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        @csrf
        
        <!-- Form Settings -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 sticky top-8">
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight mb-6 flex items-center gap-2">
                    <span class="material-icons text-primary text-xl">settings</span>
                    Protocol Settings
                </h3>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Form Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Founder Intake Form" 
                            class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Description</label>
                        <textarea name="description" rows="3" placeholder="Brief context for the user..." 
                            class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">{{ old('description') }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Success Message</label>
                        <input type="text" name="settings[success_message]" value="{{ old('settings.success_message', 'Intelligence logged successfully.') }}" 
                            class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Featured Banner Image</label>
                        <p class="text-[10px] text-slate-400 px-1 -mt-1">Recommended: 1920×1080px. Shown at top of public form.</p>
                        <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center cursor-pointer hover:border-primary transition-all" onclick="document.getElementById('featured_image_input').click()">
                            <span class="material-icons text-slate-300 text-3xl block mb-1">add_photo_alternate</span>
                            <p class="text-xs font-bold text-slate-400">Click to upload image</p>
                            <p id="fi_name" class="text-xs font-bold text-primary mt-1 hidden"></p>
                        </div>
                        <input type="file" id="featured_image_input" name="featured_image" accept="image/*" class="sr-only"
                            onchange="document.getElementById('fi_name').textContent = this.files[0].name; document.getElementById('fi_name').classList.remove('hidden');">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1 flex items-center gap-2">
                            <span class="material-icons text-sm text-primary">mark_email_read</span>
                            Confirmation Email Field
                        </label>
                        <p class="text-[10px] text-slate-400 px-1 -mt-1">Enter the <strong>Field Key</strong> of the email field whose address receives the auto-confirm email. Leave blank to auto-detect first email field.</p>
                        <input type="text" name="settings[confirmation_email_field]" 
                            value="{{ old('settings.confirmation_email_field') }}"
                            id="confirm_email_key"
                            placeholder="e.g. email_id"
                            class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all font-mono">
                        <div id="email_fields_hint" class="text-[10px] text-slate-400 px-1"></div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1 flex items-center gap-2">
                            <span class="material-icons text-sm text-primary">email</span>
                            Confirmation Template
                        </label>
                        <p class="text-[10px] text-slate-400 px-1 -mt-1">Select the email template to send. If none selected, a default summary will be sent.</p>
                        <select name="settings[confirmation_template_id]" 
                            class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            <option value="">— Use Default Summary —</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}" {{ old('settings.confirmation_template_id') == $template->id ? 'selected' : '' }}>
                                    {{ $template->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border-2 border-slate-100">
                        <input type="checkbox" name="is_active" id="is_active" checked class="w-5 h-5 text-primary border-slate-300 rounded focus:ring-primary">
                        <label for="is_active" class="text-xs font-black text-slate-700 uppercase tracking-widest flex-1">Is Active (Live)</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Field Builder -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight flex items-center gap-2">
                        <span class="material-icons text-primary text-xl">build_circle</span>
                        Field Architecture
                    </h3>
                    <button type="button" onclick="addField()" class="bg-slate-900 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest active:scale-95 transition-all flex items-center gap-2">
                        <span class="material-icons text-sm">add</span>
                        Add Field
                    </button>
                </div>

                <div id="fields-container" class="space-y-6">
                    <!-- Fields will be injected here -->
                </div>

                <div class="mt-12 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-12 py-5 rounded-2xl font-black uppercase tracking-widest shadow-2xl shadow-primary/20 hover:-translate-y-1 transition-all active:scale-95 flex items-center gap-3">
                        Initialize Protocol
                        <span class="material-icons">send</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Field Template -->
<template id="field-template">
    <div class="field-row p-6 bg-slate-50 rounded-[2rem] border-2 border-slate-100 relative group animate-fade-in" data-index="{INDEX}">
        <button type="button" onclick="removeField(this)" class="absolute -right-3 -top-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-all active:scale-90">
            <span class="material-icons text-sm">close</span>
        </button>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Label -->
            <div class="space-y-2">
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-1">Label</label>
                <input type="text" name="fields[{INDEX}][label]" required placeholder="e.g. Full Name" 
                    class="w-full bg-white border-none rounded-xl px-5 py-3 text-xs font-bold focus:ring-2 focus:ring-primary transition-all">
            </div>

            <!-- Type -->
            <div class="space-y-2">
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-1">Field Type</label>
                <select name="fields[{INDEX}][type]" required onchange="handleTypeChange(this)"
                    class="w-full bg-white border-none rounded-xl px-5 py-3 text-xs font-bold focus:ring-2 focus:ring-primary transition-all field-type-select">
                    <optgroup label="── Basic Text ──">
                        <option value="text">Short Text</option>
                        <option value="email">Email Address</option>
                        <option value="password">Password</option>
                        <option value="number">Number</option>
                        <option value="tel">Phone / Tel</option>
                        <option value="url">URL / Link</option>
                        <option value="search">Search</option>
                        <option value="hidden">Hidden</option>
                    </optgroup>
                    <optgroup label="── Date & Time ──">
                        <option value="date">Date Picker</option>
                        <option value="datetime-local">Date & Time</option>
                        <option value="time">Time Picker</option>
                        <option value="month">Month Picker</option>
                        <option value="week">Week Picker</option>
                    </optgroup>
                    <optgroup label="── Selection ──">
                        <option value="select">Dropdown (Single)</option>
                        <option value="select_multiple">Dropdown (Multiple)</option>
                        <option value="radio">Radio Buttons</option>
                        <option value="checkbox_group">Checkbox Group</option>
                        <option value="toggle">Toggle / Switch</option>
                    </optgroup>
                    <optgroup label="── Text Area ──">
                        <option value="textarea">Paragraph / Textarea</option>
                        <option value="wysiwyg">Rich Text (WYSIWYG)</option>
                    </optgroup>
                    <optgroup label="── File Upload ──">
                        <option value="file">File Upload</option>
                        <option value="image">Image Upload</option>
                        <option value="file_multiple">Multiple Files</option>
                    </optgroup>
                </select>
            </div>

            <!-- DB Key -->
            <div class="space-y-2">
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-1">Field Key (Unique)</label>
                <input type="text" name="fields[{INDEX}][name]" required placeholder="e.g. full_name" 
                    class="w-full bg-white border-none rounded-xl px-5 py-3 text-xs font-bold focus:ring-2 focus:ring-primary transition-all">
            </div>

            <!-- Placeholder -->
            <div class="space-y-2 field-placeholder-wrapper">
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-1">Placeholder</label>
                <input type="text" name="fields[{INDEX}][placeholder]" placeholder="e.g. Enter your full name..." 
                    class="w-full bg-white border-none rounded-xl px-5 py-3 text-xs font-bold focus:ring-2 focus:ring-primary transition-all">
            </div>

            <!-- Required checkbox -->
            <div class="md:col-span-2 flex items-center gap-6 pt-4">
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="fields[{INDEX}][required]" value="1" id="req_{INDEX}" class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary">
                    <label for="req_{INDEX}" class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Mandatory</label>
                </div>
            </div>

            <!-- Options (for select, radio, checkbox_group) -->
            <div class="md:col-span-3 hidden field-options-wrapper">
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-1 mb-2 block">Options (one per line or comma-separated)</label>
                <textarea name="fields[{INDEX}][options]" rows="3" placeholder="Option 1&#10;Option 2&#10;Option 3"
                    class="w-full bg-white border-none rounded-xl px-5 py-3 text-xs font-bold focus:ring-2 focus:ring-primary transition-all"></textarea>
            </div>

            <!-- File accept (for file/image) -->
            <div class="md:col-span-3 hidden field-file-wrapper">
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-1 mb-2 block">Accepted File Types</label>
                <input type="text" name="fields[{INDEX}][accept]" placeholder="e.g. .pdf,.docx or image/*"
                    class="w-full bg-white border-none rounded-xl px-5 py-3 text-xs font-bold focus:ring-2 focus:ring-primary transition-all">
            </div>
        </div>
    </div>
</template>

@push('scripts')
<!-- TinyMCE CDN (for WYSIWYG preview) -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    let fieldCount = 0;

    const NEEDS_OPTIONS   = ['select', 'select_multiple', 'radio', 'checkbox_group'];
    const NEEDS_FILE      = ['file', 'image', 'file_multiple'];
    const NO_PLACEHOLDER  = ['radio', 'checkbox_group', 'toggle', 'file', 'image', 'file_multiple', 'hidden'];

    function addField(data = null) {
        const container   = document.getElementById('fields-container');
        let template      = document.getElementById('field-template').innerHTML;
        const index       = fieldCount++;

        template = template.replace(/{INDEX}/g, index);
        container.insertAdjacentHTML('beforeend', template);

        const row = container.lastElementChild;
        const typeSelect = row.querySelector('.field-type-select');

        if (data) {
            row.querySelector('[name$="[label]"]').value       = data.label || '';
            row.querySelector('[name$="[name]"]').value        = data.name  || '';
            row.querySelector('[name$="[placeholder]"]').value = data.placeholder || '';
            typeSelect.value = data.type || 'text';
            if (data.required) row.querySelector('[name$="[required]"]').checked = true;
            if (data.options)  row.querySelector('[name$="[options]"]').value    = data.options;
            if (data.accept)   row.querySelector('[name$="[accept]"]').value     = data.accept;
        }

        updateTypeUI(typeSelect);
    }

    function removeField(btn) {
        btn.closest('.field-row').remove();
    }

    function handleTypeChange(select) {
        updateTypeUI(select);
    }

    function updateTypeUI(select) {
        const row     = select.closest('.field-row');
        const type    = select.value;
        const opts    = row.querySelector('.field-options-wrapper');
        const fileW   = row.querySelector('.field-file-wrapper');
        const phW     = row.querySelector('.field-placeholder-wrapper');

        opts.classList.toggle('hidden',  !NEEDS_OPTIONS.includes(type));
        fileW.classList.toggle('hidden', !NEEDS_FILE.includes(type));
        phW.classList.toggle('hidden',    NO_PLACEHOLDER.includes(type));
    }

    document.addEventListener('DOMContentLoaded', () => {
        addField();
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
</style>
@endpush
@endsection
