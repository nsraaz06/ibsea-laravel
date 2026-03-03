@extends('layouts.admin')
@section('title', 'Email Templates | IBSEA Admin')

@section('content')
<div class="p-6 max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight flex items-center gap-3">
                <span class="material-icons text-primary text-3xl">email</span>
                Email Templates
            </h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Design & send branded emails</p>
        </div>
        <a href="{{ route('admin.email-templates.create') }}"
           class="inline-flex items-center gap-2 bg-slate-900 text-white font-black text-xs uppercase tracking-widest px-6 py-3 rounded-2xl hover:bg-primary transition-all shadow-lg">
            <span class="material-icons text-sm">add</span> New Template
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-sm px-6 py-4 rounded-2xl flex items-center gap-3">
            <span class="material-icons text-emerald-500">check_circle</span>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 font-bold text-sm px-6 py-4 rounded-2xl flex items-center gap-3">
            <span class="material-icons text-red-500">error</span>{{ session('error') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        @if($templates->isEmpty())
        <div class="text-center py-24 text-slate-400">
            <span class="material-icons text-5xl mb-4 block">mail_outline</span>
            <p class="font-bold text-lg">No templates yet</p>
            <p class="text-sm mt-1">Create your first email template to get started.</p>
        </div>
        @else
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Template Name</th>
                    <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Subject</th>
                    <th class="px-6 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Campaigns Sent</th>
                    <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Last Modified</th>
                    <th class="px-6 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($templates as $tpl)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-5">
                        <span class="font-black text-slate-800">{{ $tpl->name }}</span>
                    </td>
                    <td class="px-6 py-5 text-slate-600 font-semibold max-w-xs truncate">{{ $tpl->subject }}</td>
                    <td class="px-6 py-5 text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-slate-100 text-slate-700 font-black text-xs rounded-full">{{ $tpl->campaigns_count }}</span>
                    </td>
                    <td class="px-6 py-5 text-slate-500 font-semibold text-xs">{{ $tpl->updated_at->diffForHumans() }}</td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.email-templates.send', $tpl) }}"
                               class="inline-flex items-center gap-1.5 bg-primary text-white font-black text-[10px] uppercase tracking-widest px-4 py-2 rounded-xl hover:bg-primary/80 transition-all">
                                <span class="material-icons text-sm">send</span> Send
                            </a>
                            <a href="{{ route('admin.email-templates.edit', $tpl) }}"
                               class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 font-black text-[10px] uppercase tracking-widest px-4 py-2 rounded-xl hover:bg-slate-200 transition-all">
                                <span class="material-icons text-sm">edit</span> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.email-templates.destroy', $tpl) }}" onsubmit="return confirm('Delete this template?')">
                                @csrf @method('DELETE')
                                <button class="inline-flex items-center gap-1.5 bg-red-50 text-red-500 font-black text-[10px] uppercase tracking-widest px-4 py-2 rounded-xl hover:bg-red-100 transition-all">
                                    <span class="material-icons text-sm">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-8 py-4 border-t border-slate-100">{{ $templates->links() }}</div>
        @endif
    </div>

    {{-- Quick link to history --}}
    <div class="text-center">
        <a href="{{ route('admin.email-campaigns.index') }}" class="text-xs font-bold text-slate-400 hover:text-primary transition-colors flex items-center justify-center gap-1.5">
            <span class="material-icons text-sm">history</span> View Campaign Send History
        </a>
    </div>
</div>
@endsection
