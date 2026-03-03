@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Mission Overview</h2>
            <p class="text-slate-500 font-medium">Real-time stats for <b>India @ 2047</b> goal.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-white p-2 rounded-xl border border-slate-200 flex items-center gap-2 px-4 shadow-sm">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-600">Live Analytics</span>
            </div>
        </div>
    </header>

    <!-- Analytics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
        <div class="stat-card bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group">
            <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <span class="material-icons text-3xl">groups</span>
            </div>
            <h3 class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Active Members</h3>
            <div class="text-4xl font-bold text-slate-800 mt-1">{{ number_format($totalMembers) }}</div>
            <div class="text-[10px] text-green-500 font-bold mt-4 flex items-center gap-1">
                <span class="material-icons text-xs">trending_up</span>
                Network Growth
            </div>
        </div>

        <div class="stat-card bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group">
            <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <span class="material-icons text-3xl">payments</span>
            </div>
            <h3 class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Sales ({{ now()->format('M') }})</h3>
            <div class="text-4xl font-black text-slate-800 mt-1">₹{{ number_format($salesThisMonth) }}</div>
            <div class="text-[10px] text-slate-400 font-bold mt-4 px-3 py-1 bg-slate-50 rounded-full inline-block">Target: ₹2.5L</div>
        </div>

        <div class="stat-card bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group">
            <div class="w-14 h-14 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <span class="material-icons text-3xl">shopping_cart</span>
            </div>
            <h3 class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Plan Purchases</h3>
            <div class="text-4xl font-bold text-slate-800 mt-1">{{ $membershipVol }}</div>
            <div class="text-[10px] text-blue-500 font-semibold mt-4 uppercase tracking-widest">Standard Velocity</div>
        </div>

        <div class="stat-card bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group">
            <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <span class="material-icons text-3xl">confirmation_number</span>
            </div>
            <h3 class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Tickets Purchased</h3>
            <div class="text-4xl font-bold text-slate-800 mt-1">{{ $eventSalesCount }}</div>
            <div class="text-[10px] text-amber-500 font-semibold mt-4 uppercase tracking-widest">Event Engagement</div>
        </div>

        <div class="stat-card bg-white p-8 rounded-3xl shadow-sm border border-slate-100 group">
            <div class="w-14 h-14 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <span class="material-icons text-3xl">event</span>
            </div>
            <h3 class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Active Events</h3>
            <div class="text-4xl font-black text-slate-800 mt-1">{{ $activeEvents }}</div>
            <div class="text-[10px] {{ $activeEvents > 0 ? 'text-orange-500' : 'text-slate-400' }} font-bold mt-4 uppercase tracking-widest">
                {{ $activeEvents > 0 ? "Upcoming Initiatives" : "None Planned" }}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Role Distribution -->
        <div class="lg:col-span-1 bg-white p-10 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-full -mr-16 -mt-16 -z-0"></div>
            <h3 class="font-black text-slate-800 mb-8 flex items-center gap-3 relative z-10 uppercase tracking-tight">
                <span class="material-icons text-slate-400">category</span>
                Category Split
            </h3>
            <div class="space-y-8 relative z-10">
                @foreach($roleStats as $role => $count)
                <div class="space-y-3">
                    <div class="flex justify-between text-[10px] font-black uppercase tracking-widest">
                        <span class="text-slate-600">{{ $role }}</span>
                        <span class="text-slate-400">{{ $count }}</span>
                    </div>
                    <div class="w-full h-2 bg-slate-50 rounded-full overflow-hidden shadow-inner">
                        @php 
                            $percent = $totalMembers > 0 ? ($count / $totalMembers) * 100 : 0;
                        @endphp
                        <div class="h-full bg-slate-300 rounded-full transition-all duration-1000" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white p-10 rounded-3xl shadow-sm border border-slate-100">
            <h3 class="font-black text-slate-800 mb-8 flex items-center gap-3 uppercase tracking-tight">
                <span class="material-icons text-slate-400">history</span>
                Recent Transactions
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                        <tr>
                            <th class="px-6 py-4 rounded-l-2xl">Member</th>
                            <th class="px-6 py-4 text-center">Amount</th>
                            <th class="px-6 py-4 text-right rounded-r-2xl">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentActivity as $act)
                        <tr class="group hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="text-sm font-bold text-slate-800 group-hover:text-primary transition-colors">{{ $act->member->name ?? 'Unknown User' }}</div>
                                <div class="text-[9px] font-semibold text-slate-400 mt-0.5">ID: #{{ str_pad($act->member_id, 6, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-4 py-1.5 bg-green-50 text-green-600 rounded-full text-xs font-black">₹{{ number_format($act->amount) }}</span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="text-[10px] font-black text-slate-500 uppercase tracking-tight">{{ $act->created_at->format('d M, h:i A') }}</div>
                                <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $act->created_at->diffForHumans() }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-20 text-center text-slate-400 text-[10px] font-black uppercase tracking-widest italic opacity-50">No recent transactions reported found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-8 pt-8 border-t border-slate-50 text-center">
                <a href="#" class="inline-flex items-center gap-2 text-[10px] font-bold text-accent uppercase tracking-widest hover:gap-4 transition-all">
                    View Comprehensive Sales Report <span class="material-icons text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
