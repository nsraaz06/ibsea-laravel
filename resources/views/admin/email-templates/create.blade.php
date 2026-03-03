@extends('layouts.admin')
@section('title', 'Create Email Template | IBSEA Admin')

@section('content')
<div class="p-6 max-w-6xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.email-templates.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
            <span class="material-icons">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Create Email Template</h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-0.5">Design your branded email</p>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 font-bold text-sm px-6 py-4 rounded-2xl">
            @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.email-templates.store') }}" id="templateForm">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Settings --}}
            <div class="space-y-4">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 space-y-5">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <span class="material-icons text-sm text-primary">settings</span> Template Settings
                    </h3>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Template Name <span class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Welcome Email"
                            class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary transition-all" required>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Subject Line <span class="text-red-400">*</span></label>
                        <input type="text" name="subject" value="{{ old('subject') }}" placeholder="e.g. Welcome to IBSEA, @{{name}}!"
                            class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary transition-all" required>
                        <p class="text-[10px] text-slate-400 px-1">You can use variables in the subject too.</p>
                    </div>

                    {{-- Variable Reference --}}
                    <div class="bg-slate-900 rounded-2xl p-5 space-y-3">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Available Variables</p>
                        @php
                            $tplVars = [
                                ['{' . '{name}}',      "Recipient's full name"],
                                ['{' . '{email}}',     "Recipient's email address"],
                                ['{' . '{member_id}}', "Member ID number"],
                                ['{' . '{date}}',      "Today's date"],
                            ];
                        @endphp
                        @foreach($tplVars as [$var, $desc])
                        <div class="flex items-center justify-between gap-3 cursor-pointer variable-chip"
                             onclick="insertVariable('{{ $var }}')" title="Click to copy">
                            <code class="text-primary text-xs font-black bg-primary/10 px-2.5 py-1 rounded-lg">{{ $var }}</code>
                            <span class="text-slate-500 text-[10px] font-semibold">{{ $desc }}</span>
                        </div>
                        @endforeach
                        <p class="text-[10px] text-slate-500 mt-2">Click a variable to insert at cursor</p>
                    </div>

                    <button type="submit"
                        class="w-full bg-slate-900 text-white font-black text-xs uppercase tracking-widest py-4 rounded-2xl hover:bg-primary transition-all flex items-center justify-center gap-2 shadow-lg">
                        <span class="material-icons text-sm">save</span> Save Template
                    </button>
                </div>
            </div>

            {{-- Right: WYSIWYG Editor --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 space-y-5">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <span class="material-icons text-sm text-primary">edit_note</span> Email Body
                        <span class="text-[10px] text-slate-400 font-semibold ml-2">(WYSIWYG — what you see is what recipients get)</span>
                    </h3>
                    <input type="hidden" name="body" id="email_body_hidden">
                    <div id="email_body" style="min-height:460px;"></div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
#email_body { background:#fff; border-radius:0 0 0.75rem 0.75rem; }
.ql-toolbar { border-radius: 0.75rem 0.75rem 0 0 !important; background: #f8fafc; }
.ql-container { font-size:14px; border-radius: 0 0 0.75rem 0.75rem !important; }
.ql-editor { min-height: 420px; line-height: 1.7; color: #1e293b; font-family: 'Segoe UI', Arial, sans-serif; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>
<script>
const quill = new Quill('#email_body', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1,2,3,4,false] }, { 'font': [] }, { 'size': ['small','normal','large','huge'] }],
            ['bold','italic','underline','strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
            ['link', 'image', 'blockquote', 'code-block'],
            ['clean'],
        ],
    },
});

// Pre-fill from old() value if validation failed
@if(old('body'))
quill.clipboard.dangerouslyPasteHTML(0, {!! json_encode(old('body')) !!});
@endif

// Sync to hidden input and manually submit
document.getElementById('templateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const html = quill.root.innerHTML.trim();
    const emptyQuill = html === '<p><br></p>' || html === '';
    if (emptyQuill) {
        alert('Please write something in the email body.');
        return;
    }
    document.getElementById('email_body_hidden').value = html;
    this.submit();
});

function insertVariable(variable) {
    quill.focus();
    const range = quill.getSelection() || { index: quill.getLength(), length: 0 };
    quill.clipboard.dangerouslyPasteHTML(range.index, variable);
}
</script>
@endpush
@endsection
