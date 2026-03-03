@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Intelligence Report Examination</h2>
            <p class="text-slate-500 font-medium">Detailed inspection of submission logged on {{ $submission->created_at->format('d M, Y') }} at {{ $submission->created_at->format('h:i A') }}</p>
        </div>
        <a href="{{ route('admin.submissions.index', $submission->form_id) }}" class="text-slate-500 hover:text-primary transition-all flex items-center gap-2 font-bold text-sm">
            <span class="material-icons text-lg">arrow_back</span>
            Back to Submissions
        </a>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Main Data -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight mb-8 flex items-center gap-2">
                    <span class="material-icons text-primary text-xl">fact_check</span>
                    Response Data
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($submission->form->fields as $field)
                        <div class="space-y-1 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">{{ $field['label'] }}</label>
                            <div class="text-sm font-bold text-slate-700 px-1">
                                @php $value = $submission->data[$field['name']] ?? 'N/A'; @endphp
                                @if(is_array($value))
                                    {{ implode(', ', $value) }}
                                @else
                                    {{ $value }}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Metadata Sidebar -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight mb-6 flex items-center gap-2">
                    <span class="material-icons text-primary text-xl">info</span>
                    Submission Intel
                </h3>

                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 text-primary flex items-center justify-center">
                            <span class="material-icons">description</span>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Protocol Type</div>
                            <div class="text-sm font-bold text-slate-800">{{ $submission->form->title }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center">
                            <span class="material-icons">person</span>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Reporting Agent</div>
                            <div class="text-sm font-bold text-slate-800">{{ $submission->member ? $submission->member->name : 'Guest User' }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center">
                            <span class="material-icons">public</span>
                        </div>
                        <div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Origin Terminal</div>
                            <div class="text-sm font-bold text-slate-800">IP: {{ $submission->ip_address }}</div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100">
                        <form action="{{ route('admin.submissions.destroy', $submission) }}" method="POST" onsubmit="return confirm('Securely erase this intelligence record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-500 font-black py-4 rounded-2xl hover:bg-red-500 hover:text-white transition-all flex items-center justify-center gap-2 text-[10px] uppercase tracking-widest">
                                <span class="material-icons text-sm">delete_forever</span>
                                Archive Record
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
