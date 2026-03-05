@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Institutional Learning Hub</h2>
            <p class="text-slate-500 font-semibold italic">Manage educational programs, growth modules, and mentorship curricula.</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-premium hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-3">
            <span class="material-icons text-sm">school</span>
            Create New Program
        </a>
    </header>

    @if(session('success'))
        <div class="bg-ibsea-green/10 text-ibsea-green p-8 rounded-[2.5rem] mb-10 border border-ibsea-green/20 flex items-center gap-4">
            <div class="w-10 h-10 bg-ibsea-green/20 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-icons">verified</span>
            </div>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-[3rem] shadow-premium border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-8 py-6 text-[11px] font-black text-slate-400 uppercase tracking-widest">Educational Asset</th>
                    <th class="px-8 py-6 text-[11px] font-black text-slate-400 uppercase tracking-widest">Structure</th>
                    <th class="px-8 py-6 text-[11px] font-black text-slate-400 uppercase tracking-widest">Investment (Price)</th>
                    <th class="px-8 py-6 text-[11px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-6 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Strategic Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($courses as $course)
                <tr class="group hover:bg-slate-50/50 transition-all">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-14 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 shrink-0">
                                @if($course->thumbnail)
                                    <img src="{{ asset($course->thumbnail) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="material-icons text-slate-300">import_contacts</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm leading-tight">{{ $course->title }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $course->category ?? 'General Program' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-xs font-bold text-slate-500">
                        <span class="flex items-center gap-2">
                            <span class="material-icons text-sm opacity-30">account_tree</span>
                            {{ $course->modules_count }} Modules / Learning Units
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        @if($course->access_type == 'free')
                            <span class="text-ibsea-green font-black text-[10px] uppercase tracking-widest">Open Access</span>
                        @else
                            <p class="font-black text-slate-800 text-sm">₹{{ number_format($course->price, 2) }}</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $course->access_type }} Mode</p>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        @if($course->is_published)
                        <span class="bg-ibsea-green/10 text-ibsea-green px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-ibsea-green/20 flex items-center gap-2 w-fit">
                            <span class="w-1.5 h-1.5 bg-ibsea-green rounded-full"></span>
                            Live
                        </span>
                        @else
                        <span class="bg-slate-100 text-slate-400 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-slate-200">
                            Draft Mode
                        </span>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all">
                            <a href="{{ route('admin.courses.edit', $course->id) }}" class="p-3 bg-amber-50 text-amber-500 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm flex items-center gap-2 font-bold text-[10px] uppercase tracking-widest">
                                <span class="material-icons text-sm">settings_suggest</span> Manage
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                        No educational assets currently deployed.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($courses->hasPages())
        <div class="p-8 border-t border-slate-50">
            {{ $courses->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
