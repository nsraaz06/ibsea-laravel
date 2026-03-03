@extends('layouts.admin')
@section('title', 'Compose Campaign | IBSEA Admin')

@section('content')
<div class="p-6 max-w-7xl mx-auto space-y-6">

    <div class="flex items-center gap-4">
        <a href="{{ route('admin.email-campaigns.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
            <span class="material-icons">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Compose Campaign</h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-0.5">Select a template then choose recipients</p>
        </div>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 font-bold text-sm px-6 py-4 rounded-2xl flex items-center gap-3">
            <span class="material-icons text-red-500">error</span>{{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.email-campaigns.compose.send') }}" id="composeForm">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- Left: Template Selector + Preview --}}
            <div class="lg:col-span-3 space-y-4">

                {{-- Template Selector Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 space-y-4">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <span class="material-icons text-sm text-primary">email</span> Select Email Template
                    </h3>
                    <select name="template_id" id="templateSelect"
                        class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all"
                        onchange="updatePreview(this.value)" required>
                        <option value="">— Choose a template —</option>
                        @foreach($templates as $t)
                        <option value="{{ $t->id }}" data-subject="{{ $t->subject }}" data-body="{{ e($t->body) }}">
                            {{ $t->name }} — {{ Str::limit($t->subject, 50) }}
                        </option>
                        @endforeach
                    </select>
                    <div id="templateMeta" class="hidden bg-slate-50 rounded-2xl px-5 py-3 text-xs text-slate-500 font-semibold space-y-1">
                        <p>📧 <span id="metaSubject" class="text-slate-700 font-black"></span></p>
                        <div class="flex gap-3 mt-2">
                            <a id="editLink" href="#" class="inline-flex items-center gap-1 text-primary font-black hover:underline">
                                <span class="material-icons text-xs">edit</span> Edit Template
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Live Preview Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-5 flex items-center gap-2">
                        <span class="material-icons text-sm text-primary">preview</span> Email Preview
                    </h3>
                    <div id="previewEmpty" class="text-center py-16 text-slate-300">
                        <span class="material-icons text-5xl mb-3 block">mail_outline</span>
                        <p class="font-bold text-sm">Select a template above to preview it</p>
                    </div>
                    <div id="previewBox" class="hidden border border-slate-100 rounded-2xl overflow-hidden">
                        <div class="bg-slate-900 px-6 py-4 flex items-center gap-3">
                            <img src="{{ asset('ibsea-text-33w-600x83.png.webp') }}" class="h-5" alt="IBSEA">
                        </div>
                        <div id="previewBody" class="p-6 text-sm leading-relaxed text-slate-700 max-h-96 overflow-y-auto">
                        </div>
                        <div class="bg-slate-50 px-6 py-3 text-center text-[10px] text-slate-400 border-t border-slate-100">
                            © {{ date('Y') }} IBSEA. All rights reserved.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Recipient Controls --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 space-y-6">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <span class="material-icons text-sm text-primary">groups</span> Choose Recipients
                    </h3>

                    <div class="space-y-3">
                        @foreach([
                            ['all_members',     'people',       'All Members',      'Everyone in IBSEA member database',    'text-blue-700'],
                            ['specific',        'person_search','Specific Members', 'Hand-pick individual members',          'text-emerald-700'],
                            ['form_submitters', 'assignment',   'Form Submitters',  'All emails from a specific form',       'text-amber-700'],
                            ['custom',          'edit_note',    'Custom Emails',    'Paste your own list of emails',         'text-violet-700'],
                        ] as [$val, $icon, $label, $desc, $color])
                        <label class="flex items-start gap-4 p-4 rounded-2xl border-2 border-slate-100 cursor-pointer transition-all hover:border-primary/30 hover:bg-slate-50">
                            <input type="radio" name="recipients_type" value="{{ $val }}"
                                class="mt-0.5 text-primary focus:ring-primary"
                                onchange="showRecipientDetail('{{ $val }}')">
                            <div>
                                <div class="flex items-center gap-2 {{ $color }}">
                                    <span class="material-icons text-sm">{{ $icon }}</span>
                                    <span class="font-black text-xs uppercase tracking-widest">{{ $label }}</span>
                                </div>
                                <p class="text-[10px] font-semibold text-slate-400 mt-0.5">{{ $desc }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    {{-- Specific Members --}}
                    <div id="detail_specific" class="hidden space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Select Members</label>
                        <select name="specific_member_ids[]" multiple
                            class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3 text-sm font-bold focus:ring-2 focus:ring-primary" style="height:160px;">
                            @foreach($members as $m)
                            <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 px-1">Hold Ctrl / Cmd to select multiple</p>
                    </div>

                    {{-- Form Submitters --}}
                    <div id="detail_form_submitters" class="hidden space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Select Form</label>
                        <select name="form_id" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3 text-sm font-bold focus:ring-2 focus:ring-primary">
                            <option value="">— Choose a form —</option>
                            @foreach($forms as $f)
                            <option value="{{ $f->id }}">{{ $f->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Custom Emails --}}
                    <div id="detail_custom" class="hidden space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email Addresses</label>
                        <textarea name="custom_emails" rows="5"
                            placeholder="name@email.com, another@email.com&#10;(comma or newline separated)"
                            class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3 text-sm font-bold focus:ring-2 focus:ring-primary resize-none font-mono text-xs"></textarea>
                    </div>

                    {{-- Dispatch --}}
                    <button type="submit" onclick="return confirmSend()"
                        class="w-full bg-primary text-white font-black text-sm uppercase tracking-widest py-5 rounded-2xl hover:bg-primary/80 transition-all flex items-center justify-center gap-2 shadow-xl shadow-primary/20 active:scale-95">
                        <span class="material-icons">rocket_launch</span> Queue Campaign
                    </button>
                    <p class="text-[10px] text-slate-400 text-center">Campaign will be queued and sent in the background.</p>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Template data from server
const templates = {
    @foreach($templates as $t)
    {{ $t->id }}: {
        subject: @json($t->subject),
        body: @json($t->body),
        editUrl: "{{ route('admin.email-templates.edit', $t) }}"
    },
    @endforeach
};

function updatePreview(id) {
    const meta = document.getElementById('templateMeta');
    const empty = document.getElementById('previewEmpty');
    const box = document.getElementById('previewBox');
    const body = document.getElementById('previewBody');

    if (!id || !templates[id]) {
        meta.classList.add('hidden');
        empty.classList.remove('hidden');
        box.classList.add('hidden');
        return;
    }

    const tpl = templates[id];
    document.getElementById('metaSubject').textContent = tpl.subject;
    document.getElementById('editLink').href = tpl.editUrl;
    meta.classList.remove('hidden');
    body.innerHTML = tpl.body;
    empty.classList.add('hidden');
    box.classList.remove('hidden');
}

function showRecipientDetail(type) {
    ['specific', 'form_submitters', 'custom'].forEach(t => {
        document.getElementById('detail_' + t).classList.add('hidden');
    });
    if (type !== 'all_members') {
        document.getElementById('detail_' + type).classList.remove('hidden');
    }
}

function confirmSend() {
    const tpl = document.getElementById('templateSelect').value;
    if (!tpl) { alert('Please select a template first.'); return false; }
    const type = document.querySelector('input[name="recipients_type"]:checked');
    if (!type) { alert('Please select a recipient group.'); return false; }
    return confirm('Queue this campaign for background sending?');
}
</script>
@endpush
@endsection
