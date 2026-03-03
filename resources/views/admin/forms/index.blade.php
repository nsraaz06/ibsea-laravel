@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Form Intelligence Hub</h2>
            <p class="text-slate-500 font-medium">Design and manage custom data collection protocols and user forms.</p>
        </div>
        <a href="{{ route('admin.forms.create') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 active:scale-95 transition-all flex items-center gap-2">
            <span class="material-icons text-sm">add_task</span>
            Design New Form
        </a>
    </header>

    <!-- Filter Bar -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8">
        <form action="{{ route('admin.forms.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by form title..." class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
            </div>
            
            <button type="submit" class="bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all hover:bg-black">
                Apply Search
            </button>
            
            @if(request()->filled('search'))
                <a href="{{ route('admin.forms.index') }}" class="bg-slate-100 text-slate-500 px-6 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Forms Grid -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);" class="text-xs font-bold text-primary tracking-wide">
                    <tr>
                        <th class="px-8 py-6 uppercase tracking-widest">Protocol Title</th>
                        <th class="px-8 py-6 uppercase tracking-widest">Slug (URL)</th>
                        <th class="px-8 py-6 uppercase tracking-widest">Intelligence Logged</th>
                        <th class="px-8 py-6 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-6 text-right uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($forms as $form)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-orange-50 text-primary flex items-center justify-center shadow-inner">
                                    <span class="material-icons text-xl">description</span>
                                </div>
                                <div>
                                    <div class="text-base font-bold text-slate-800">{{ $form->title }}</div>
                                    <div class="text-[10px] font-bold mt-0.5 text-slate-400 uppercase tracking-widest">Created {{ $form->created_at->format('d M, Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <code class="text-xs font-bold text-blue-500 bg-blue-50 px-3 py-1.5 rounded-lg">/f/{{ $form->slug }}</code>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2">
                                <span class="material-icons text-slate-400 text-sm">history</span>
                                <span class="text-xs font-bold text-slate-600">{{ $form->submissions_count }} Submissions</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $form->is_active ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                {{ $form->is_active ? 'Active' : 'Offline' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.submissions.index', $form->id) }}" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white transition-all flex items-center justify-center shadow-sm" title="View Submissions">
                                    <span class="material-icons text-lg">analytics</span>
                                </a>
                                <a href="{{ route('forms.show', $form->slug) }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-500 hover:bg-slate-800 hover:text-white transition-all flex items-center justify-center shadow-sm" title="View Public Form">
                                    <span class="material-icons text-lg">open_in_new</span>
                                </a>
                                <a href="{{ route('admin.forms.edit', $form) }}" class="w-10 h-10 rounded-xl bg-orange-50 text-accent hover:bg-accent hover:text-white transition-all flex items-center justify-center shadow-sm" title="Edit Form">
                                    <span class="material-icons text-lg">edit</span>
                                </a>
                                <form action="{{ route('admin.forms.destroy', $form) }}" method="POST" onsubmit="return confirm('Decommission this form protocol?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center shadow-sm" title="Delete Form">
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
                            <h3 class="text-lg font-black text-slate-400 uppercase tracking-widest">No Form Protocols Found</h3>
                            <p class="text-slate-400 text-sm">Start by detailing a new form to collect strategic intelligence.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($forms->hasPages())
        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
            {{ $forms->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
