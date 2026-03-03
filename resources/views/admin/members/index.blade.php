@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Member Directory</h2>
            <p class="text-slate-500 font-medium">Manage and vet mission members across the globe.</p>
        </div>
        <a href="{{ route('admin.members.create') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 active:scale-95 transition-all flex items-center gap-2">
            <span class="material-icons">person_add</span>
            Add New Member
        </a>
    </header>

    <!-- Filter Bar -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8 flex flex-col md:flex-row gap-6">
        <form action="{{ route('admin.members.index') }}" method="GET" class="flex-1 flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
            </div>
            
            <select name="status" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-2xl px-6 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                <option value="">All Statuses</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Vetted" {{ request('status') == 'Vetted' ? 'selected' : '' }}>Vetted</option>
                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Suspended" {{ request('status') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
            </select>

            <select name="role_id" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-2xl px-6 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                @endforeach
            </select>

            <select name="chapter_id" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-2xl px-6 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                <option value="">All Chapters</option>
                @foreach($chapters as $chapter)
                    <option value="{{ $chapter->id }}" {{ request('chapter_id') == $chapter->id ? 'selected' : '' }}>{{ $chapter->name }}</option>
                @endforeach
            </select>

            <select name="state" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-2xl px-6 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                <option value="">All States</option>
                @foreach($states as $state)
                    <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all hover:bg-black">
                Apply Filters
            </button>
            
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('admin.members.index') }}" class="bg-slate-100 text-slate-500 px-6 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Bulk Actions Toolbar (Hidden by default) -->
    <div id="bulk-actions" class="hidden bg-slate-900 text-white p-4 rounded-2xl shadow-lg mb-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <span class="font-bold text-sm"><span id="selected-count">0</span> Selected</span>
            <div class="h-4 w-px bg-slate-700"></div>
            <button onclick="submitBulkAction('{{ route('admin.members.bulk-destroy') }}')" class="flex items-center gap-2 text-red-400 hover:text-red-300 font-bold text-xs uppercase tracking-widest transition-colors">
                <span class="material-icons text-sm">delete</span> Delete
            </button>
        </div>
        <div class="flex items-center gap-2">
            <form id="bulk-role-form" action="{{ route('admin.members.bulk-update-role') }}" method="POST" class="flex gap-2">
                @csrf
                <select name="role_id" required class="bg-slate-800 border-none rounded-xl px-4 py-2 text-xs font-bold text-white focus:ring-2 focus:ring-primary">
                    <option value="">Change System Role...</option>
                    @foreach(\App\Models\MemberRole::all() as $role)
                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
                <button type="button" onclick="submitBulkRoleUpdate()" class="bg-primary text-white px-4 py-2 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-primary/90">
                    Apply
                </button>
            </form>
        </div>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);" class="text-xs font-bold text-primary tracking-wide">
                    <tr>
                        <th class="px-8 py-6 w-16">
                            <input type="checkbox" id="select-all" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </th>
                        <th class="px-8 py-6 text-left">Member Identity</th>
                        <th class="px-8 py-6 text-left">System Role</th>
                        <th class="px-8 py-6 text-left">Institutional Detail</th>
                        <th class="px-8 py-6 text-left">Status</th>
                        <th class="px-8 py-6 text-left">Mission Start</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($members as $member)
                    <tr class="group transition-colors {{ $loop->even ? 'bg-slate-50/30' : 'bg-white' }} hover:bg-ibsea-orange/5">
                        <td class="px-8 py-6">
                            <input type="checkbox" name="selected_members[]" value="{{ $member->id }}" class="member-checkbox rounded border-slate-300 text-primary focus:ring-primary">
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl overflow-hidden bg-slate-100 border border-slate-100">
                                    <img src="{{ $member->profile_image ? (Str::startsWith(ltrim(str_replace('\\', '/', $member->profile_image), '/'), 'uploads/') ? asset(ltrim(str_replace('\\', '/', $member->profile_image), '/')) : asset('storage/' . ltrim(str_replace('\\', '/', $member->profile_image), '/'))) : 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=f1f5f9&color=0f172a&bold=true' }}" class="w-full h-full object-cover" />
                                </div>
                                <div>
                                    <div class="text-base font-bold text-slate-800">{{ $member->name }}</div>
                                    <div class="text-[10px] font-black text-primary uppercase tracking-widest mt-0.5">{{ $member->membership_id }}</div>
                                    <div class="text-xs font-semibold text-slate-500">{{ $member->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                             <div class="inline-flex px-3 py-1.5 rounded-lg text-xs font-bold" style="background-color: #f26f21; color: white;">
                                {{ $member->memberRole->role_name ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-xs font-bold mb-1" style="color: #004a95;">{{ $member->role }}</div>
                            <div class="text-[10px] font-bold text-accent mb-1">{{ optional($member->membershipPlan)->title ?? 'No Plan' }}</div>
                            <div class="text-xs font-semibold text-slate-600">{{ $member->chapter->name ?? 'Global' }}</div>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusClasses = [
                                    'Pending' => 'bg-amber-50 text-amber-600',
                                    'Vetted' => 'bg-blue-50 text-blue-600',
                                    'Active' => 'bg-green-50 text-green-600',
                                    'Suspended' => 'bg-red-50 text-red-600'
                                ];
                            @endphp
                            <span class="inline-flex px-3 py-1.5 rounded-lg text-xs font-bold {{ $statusClasses[$member->status] ?? 'bg-slate-50 text-slate-600' }}">
                                {{ $member->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-xs font-semibold text-slate-600">{{ $member->created_at->format('d M, Y') }}</div>
                            <div class="text-[10px] font-semibold text-slate-400">{{ $member->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2 text-right">
                                <a href="{{ route('admin.members.edit', $member) }}" class="w-10 h-10 rounded-xl bg-orange-50 text-accent hover:bg-accent hover:text-white transition-all flex items-center justify-center shadow-sm">
                                    <span class="material-icons">edit</span>
                                </a>
                                <form action="{{ route('admin.members.destroy', $member) }}" method="POST" onsubmit="return confirm('Archive this member mission data?')">
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
                        <td colspan="7" class="px-8 py-20 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="material-icons text-4xl text-slate-200">person_off</span>
                            </div>
                            <h3 class="text-lg font-black text-slate-400 uppercase tracking-widest">No Members Found</h3>
                            <p class="text-slate-400 text-sm">Try adjusting your filters or search query.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
            {{ $members->links() }}
        </div>
        @endif
    </div>
</div>

<form id="bulk-action-form" method="POST" class="hidden">
    @csrf
</form>

<script>
    const selectAll = document.getElementById('select-all');
    const memberCheckboxes = document.querySelectorAll('.member-checkbox');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    const bulkActionForm = document.getElementById('bulk-action-form');
    const bulkRoleForm = document.getElementById('bulk-role-form');

    function updateBulkToolbar() {
        const count = document.querySelectorAll('.member-checkbox:checked').length;
        selectedCount.textContent = count;
        if (count > 0) {
            bulkActions.classList.remove('hidden');
        } else {
            bulkActions.classList.add('hidden');
        }
    }

    selectAll.addEventListener('change', function() {
        memberCheckboxes.forEach(cb => cb.checked = this.checked);
        updateBulkToolbar();
    });

    memberCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkToolbar);
    });

    function submitBulkAction(url) {
        if (!confirm('Are you sure you want to proceed with this bulk action?')) return;
        
        bulkActionForm.action = url;
        bulkActionForm.innerHTML = '@csrf'; // Reset

        document.querySelectorAll('.member-checkbox:checked').forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            bulkActionForm.appendChild(input);
        });

        bulkActionForm.submit();
    }
    
    function submitBulkRoleUpdate() {
        const roleSelect = bulkRoleForm.querySelector('select[name="role_id"]');
        if (!roleSelect.value) {
            alert('Please select a system role to apply.');
            return;
        }
        
        if (!confirm('Update role for selected members?')) return;

        // Add IDs to role form
        document.querySelectorAll('.member-checkbox:checked').forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = cb.value;
            bulkRoleForm.appendChild(input);
        });

        bulkRoleForm.submit();
    }
</script>
@endsection
