@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Staff Accounts</h2>
            <p class="text-slate-500 font-medium">Manage administrative users and assign their access roles.</p>
        </div>
        <a href="{{ route('admin.admin-users.create') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:-translate-y-1 transition-all flex items-center gap-2">
            <span class="material-icons text-sm">person_add</span> New Staff
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
                        <th class="px-8 py-6 uppercase">Username</th>
                        <th class="px-8 py-6 uppercase">Email Address</th>
                        <th class="px-8 py-6 uppercase">Assigned Role</th>
                        <th class="px-8 py-6 uppercase text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($admins as $adminUser)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6 font-bold text-slate-800 flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-black text-lg">
                                    {{ strtoupper(substr($adminUser->username, 0, 1)) }}
                                </div>
                                {{ $adminUser->username }}
                            </td>
                            <td class="px-8 py-6 text-slate-500 font-medium">{{ $adminUser->email }}</td>
                            <td class="px-8 py-6">
                                @if($adminUser->is_superadmin)
                                    <span class="bg-amber-50 text-amber-600 border border-amber-200 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest inline-flex items-center gap-1.5"><span class="material-icons text-sm">security</span> Superadmin</span>
                                @else
                                    <span class="bg-slate-100 text-slate-700 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest">{{ $adminUser->role ? $adminUser->role->name : 'No Role Assigned' }}</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2 text-right">
                                    @if(!$adminUser->is_superadmin || auth('admin')->user()->is_superadmin)
                                    <a href="{{ route('admin.admin-users.edit', $adminUser->id) }}" class="w-10 h-10 rounded-xl bg-orange-50 text-accent hover:bg-accent hover:text-white transition-all flex items-center justify-center shadow-sm" title="Edit">
                                        <span class="material-icons text-sm">edit</span>
                                    </a>
                                    @endif

                                    @if(!$adminUser->is_superadmin && $adminUser->id !== auth('admin')->id())
                                    <form action="{{ route('admin.admin-users.destroy', $adminUser->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this staff account?');">
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
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-icons text-4xl text-slate-200">manage_accounts</span>
                                </div>
                                <h3 class="text-lg font-black text-slate-400 uppercase tracking-widest">No Staff Found</h3>
                                <p class="text-slate-400 text-sm">Register a staff account to grant backend access.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
