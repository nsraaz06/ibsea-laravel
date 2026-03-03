@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Institutional Role Manager</h2>
            <p class="text-slate-500 font-medium">Define and organize the hierarchical structure of the IBSEA ecosystem.</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 active:scale-95 transition-all flex items-center gap-2">
            <span class="material-icons">add_moderator</span>
            Define New Role
        </a>
    </header>

    <div class="grid grid-cols-1 gap-8">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);" class="text-xs font-bold text-primary tracking-wide">
                        <tr>
                            <th class="px-8 py-6">Hierarchy Level</th>
                            <th class="px-8 py-6">Institutional Designation</th>
                            <th class="px-8 py-6">Public Visibility</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($roles as $role)
                        <tr class="group transition-colors {{ $loop->even ? 'bg-slate-50/30' : 'bg-white' }} hover:bg-ibsea-orange/5">
                            <td class="px-8 py-6">
                                <div class="w-10 h-10 text-white rounded-xl flex items-center justify-center font-semibold text-xs shadow-lg bg-primary">
                                    {{ $role->hierarchy_level }}
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-base font-bold text-slate-800">{{ $role->role_name }}</div>
                                <div class="text-xs font-semibold text-slate-400 mt-0.5">Strategic Designation</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    @if($role->show_in_leadership)
                                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span>
                                        <span class="text-xs font-bold text-green-600">Leadership Hub Visible</span>
                                    @else
                                        <span class="w-2.5 h-2.5 bg-slate-300 rounded-full"></span>
                                        <span class="text-xs font-bold text-slate-400">Internal Only</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2 text-right">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="w-10 h-10 rounded-xl bg-orange-50 text-accent hover:bg-accent hover:text-white transition-all flex items-center justify-center shadow-sm">
                                    <span class="material-icons">edit</span>
                                </a>
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Decommission this institutional role?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                        <span class="material-icons">delete_outline</span>
                                    </button>
                                </form>
                            </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                                    <span class="material-icons text-4xl">rule</span>
                                </div>
                                <h3 class="text-lg font-black text-slate-400 uppercase tracking-widest">No Roles Defined</h3>
                                <p class="text-slate-400 text-sm">Every mission partner requires a designated institutional role.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
