@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Mass Mission Onboarding</h2>
            <p class="text-slate-500 font-medium">Bulk import mission partners via CSV for strategic alliance expansion.</p>
        </div>
        <a href="{{ route('admin.bulk-import.template') }}" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-slate-900/10 active:scale-95 transition-all flex items-center gap-2">
            <span class="material-icons text-sm">download</span>
            Download Sample Template
        </a>
    </header>

    @if ($errors->any())
        <div class="bg-red-50 text-red-600 p-6 rounded-3xl mb-8 border border-red-100">
            <h3 class="font-black uppercase text-xs tracking-widest mb-2 flex items-center gap-2">
                <span class="material-icons text-sm">gpp_maybe</span> Critical Validation Error
            </h3>
            <ul class="list-disc pl-5 text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Import Control Center -->
        <div class="bg-white p-10 md:p-16 rounded-[2.5rem] shadow-sm border border-slate-100 h-fit">
            <form action="{{ route('admin.bulk-import.process') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Import Intelligence File (CSV)</label>
                    <div class="relative group">
                        <div class="aspect-[16/5] bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-primary/50 relative">
                            <div id="file-selection-status" class="text-center p-6">
                                <span class="material-icons text-4xl text-slate-200 mb-2">upload_file</span>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Select Intelligence CSV</p>
                            </div>
                        </div>
                        <input type="file" name="csv_file" required class="absolute inset-0 opacity-0 cursor-pointer" onchange="updateFileStatus(this)">
                    </div>
                </div>

                <div class="bg-blue-50/50 p-8 rounded-3xl border border-blue-50">
                    <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                        <span class="material-icons text-sm">info</span> Protocol Instructions
                    </h4>
                    <ul class="space-y-3">
                        <li class="text-[11px] font-bold text-slate-600 flex gap-3">
                            <span class="text-blue-500 font-black">01.</span>
                            Ensuring all emails are unique across the alliance.
                        </li>
                        <li class="text-[11px] font-bold text-slate-600 flex gap-3">
                            <span class="text-blue-500 font-black">02.</span>
                            Roles and Chapters must match existing platform definitions.
                        </li>
                        <li class="text-[11px] font-bold text-slate-600 flex gap-3">
                            <span class="text-blue-500 font-black">03.</span>
                            Default password 'ibsea2047' if Access Key is empty.
                        </li>
                    </ul>
                </div>

                <button type="submit" class="w-full bg-accent text-white py-5 rounded-3xl font-bold text-xs uppercase tracking-widest shadow-xl shadow-accent/20 active:scale-95 transition-all flex items-center justify-center gap-3">
                    Execute Bulk Import <span class="material-icons">rocket_launch</span>
                </button>
            </form>
        </div>

        <!-- Role & Chapter Reference -->
        <div class="space-y-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 flex items-center gap-2">
                    <span class="material-icons text-sm text-primary">lan</span> Designation Reference
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach(['Member', 'Mentor', 'Investor', 'Advisor', 'Strategic Advisor'] as $role)
                        <span class="px-4 py-2 bg-slate-50 text-[10px] font-bold text-slate-600 rounded-xl border border-slate-100 uppercase">{{ $role }}</span>
                    @endforeach
                </div>
                <p class="text-[9px] text-slate-400 font-bold mt-4 italic">Note: These values are case-insensitive in the CSV.</p>
            </div>

            <div class="bg-slate-900 p-10 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                <h3 class="text-xs font-black text-white/40 uppercase tracking-widest mb-6 relative z-10 flex items-center gap-2">
                    <span class="material-icons text-sm text-primary">security</span> Global Security Standard
                </h3>
                <p class="text-slate-400 text-sm font-medium leading-relaxed relative z-10">
                    Bulk import operations are logged and monitored. All imported partners will receive "Active" status and level 4 clearance by default.
                </p>
                <div class="mt-8 flex items-center gap-4 relative z-10">
                    <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-primary">
                        <span class="material-icons">verified_user</span>
                    </div>
                    <div class="text-[10px] font-black text-slate-100 uppercase tracking-widest">Encrypted Data Transfer</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateFileStatus(input) {
        if (input.files && input.files[0]) {
            const statusDiv = document.getElementById('file-selection-status');
            statusDiv.innerHTML = `
                <span class="material-icons text-4xl text-accent mb-2">check_circle</span>
                <p class="text-[10px] font-bold text-slate-800 tracking-widest">${input.files[0].name}</p>
                <p class="text-[9px] font-semibold text-slate-400 tracking-widest mt-1">${(input.files[0].size/1024).toFixed(2)} KB</p>
            `;
            statusDiv.parentElement.classList.add('border-accent');
            statusDiv.parentElement.classList.add('bg-orange-50/30');
        }
    }
</script>
@endsection
