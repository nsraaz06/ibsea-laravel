@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Institutional Intelligence (Sales Analytics)</h2>
            <p class="text-slate-500 font-semibold italic">Monitor revenue trajectories and membership momentum.</p>
        </div>
        <div class="flex gap-4">
            <button class="bg-white border border-slate-200 text-slate-600 px-6 py-3 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                <span class="material-icons text-sm">file_download</span> Export Report
            </button>
        </div>
    </header>

    <!-- Filter Bar -->
    <div class="bg-white p-8 rounded-[2rem] shadow-premium border border-slate-100 mb-10 transition-all">
        <form action="{{ route('admin.analytics.index') }}" method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 items-end">
            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Time Range</label>
                <select name="time_range" id="time_range" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-accent transition-all appearance-none cursor-pointer">
                    <option value="">All Time</option>
                    <option value="today" {{ request('time_range') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ request('time_range') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="7_days" {{ request('time_range') == '7_days' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="15_days" {{ request('time_range') == '15_days' ? 'selected' : '' }}>Last 15 Days</option>
                    <option value="1_month" {{ request('time_range') == '1_month' ? 'selected' : '' }}>Last 1 Month</option>
                    <option value="3_month" {{ request('time_range') == '3_month' ? 'selected' : '' }}>Last 3 Months</option>
                    <option value="custom" {{ request('time_range') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>

            <div class="space-y-3 purpose-filter">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Institutional Purpose</label>
                <select name="purpose" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-accent transition-all appearance-none cursor-pointer">
                    <option value="">All Purposes</option>
                    @foreach($purposes as $purpose)
                        <option value="{{ $purpose }}" {{ request('purpose') == $purpose ? 'selected' : '' }}>{{ $purpose }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-3 plan-filter">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Mission Plan</label>
                <select name="plan" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-accent transition-all appearance-none cursor-pointer">
                    <option value="">All Plans</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ request('plan') == $plan->id ? 'selected' : '' }}>{{ $plan->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 {{ request('time_range') == 'custom' ? 'flex' : 'hidden' }}" id="custom-date-fields">
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-accent transition-all">
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-accent transition-all">
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-primary text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-sm hover:bg-secondary transition-all flex items-center gap-2">
                    <span class="material-icons text-sm">filter_alt</span> Filter
                </button>
                @if(request()->anyFilled(['time_range', 'purpose', 'plan', 'start_date', 'end_date']))
                <a href="{{ route('admin.analytics.index') }}" class="bg-slate-100 text-slate-500 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center gap-2">
                    <span class="material-icons text-sm">close</span> Clear
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 blur-2xl group-hover:bg-primary/10 transition-all"></div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                    <span class="material-icons">account_balance_wallet</span>
                </div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Revenue</h4>
            </div>
            <div class="text-3xl font-black text-slate-800">₹{{ number_format($totalRevenue, 0) }}</div>
            <div class="text-[10px] font-bold text-ibsea-green flex items-center gap-1 mt-2">
                <span class="material-icons text-xs">trending_up</span> Institutional Capital
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-accent/5 rounded-full -mr-16 -mt-16 blur-2xl group-hover:bg-accent/10 transition-all"></div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-accent/10 rounded-2xl flex items-center justify-center text-accent">
                    <span class="material-icons">receipt_long</span>
                </div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Transactions</h4>
            </div>
            <div class="text-3xl font-black text-slate-800">{{ number_format($totalTransactions) }}</div>
            <div class="text-[10px] font-bold text-slate-500 flex items-center gap-1 mt-2">
                Contribution Count
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -mr-16 -mt-16 blur-2xl group-hover:bg-blue-500/10 transition-all"></div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500">
                    <span class="material-icons">groups</span>
                </div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Network Size</h4>
            </div>
            <div class="text-3xl font-black text-slate-800">{{ number_format($totalMembers) }}</div>
            <div class="text-[10px] font-bold text-blue-500 flex items-center gap-1 mt-2">
                Institutional Reach
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-premium border border-slate-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-ibsea-green/5 rounded-full -mr-16 -mt-16 blur-2xl group-hover:bg-ibsea-green/10 transition-all"></div>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-ibsea-green/10 rounded-2xl flex items-center justify-center text-ibsea-green">
                    <span class="material-icons">person_add</span>
                </div>
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">New Intake</h4>
            </div>
            <div class="text-3xl font-black text-slate-800">{{ number_format($newMembersThisMonth) }}</div>
            <div class="text-[10px] font-bold text-ibsea-green flex items-center gap-1 mt-2">
                This Financial Cycle
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-[2.5rem] shadow-premium border border-slate-100 overflow-hidden">
        <div class="px-10 py-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <div class="flex items-center gap-6">
                <h3 class="text-sm font-black text-primary uppercase tracking-widest">Contribution Intelligence</h3>
                <div id="bulk-actions" class="hidden animate-in fade-in slide-in-from-left-4 duration-300">
                    <button onclick="bulkArchive()" class="bg-red-500 text-white px-6 py-2 rounded-xl font-bold text-[10px] uppercase tracking-widest shadow-sm hover:bg-red-600 transition-all flex items-center gap-2">
                        <span class="material-icons text-sm">archive</span> Archive Selected
                    </button>
                </div>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase italic leading-none">Intelligence Synchronization Live</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-8 py-6 w-10">
                            <label class="flex items-center justify-center cursor-pointer">
                                <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-slate-300 transform transition-all focus:ring-accent text-accent">
                            </label>
                        </th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Contributor</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Purpose</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Quantum</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($payments as $payment)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <label class="flex items-center justify-center cursor-pointer">
                                <input type="checkbox" name="ids[]" value="{{ $payment->id }}" class="payment-checkbox w-4 h-4 rounded border-slate-300 transform transition-all focus:ring-accent text-accent">
                            </label>
                        </td>
                        <td class="px-6 py-6 font-bold text-slate-800 text-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all">
                                    <span class="material-icons text-sm">person</span>
                                </div>
                                <div class="flex flex-col">
                                    <span>{{ $payment->member->name ?? 'Ex-Member' }}</span>
                                    <span class="text-[9px] text-slate-400 uppercase tracking-widest">
                                        {{ $payment->member->membershipPlan->title ?? 'Baseline' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6 font-semibold text-slate-500 text-xs">
                             {{ $payment->payment_type ?? 'Institutional Initiative' }}
                        </td>
                        <td class="px-10 py-6 font-black text-slate-800 text-sm">₹{{ number_format($payment->amount, 2) }}</td>
                        <td class="px-10 py-6">
                            <span class="px-3 py-1 {{ $payment->status === 'Success' ? 'bg-ibsea-green/10 text-ibsea-green' : 'bg-red-50 text-red-500' }} rounded-full text-[9px] font-black uppercase tracking-widest">
                                {{ $payment->status }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right text-[10px] font-bold text-slate-400 uppercase">
                            {{ $payment->created_at->format('d M, H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-10 py-24 text-center">
                            <span class="material-icons text-4xl text-slate-200 mb-2">payments</span>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No Intelligence Data Found For Current Parameters</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('time_range').addEventListener('change', function() {
        const customFields = document.getElementById('custom-date-fields');
        if (this.value === 'custom') {
            customFields.classList.remove('hidden');
            customFields.classList.add('flex');
        } else {
            customFields.classList.add('hidden');
            customFields.classList.remove('flex');
        }
    });

    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.payment-checkbox');
    const bulkActions = document.getElementById('bulk-actions');

    function updateBulkActionVisibility() {
        const checkedCount = document.querySelectorAll('.payment-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkActions.classList.remove('hidden');
        } else {
            bulkActions.classList.add('hidden');
        }
    }

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => {
            cb.checked = this.checked;
        });
        updateBulkActionVisibility();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            if (!this.checked) selectAll.checked = false;
            updateBulkActionVisibility();
        });
    });

    function bulkArchive() {
        const selectedIds = Array.from(document.querySelectorAll('.payment-checkbox:checked')).map(cb => cb.value);
        
        if (selectedIds.length === 0) return;

        if (confirm(`Archive ${selectedIds.length} intelligence dispatches permanently?`)) {
            fetch("{{ route('admin.analytics.bulk-delete') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ids: selectedIds })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Communication breakdown with intelligence server.');
            });
        }
    }
</script>
@endsection
