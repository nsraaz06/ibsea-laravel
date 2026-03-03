@extends('layouts.admin')
@section('title', 'Campaign History | IBSEA Admin')

@section('content')
<div class="p-6 max-w-7xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight flex items-center gap-3">
                <span class="material-icons text-primary text-3xl">history</span>
                Campaign History
            </h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">All email dispatches log</p>
        </div>
        <a href="{{ route('admin.email-templates.index') }}"
           class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 font-black text-xs uppercase tracking-widest px-5 py-3 rounded-2xl hover:bg-slate-200 transition-all">
            <span class="material-icons text-sm">email</span> Templates
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-sm px-6 py-4 rounded-2xl flex items-center gap-3">
            <span class="material-icons text-emerald-500">check_circle</span>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        @if($campaigns->isEmpty())
        <div class="text-center py-24 text-slate-400">
            <span class="material-icons text-5xl mb-4 block">send</span>
            <p class="font-bold text-lg">No campaigns sent yet</p>
            <p class="text-sm mt-1">Send your first campaign from the Email Templates page.</p>
        </div>
        @else
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Template</th>
                    <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Subject</th>
                    <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Recipients</th>
                    <th class="px-6 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Sent</th>
                    <th class="px-6 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Failed</th>
                    <th class="px-6 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Sent At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($campaigns as $c)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-5 font-black text-slate-800">{{ $c->template?->name ?? '—' }}</td>
                    <td class="px-6 py-5 text-slate-600 font-semibold max-w-xs truncate">{{ $c->subject }}</td>
                    <td class="px-6 py-5">
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-xl
                            @if($c->recipients_type === 'all_members') bg-blue-50 text-blue-700
                            @elseif($c->recipients_type === 'specific') bg-emerald-50 text-emerald-700
                            @elseif($c->recipients_type === 'form_submitters') bg-amber-50 text-amber-700
                            @else bg-violet-50 text-violet-700 @endif">
                            {{ $c->recipientsLabel() }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="font-black text-emerald-600">{{ $c->sent_count }}</span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="font-black {{ $c->failed_count > 0 ? 'text-red-500' : 'text-slate-300' }}">{{ $c->failed_count }}</span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @php
                        $statusMap = [
                            'queued'  => ['bg-sky-50 text-sky-700',     'hourglass_empty'],
                            'sending' => ['bg-indigo-50 text-indigo-700','send'],
                            'sent'    => ['bg-emerald-50 text-emerald-700','check_circle'],
                            'partial' => ['bg-amber-50 text-amber-700',  'warning'],
                            'failed'  => ['bg-red-50 text-red-700',      'error'],
                        ];
                        $badge = $statusMap[$c->status] ?? ['bg-slate-100 text-slate-500','help'];
                        @endphp
                        <span class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-xl {{ $badge[0] }}">
                            <span class="material-icons text-xs">{{ $badge[1] }}</span>
                            {{ $c->status }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-slate-500 font-semibold text-xs">{{ $c->sent_at?->diffForHumans() ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-8 py-4 border-t border-slate-100">{{ $campaigns->links() }}</div>
        @endif
    </div>
</div>
@endsection
