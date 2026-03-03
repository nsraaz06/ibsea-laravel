@extends('layouts.app')

@push('styles')
<style>
    .form-glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(15px); }
    .form-bg { background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #7c2d12 100%); }
    /* Toggle switch */
    .toggle-track { width: 3rem; height: 1.5rem; background: #e2e8f0; border-radius: 9999px; cursor: pointer; position: relative; transition: background 0.2s; }
    .toggle-track.on { background: #0A4A95; }
    .toggle-thumb { position: absolute; top: 0.2rem; left: 0.2rem; width: 1.1rem; height: 1.1rem; border-radius: 9999px; background: white; transition: transform 0.2s; box-shadow: 0 1px 4px rgba(0,0,0,0.2); }
    .toggle-track.on .toggle-thumb { transform: translateX(1.5rem); }
    /* Drag-drop zone */
    .drop-zone { border: 2px dashed #cbd5e1; border-radius: 1rem; padding: 2rem; text-align: center; cursor: pointer; transition: all 0.2s; }
    .drop-zone:hover, .drop-zone.dragover { border-color: #0A4A95; background: rgba(10, 74, 149, 0.05); }
</style>
@endpush

@section('content')

{{-- Featured Banner Image --}}
@if(!empty($form->settings['featured_image']))
<div class="w-full" style="max-height:1080px; overflow:hidden;">
    <img src="{{ asset('storage/' . $form->settings['featured_image']) }}"
         alt="{{ $form->title }}"
         class="w-full object-cover" style="max-height:1080px; object-position:center;">
</div>
@endif

<main class="form-bg -mt-20 min-h-[calc(100vh-160px)] py-20 px-6">
    <div class="max-w-3xl mx-auto">
        <div class="form-glass p-10 md:p-14 rounded-[3rem] shadow-2xl border border-white/20" data-aos="zoom-in">
            <!-- Form Header -->
            <div class="text-center mb-12">
                <!-- <div class="w-61 h-auto mx-auto mb-8">
                    <img src="{{ asset('ibsea-text-33w-600x83.png.webp') }}" alt="IBSEA Logo" class="w-[90%] h-auto">
                </div> -->
                <h1 class="text-3xl md:text-4xl font-black text-slate-800 mb-4 tracking-tight uppercase">{{ $form->title }}</h1>
                @if($form->description)
                    <p class="text-slate-500 font-semibold text-sm leading-relaxed max-w-xl mx-auto">{{ $form->description }}</p>
                @endif
            </div>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-6 rounded-2xl mb-8 border border-red-100 flex items-center gap-4 text-sm font-bold">
                    <span class="material-icons text-xl">error_outline</span>
                    <ul class="list-none p-0 m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 text-green-700 p-6 rounded-2xl mb-8 border border-green-100 flex items-center gap-4 text-sm font-bold">
                    <span class="material-icons text-xl">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($form->fields as $field)
                    @php
                        $type        = $field['type'] ?? 'text';
                        $name        = $field['name'] ?? '';
                        $label       = $field['label'] ?? '';
                        $required    = isset($field['required']) && $field['required'];
                        $placeholder = $field['placeholder'] ?? 'Enter ' . strtolower($label) . '...';
                        $accept      = $field['accept'] ?? '';
                        // Parse options: split by newline or comma
                        $rawOptions = $field['options'] ?? '';
                        $options = array_filter(array_map('trim', preg_split('/[\n,]+/', $rawOptions)));
                        $fullWidth   = in_array($type, ['textarea', 'wysiwyg', 'checkbox_group', 'radio', 'hidden', 'file_multiple']);
                        $baseInput   = 'w-full bg-white/50 border-2 border-slate-100 rounded-2xl px-6 py-4 font-bold text-slate-700 focus:border-primary focus:bg-white outline-none transition-all shadow-sm';
                    @endphp

                    @if($type === 'hidden')
                        <input type="hidden" name="{{ $name }}" value="{{ $field['value'] ?? '' }}">
                    @else
                        <div class="space-y-3 {{ $fullWidth ? 'md:col-span-2' : '' }}">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest px-2 flex items-center gap-2">
                                {{ $label }}
                                @if($required)<span class="text-primary text-lg leading-none">*</span>@endif
                            </label>

                            <div class="relative group">
                                {{-- ─── Textarea ───────────────────────────────────────────── --}}
                                @if($type === 'textarea')
                                    <textarea name="{{ $name }}" {{ $required ? 'required' : '' }}
                                        rows="4" placeholder="{{ $placeholder }}"
                                        class="{{ $baseInput }} resize-none">{{ old($name) }}</textarea>

                                {{-- ─── WYSIWYG ─────────────────────────────────────────────── --}}
                                @elseif($type === 'wysiwyg')
                                    <textarea name="{{ $name }}" id="wysiwyg_{{ $name }}" {{ $required ? 'required' : '' }}
                                        class="{{ $baseInput }} resize-none min-h-[200px]">{{ old($name) }}</textarea>

                                {{-- ─── Select Single ───────────────────────────────────────── --}}
                                @elseif($type === 'select')
                                    <select name="{{ $name }}" {{ $required ? 'required' : '' }}
                                        class="{{ $baseInput }} appearance-none">
                                        <option value="">Choose an option…</option>
                                        @foreach($options as $opt)
                                            <option value="{{ $opt }}" {{ old($name) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                        <span class="material-icons">expand_more</span>
                                    </div>

                                {{-- ─── Select Multiple ─────────────────────────────────────── --}}
                                @elseif($type === 'select_multiple')
                                    <select name="{{ $name }}[]" {{ $required ? 'required' : '' }} multiple
                                        class="{{ $baseInput }} min-h-[120px]">
                                        @foreach($options as $opt)
                                            <option value="{{ $opt }}" {{ in_array($opt, (array)old($name, [])) ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-[10px] text-slate-400 font-semibold mt-1 px-2">Hold Ctrl / Cmd to select multiple</p>

                                {{-- ─── Radio ───────────────────────────────────────────────── --}}
                                @elseif($type === 'radio')
                                    <div class="space-y-3 pt-2">
                                        @foreach($options as $opt)
                                            <label class="flex items-center gap-3 cursor-pointer group/r">
                                                <input type="radio" name="{{ $name }}" value="{{ $opt }}"
                                                    {{ old($name) == $opt ? 'checked' : '' }}
                                                    {{ $required ? 'required' : '' }}
                                                    class="w-4 h-4 text-primary border-slate-300 focus:ring-primary">
                                                <span class="text-sm font-bold text-slate-700 group-hover/r:text-primary transition-colors">{{ $opt }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                {{-- ─── Checkbox Group ──────────────────────────────────────── --}}
                                @elseif($type === 'checkbox_group')
                                    <div class="space-y-3 pt-2">
                                        @foreach($options as $opt)
                                            <label class="flex items-center gap-3 cursor-pointer group/c">
                                                <input type="checkbox" name="{{ $name }}[]" value="{{ $opt }}"
                                                    {{ in_array($opt, (array)old($name, [])) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary">
                                                <span class="text-sm font-bold text-slate-700 group-hover/c:text-primary transition-colors">{{ $opt }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                {{-- ─── Toggle / Switch ─────────────────────────────────────── --}}
                                @elseif($type === 'toggle')
                                    <div class="flex items-center gap-4 pt-2">
                                        <input type="hidden"   name="{{ $name }}" value="0">
                                        <input type="checkbox" name="{{ $name }}" value="1" id="toggle_{{ $name }}"
                                            {{ old($name) ? 'checked' : '' }}
                                            class="sr-only toggle-input">
                                        <div class="toggle-track {{ old($name) ? 'on' : '' }}" onclick="toggleSwitch(this)">
                                            <div class="toggle-thumb"></div>
                                        </div>
                                        <label for="toggle_{{ $name }}" class="text-sm font-bold text-slate-600 cursor-pointer">{{ $label }}</label>
                                    </div>

                                {{-- ─── File / Image / Multi-file ───────────────────────────── --}}
                                @elseif(in_array($type, ['file', 'image', 'file_multiple']))
                                    <div class="drop-zone" id="drop_{{ $name }}"
                                        ondragover="event.preventDefault(); this.classList.add('dragover')"
                                        ondragleave="this.classList.remove('dragover')"
                                        ondrop="handleDrop(event, '{{ $name }}')"
                                        onclick="document.getElementById('file_{{ $name }}').click()">
                                        <span class="material-icons text-4xl text-slate-300 mb-2 block">cloud_upload</span>
                                        <p class="text-sm font-bold text-slate-500">Drag & drop or <span class="text-primary underline">click to browse</span></p>
                                        @if($accept)<p class="text-xs text-slate-400 mt-1">Accepted: {{ $accept }}</p>@endif
                                        <p id="file_name_{{ $name }}" class="text-xs font-bold text-slate-700 mt-2"></p>
                                    </div>
                                    <input type="file" id="file_{{ $name }}" name="{{ $name }}{{ $type === 'file_multiple' ? '[]' : '' }}"
                                        {{ $required ? 'required' : '' }}
                                        {{ $type === 'file_multiple' ? 'multiple' : '' }}
                                        {{ $type === 'image' ? 'accept="image/*"' : ($accept ? 'accept="'.$accept.'"' : '') }}
                                        class="sr-only"
                                        onchange="updateFileName(this, '{{ $name }}')">

                                {{-- ─── All Other Standard Inputs ───────────────────────────── --}}
                                @else
                                    <input type="{{ $type }}" name="{{ $name }}" 
                                        value="{{ old($name) }}"
                                        {{ $required ? 'required' : '' }}
                                        placeholder="{{ $placeholder }}"
                                        class="{{ $baseInput }}">
                                @endif
                            </div>
                        </div>
                    @endif
                    @endforeach
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-slate-900 text-white font-black py-6 rounded-2xl shadow-xl shadow-slate-900/20 hover:bg-slate-800 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 active:scale-95 group">
                        SUBMIT NOW
                        <span class="material-icons group-hover:translate-x-1 transition-transform">send</span>
                    </button>
                    <p class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-6">
                        Secure Transmission Encrypted via IBSEA Protocol v4.0
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Toggle switch
    function toggleSwitch(track) {
        track.classList.toggle('on');
        const input = track.parentElement.querySelector('.toggle-input');
        if (input) input.checked = track.classList.contains('on');
    }

    // File upload helpers
    function updateFileName(input, name) {
        const el = document.getElementById('file_name_' + name);
        if (!el) return;
        const files = input.files;
        if (files.length === 1) {
            el.textContent = '✓ ' + files[0].name;
        } else if (files.length > 1) {
            el.textContent = '✓ ' + files.length + ' files selected';
        }
    }

    function handleDrop(e, name) {
        e.preventDefault();
        document.getElementById('drop_' + name).classList.remove('dragover');
        const fileInput = document.getElementById('file_' + name);
        if (e.dataTransfer.files.length) {
            // Programmatically assign files
            try {
                const dt = new DataTransfer();
                Array.from(e.dataTransfer.files).forEach(f => dt.items.add(f));
                fileInput.files = dt.files;
                updateFileName(fileInput, name);
            } catch(err) { console.warn('DataTransfer not supported'); }
        }
    }

    // WYSIWYG - optional TinyMCE init if script loaded
    document.querySelectorAll('[id^="wysiwyg_"]').forEach(el => {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                target: el,
                height: 300,
                menubar: false,
                plugins: 'lists link',
                toolbar: 'bold italic underline | bullist numlist | link',
                skin: 'oxide',
            });
        }
    });
</script>
@endpush
