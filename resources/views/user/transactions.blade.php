@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <main class="flex-1 overflow-y-auto p-4 md:p-12">
        <div class="max-w-6xl mx-auto space-y-12">
            <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4">
                        <span class="material-icons text-xs">receipt_long</span>
                        Financial Ledger
                    </div>
                    <h1 class="text-4xl font-black text-slate-800 dark:text-white uppercase tracking-tight">Transaction History</h1>
                    <p class="text-slate-500 font-medium mt-2">Track your ticket bookings and membership investments.</p>
                </div>
            </header>

            <div class="grid grid-cols-1 gap-12">
                <!-- Payments History -->
                <div class="space-y-8">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tight">Recent Payments</h2>
                    </div>

                    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="border-b border-slate-50 dark:border-slate-800">
                                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Transaction ID</th>
                                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Type</th>
                                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Amount</th>
                                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                    @forelse($payments as $payment)
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                            <td class="px-8 py-6">
                                                <span class="text-xs font-black text-slate-700 dark:text-slate-300">#{{ $payment->cashfree_order_id ?? 'N/A' }}</span>
                                            </td>
                                            <td class="px-8 py-6">
                                                <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800 rounded text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                                    {{ $payment->payment_type }}
                                                </span>
                                            </td>
                                            <td class="px-8 py-6">
                                                <span class="text-sm font-black text-slate-800 dark:text-white">₹{{ number_format($payment->amount, 2) }}</span>
                                            </td>
                                            <td class="px-8 py-6">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $payment->status === 'Success' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                                                    <span class="w-1 h-1 rounded-full bg-current"></span>
                                                    {{ $payment->status }}
                                                </span>
                                            </td>
                                            <td class="px-8 py-6 text-xs text-slate-500 font-bold">
                                                {{ $payment->created_at->format('d M, Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-8 py-20 text-center">
                                                <p class="text-xs font-black text-slate-300 uppercase tracking-widest">No transaction records found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($payments->hasPages())
                            <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800">
                                {{ $payments->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
