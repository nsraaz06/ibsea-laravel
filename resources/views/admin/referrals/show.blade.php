@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.referrals.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 hover:text-slate-600 transition-all border border-slate-100 shadow-sm">
                <span class="material-icons">arrow_back</span>
            </a>
            <div>
                <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">{{ $member->name }}'s <span class="text-indigo-600">Network</span></h2>
                <p class="text-slate-500 font-medium italic">Ambassador Code: {{ $member->referral_code }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-indigo-50 text-indigo-600 px-5 py-3 rounded-2xl border border-indigo-100 flex items-center gap-3">
                <span class="material-icons text-lg">military_tech</span>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-60 leading-none mb-1">Current Rank</p>
                    <p class="text-xl font-black leading-none">{{ $member->strategic_rank ?? 'Member' }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Ambassador Summary Bar -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-[1.5rem] p-6 border border-slate-100 shadow-sm col-span-2">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xl">
                    {{ substr($member->name, 0, 1) }}
                </div>
                <div>
                    <div class="text-lg font-black text-slate-800 uppercase tracking-tight">{{ $member->name }}</div>
                    <div class="text-sm font-bold text-slate-400">{{ $member->email }}</div>
                    <div class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mt-1">{{ $member->chapter->name ?? 'No Chapter' }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-[1.5rem] p-6 border border-slate-100 shadow-sm text-center">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Referrals</p>
            <p class="text-3xl font-black text-slate-900">{{ $member->referral_count }}</p>
        </div>
        <div class="bg-white rounded-[1.5rem] p-6 border border-slate-100 shadow-sm text-center">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Growth Index</p>
            <div class="flex items-center justify-center gap-2 text-green-500 font-black">
                <span class="material-icons text-sm">trending_up</span>
                <span>Active</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h3 class="font-black text-slate-800 uppercase tracking-tight">Direct Referrals (Joined via Link)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                    <tr>
                        <th class="px-8 py-6">Member</th>
                        <th class="px-8 py-6">Chapter</th>
                        <th class="px-8 py-6">Membership Plan</th>
                        <th class="px-8 py-6">Join Date</th>
                        <th class="px-8 py-6 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($referrals as $referred)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-[10px]">
                                    {{ substr($referred->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-800">{{ $referred->name }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold">{{ $referred->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">
                                {{ $referred->chapter->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">
                                {{ $referred->membershipPlan->title ?? 'Guest' }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                                {{ $referred->created_at->format('d M, Y') }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="px-3 py-1 {{ $referred->status === 'Active' ? 'bg-green-50 text-green-600' : 'bg-slate-50 text-slate-400' }} rounded-full text-[9px] font-black uppercase tracking-widest">
                                {{ $referred->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400 text-xs font-bold uppercase tracking-widest">
                            This member has not referred anyone yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-50">
            {{ $referrals->links() }}
        </div>
    </div>
</div>
@endsection
