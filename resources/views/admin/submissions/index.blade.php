@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Intelligence Submissions</h2>
            <p class="text-slate-500 font-medium">
                @if($form)
                    Reviewing responses for protocol: <span class="text-primary font-bold">{{ $form->title }}</span>
                @else
                    Global database of all collected intelligence reports.
                @endif
            </p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.submissions.export', ['formId' => $form ? $form->id : '']) }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl font-black text-[10px] uppercase tracking-[0.15em] hover:bg-primary transition-all flex items-center gap-2 shadow-lg shadow-primary/20">
                <span class="material-icons text-sm">download</span>
                Export CSV
            </a>
            @if($form)
                <a href="{{ route('admin.forms.index') }}" class="text-slate-500 hover:text-primary transition-all flex items-center gap-2 font-bold text-sm">
                    <span class="material-icons text-lg">arrow_back</span>
                    Back to Forms
                </a>
            @endif
        </div>
    </header>

    <!-- Submissions Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);" class="text-xs font-bold text-primary tracking-wide">
                    <tr>
                        <th class="px-8 py-6 uppercase tracking-widest">Submission Date</th>
                        @if(!$form)
                            <th class="px-8 py-6 uppercase tracking-widest">Target Protocol</th>
                        @endif
                        <th class="px-8 py-6 uppercase tracking-widest">Intelligence Agent</th>
                        <th class="px-8 py-6 uppercase tracking-widest">Preview Data</th>
                        <th class="px-8 py-6 text-right uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($submissions as $submission)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="text-sm font-bold text-slate-800">{{ $submission->created_at->format('d M, Y') }}</div>
                            <div class="text-[10px] font-bold text-slate-400 mt-1">{{ $submission->created_at->format('h:i A') }}</div>
                        </td>
                        @if(!$form)
                        <td class="px-8 py-6">
                            <div class="text-xs font-black text-slate-600 uppercase tracking-tight">{{ $submission->form->title }}</div>
                        </td>
                        @endif
                        <td class="px-8 py-6">
                            @if($submission->member)
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center text-[10px] font-black">
                                        {{ strtoupper(substr($submission->member->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-800">{{ $submission->member->name }}</div>
                                        <div class="text-[10px] font-medium text-slate-400">{{ $submission->member->email }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="text-xs font-bold text-slate-400 italic">Guest Submission</div>
                                <div class="text-[10px] font-medium text-slate-400">IP: {{ $submission->ip_address }}</div>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-wrap gap-2">
                                @php $count = 0; @endphp
                                @foreach($submission->data as $key => $value)
                                    @if($count < 2 && is_string($value))
                                        <div class="bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">
                                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest block">{{ str_replace('_', ' ', $key) }}</span>
                                            <span class="text-[10px] font-bold text-slate-700 line-clamp-1 truncate max-w-[150px]">{{ $value }}</span>
                                        </div>
                                        @php $count++; @endphp
                                    @endif
                                @endforeach
                                @if(count($submission->data) > 2)
                                    <div class="bg-slate-50 px-2 py-1.5 rounded-lg border border-slate-100 flex items-center text-[8px] font-black text-slate-400">
                                        +{{ count($submission->data) - 2 }} MORE
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2 text-right">
                                <a href="{{ route('admin.submissions.show', $submission) }}" class="w-10 h-10 rounded-xl bg-primary text-white hover:bg-orange-600 transition-all flex items-center justify-center shadow-lg shadow-primary/20" title="Examine Intel">
                                    <span class="material-icons text-lg">visibility</span>
                                </a>
                                <form action="{{ route('admin.submissions.destroy', $submission) }}" method="POST" onsubmit="return confirm('Archive this intelligence record permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center shadow-sm" title="Delete Record">
                                        <span class="material-icons text-lg">delete_outline</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                                <span class="material-icons text-4xl">inventory_2</span>
                            </div>
                            <h3 class="text-lg font-black text-slate-400 uppercase tracking-widest">No Intelligence Logged</h3>
                            <p class="text-slate-400 text-sm">Waiting for incoming data from deployed form protocols.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($submissions->hasPages())
        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
