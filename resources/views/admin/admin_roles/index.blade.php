@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Staff Roles</h2>
            <p class="text-slate-500 font-medium">Manage administrator roles and their permissions matrix.</p>
        </div>
        <a href="{{ route('admin.admin-roles.create') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:-translate-y-1 transition-all flex items-center gap-2">
            <span class="material-icons text-sm">add</span> New Role
        </a>
    </header>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 px-6 py-4 rounded-2xl mb-8 font-semibold flex items-center gap-3 border border-emerald-100">
            <span class="material-icons">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 text-red-600 px-6 py-4 rounded-2xl mb-8 font-semibold flex items-center gap-3 border border-red-100">
            <span class="material-icons">error</span>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);" class="text-xs font-bold text-primary tracking-wide">
                    <tr>
                        <th class="px-8 py-6 uppercase">Role Name</th>
                        <th class="px-8 py-6 uppercase">Active Staff</th>
                        <th class="px-8 py-6 uppercase text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($adminRoles as $role)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6 font-bold text-slate-800 text-base">{{ $role->name }}</td>
                            <td class="px-8 py-6">
                                <span class="bg-primary/10 text-primary px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest">{{ $role->admins_count }} Members</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2 text-right">
                                    <a href="{{ route('admin.admin-roles.edit', $role->id) }}" class="w-10 h-10 rounded-xl bg-orange-50 text-accent hover:bg-accent hover:text-white transition-all flex items-center justify-center shadow-sm" title="Edit">
                                        <span class="material-icons text-sm">edit</span>
                                    </a>
                                    @if($role->admins_count === 0)
                                    <form action="{{ route('admin.admin-roles.destroy', $role->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center shadow-sm" title="Delete">
                                            <span class="material-icons text-sm">delete</span>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-icons text-4xl text-slate-200">admin_panel_settings</span>
                                </div>
                                <h3 class="text-lg font-black text-slate-400 uppercase tracking-widest">No Roles Defined</h3>
                                <p class="text-slate-400 text-sm">Create a role to start managing permissions.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
