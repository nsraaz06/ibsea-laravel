@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Referral <span class="text-indigo-600">Network</span></h2>
            <p class="text-slate-500 font-medium">Track viral growth and top ambassadors.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-indigo-50 text-indigo-600 px-5 py-3 rounded-2xl border border-indigo-100 flex items-center gap-3">
                <span class="material-icons text-lg">groups</span>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-60 leading-none mb-1">Total Network</p>
                    <p class="text-xl font-black leading-none">{{ number_format($totalReferrals) }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Filter Intelligence -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8 mb-8">
        <form action="{{ route('admin.referrals.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-6 items-end">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Chapter Filter</label>
                <select name="chapter_id" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Chapters</option>
                    @foreach($chapters as $chapter)
                        <option value="{{ $chapter->id }}" {{ request('chapter_id') == $chapter->id ? 'selected' : '' }}>{{ $chapter->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Month Wise</label>
                <input type="month" name="month" value="{{ request('month') }}" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">From Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">To Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-slate-900 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition-all">
                    Filter
                </button>
                <a href="{{ route('admin.referrals.index') }}" class="bg-slate-100 text-slate-500 px-4 py-3 rounded-xl flex items-center justify-center hover:bg-slate-200 transition-all">
                    <span class="material-icons text-sm">refresh</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Performance Insights -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-indigo-600 rounded-[2rem] p-8 text-white shadow-xl shadow-indigo-200 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-4">Top Ambassador</p>
                @if($topReferrer)
                    <h4 class="text-xl font-black uppercase mb-1">{{ $topReferrer->name }}</h4>
                    <p class="text-xs font-bold opacity-60">{{ $topReferrer->referral_count }} Direct Joins</p>
                @else
                    <h4 class="text-xl font-black uppercase mb-1">None yet</h4>
                @endif
            </div>
            <span class="material-icons absolute -right-4 -bottom-4 text-8xl opacity-10">military_tech</span>
        </div>

        <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Network Growth</p>
            <div class="flex items-end gap-3">
                <h4 class="text-3xl font-black text-slate-800">{{ $totalReferrals }}</h4>
                <div class="flex items-center text-green-500 text-[10px] font-black mb-1">
                    <span class="material-icons text-sm">trending_up</span>
                    <span>VIRAL</span>
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest">Across all chapters</p>
        </div>

        <div class="bg-slate-900 rounded-[2rem] p-8 text-white shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-400 mb-4">Active Campaign</p>
                <h4 class="text-xl font-black uppercase mb-1">Viral Expansion</h4>
                <p class="text-xs font-bold opacity-60">Reward active referrers</p>
            </div>
            <div class="absolute right-8 top-1/2 -translate-y-1/2">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                    <span class="material-icons text-indigo-400">rocket_launch</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h3 class="font-black text-slate-800 uppercase tracking-tight">Top Ambassadors</h3>
            @if($topReferrer)
            <div class="flex items-center gap-2 bg-yellow-50 px-3 py-1 rounded-full border border-yellow-100">
                <span class="material-icons text-yellow-500 text-sm">emoji_events</span>
                <span class="text-[10px] font-bold text-yellow-700 uppercase tracking-widest">Top: {{ $topReferrer->name }} ({{ $topReferrer->referral_count }})</span>
            </div>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                    <tr>
                        <th class="px-8 py-6">Member</th>
                        <th class="px-8 py-6">Referral Code</th>
                        <th class="px-8 py-6 text-center">Total Referrals</th>
                        <th class="px-8 py-6">Strategic Rank</th>
                        <th class="px-8 py-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($topReferrers as $referrer)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xs">
                                    {{ substr($referrer->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-800">{{ $referrer->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $referrer->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <code class="px-2 py-1 bg-slate-100 rounded text-xs font-mono text-slate-600 border border-slate-200">{{ $referrer->referral_code }}</code>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-lg font-black text-indigo-600">{{ $referrer->referral_count }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-widest">
                                {{ $referrer->strategic_rank ?? 'Member' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('admin.referrals.show', $referrer->id) }}" class="inline-flex items-center gap-2 bg-slate-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all group">
                                View Network
                                <span class="material-icons text-xs group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-12 text-center text-slate-400 text-xs font-bold uppercase tracking-widest">
                            No referrals recorded yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-50">
            {{ $topReferrers->links() }}
        </div>
    </div>
</div>
@endsection
