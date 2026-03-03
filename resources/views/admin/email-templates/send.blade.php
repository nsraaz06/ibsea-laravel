@extends('layouts.admin')
@section('title', 'Send Campaign | IBSEA Admin')

@section('content')
<div class="p-6 max-w-6xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.email-templates.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
            <span class="material-icons">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Send Campaign</h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $emailTemplate->name }} &bull; {{ $emailTemplate->subject }}</p>
        </div>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 font-bold text-sm px-6 py-4 rounded-2xl flex items-center gap-3">
            <span class="material-icons text-red-500">error</span>{{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Left: Template Preview --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="material-icons text-sm text-primary">preview</span> Email Preview
                </h3>
                <div class="border border-slate-100 rounded-2xl overflow-hidden">
                    {{-- Mini email header --}}
                    <div class="bg-slate-900 px-6 py-4 flex items-center gap-3">
                        <img src="{{ asset('ibsea-text-33w-600x83.png.webp') }}" class="h-5">
                    </div>
                    <div class="p-6 text-sm leading-relaxed text-slate-700 max-h-96 overflow-y-auto">
                        {!! $emailTemplate->body !!}
                    </div>
                    <div class="bg-slate-50 px-6 py-3 text-center text-[10px] text-slate-400 border-t border-slate-100">
                        © {{ date('Y') }} IBSEA. All rights reserved.
                    </div>
                </div>
                <div class="mt-4 flex gap-3">
                    <a href="{{ route('admin.email-templates.edit', $emailTemplate) }}"
                       class="inline-flex items-center gap-1.5 text-xs font-black text-slate-500 hover:text-primary transition-colors">
                        <span class="material-icons text-sm">edit</span> Edit Template
                    </a>
                </div>
            </div>
        </div>

        {{-- Right: Send Controls --}}
        <div class="lg:col-span-2 space-y-4">
            <form method="POST" action="{{ route('admin.email-templates.dispatch', $emailTemplate) }}" id="sendForm">
                @csrf
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 space-y-6">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <span class="material-icons text-sm text-primary">groups</span> Choose Recipients
                    </h3>

                    {{-- Recipient Type --}}
                    <div class="space-y-3" id="recipient_types">
                        @foreach([
                            ['all_members',     'people',       'All Members',       'Everyone in the IBSEA member database',   'bg-blue-50 border-blue-200 text-blue-700'],
                            ['specific',        'person_search','Specific Members',  'Hand-pick individual members',            'bg-emerald-50 border-emerald-200 text-emerald-700'],
                            ['form_submitters', 'assignment',   'Form Submitters',   'All emails from a specific form',         'bg-amber-50 border-amber-200 text-amber-700'],
                            ['custom',          'edit_note',    'Custom Emails',     'Paste your own list of emails',           'bg-violet-50 border-violet-200 text-violet-700'],
                        ] as [$val, $icon, $label, $desc, $colors])
                        <label class="flex items-start gap-4 p-4 rounded-2xl border-2 cursor-pointer transition-all hover:shadow-sm recipient-option border-slate-100 {{ $colors }}" style="border-color: transparent;" data-colors="{{ $colors }}">
                            <input type="radio" name="recipients_type" value="{{ $val }}" class="mt-0.5 text-primary focus:ring-primary" onchange="showRecipientDetail('{{ $val }}')">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="material-icons text-sm">{{ $icon }}</span>
                                    <span class="font-black text-xs uppercase tracking-widest">{{ $label }}</span>
                                </div>
                                <p class="text-[10px] font-semibold text-slate-500 mt-0.5">{{ $desc }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    {{-- Specific Members multi-select --}}
                    <div id="detail_specific" class="hidden space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Select Members</label>
                        <select name="specific_member_ids[]" multiple
                            class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3 text-sm font-bold focus:ring-2 focus:ring-primary transition-all" style="height:160px;">
                            @foreach($members as $m)
                            <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->email }})</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 px-1">Hold Ctrl / Cmd to select multiple</p>
                    </div>

                    {{-- Form Submitters select --}}
                    <div id="detail_form_submitters" class="hidden space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Select Form</label>
                        <select name="form_id" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            <option value="">— Choose a form —</option>
                            @foreach($forms as $f)
                            <option value="{{ $f->id }}">{{ $f->title }}</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 px-1">All email addresses submitted via this form will receive the campaign.</p>
                    </div>

                    {{-- Custom emails --}}
                    <div id="detail_custom" class="hidden space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email Addresses</label>
                        <textarea name="custom_emails" rows="5" placeholder="name@email.com, another@email.com&#10;(comma or newline separated)"
                            class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3 text-sm font-bold focus:ring-2 focus:ring-primary transition-all resize-none font-mono text-xs"></textarea>
                    </div>

                    {{-- Dispatch button --}}
                    <button type="submit" onclick="return confirmSend()"
                        class="w-full bg-primary text-white font-black text-sm uppercase tracking-widest py-5 rounded-2xl hover:bg-primary/80 transition-all flex items-center justify-center gap-2 shadow-xl shadow-primary/20 active:scale-95">
                        <span class="material-icons">rocket_launch</span> Dispatch Campaign
                    </button>
                    <p class="text-[10px] text-slate-400 text-center">Emails are sent immediately. This action cannot be undone.</p>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showRecipientDetail(type) {
    ['specific', 'form_submitters', 'custom'].forEach(t => {
        document.getElementById('detail_' + t).classList.add('hidden');
    });
    if (type !== 'all_members') {
        document.getElementById('detail_' + type).classList.remove('hidden');
    }
}
function confirmSend() {
    const type = document.querySelector('input[name="recipients_type"]:checked');
    if (!type) { alert('Please select a recipient group.'); return false; }
    return confirm('You are about to send this campaign. Are you sure?');
}
</script>
@endpush
@endsection
