@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        
        <!-- Hero Section -->
        <div class="relative bg-slate-900 border-b border-white/5 pb-12 pt-8">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:32px_32px]"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/50 via-slate-900/80 to-slate-900"></div>
            
            <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest">
                                Viral Growth Engine
                            </div>
                            <span class="text-slate-500 text-xs font-medium">{{ now()->format('F d, Y') }}</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight mb-2">
                            Referral <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Hub</span>
                        </h1>
                        <p class="text-slate-400 text-sm max-w-xl leading-relaxed">
                            Expand the alliance. Track your impact. Rise through the ranks.
                        </p>
                    </div>
                    
                    <!-- Rank Card -->
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-4 backdrop-blur-sm min-w-[200px]">
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Current Strategic Rank</div>
                        <div class="text-xl font-black text-yellow-500 flex items-center gap-2">
                            <span class="material-icons text-yellow-500">military_tech</span>
                            {{ $rank }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 -mt-8 relative z-10 space-y-8 pb-20">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach([
                    ['label' => 'Total Referrals', 'value' => $totalReferrals, 'icon' => 'group_add', 'color' => 'text-blue-500', 'bg' => 'bg-blue-500/10'],
                    ['label' => 'Active Members', 'value' => $activeReferrals, 'icon' => 'verified_user', 'color' => 'text-green-500', 'bg' => 'bg-green-500/10'],
                    ['label' => 'Pending', 'value' => $pendingReferrals, 'icon' => 'hourglass_empty', 'color' => 'text-orange-500', 'bg' => 'bg-orange-500/10']
                ] as $stat)
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-xl shadow-slate-200/50 dark:shadow-none relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 {{ $stat['bg'] }} rounded-bl-[100px] opacity-20 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="w-12 h-12 {{ $stat['bg'] }} rounded-2xl flex items-center justify-center mb-4 text-xl {{ $stat['color'] }}">
                            <span class="material-icons">{{ $stat['icon'] }}</span>
                        </div>
                        <div class="text-4xl font-black text-slate-800 dark:text-white mb-1">{{ $stat['value'] }}</div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">{{ $stat['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Referral Sharing Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Referral Link Card -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-lg overflow-hidden flex flex-col">
                    <div class="p-8 flex-1">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
                                <span class="material-icons text-indigo-500">link</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Unique Referral Link</h3>
                                <p class="text-xs text-slate-500 mt-1">Direct access for new applicants.</p>
                            </div>
                        </div>
                        
                        <div class="relative group">
                            <input type="text" readonly value="{{ route('register', ['referral_code' => $user->referral_code]) }}" 
                                class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 text-slate-600 dark:text-slate-300 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 pr-12" id="referralLink">
                            <button onclick="copyToClipboard('{{ route('register', ['referral_code' => $user->referral_code]) }}', 'link')" class="absolute right-2 top-2 p-2 bg-white dark:bg-slate-800 rounded-lg shadow-sm text-slate-400 hover:text-indigo-500 transition-all active:scale-95">
                                <span class="material-icons text-sm">content_copy</span>
                            </button>
                        </div>
                    </div>
                    <div class="px-8 py-6 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700 flex flex-wrap gap-3">
                        <a href="https://wa.me/?text=I'm%20inviting%20you%20to%20join%20the%20IBSEA%20Alliance!%20Register%20using%20my%20code:%20{{ $user->referral_code }}%20at:%20{{ route('register', ['referral_code' => $user->referral_code]) }}" target="_blank" 
                           class="flex-1 px-4 py-3 bg-[#25D366] hover:bg-[#20bd5a] text-white rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all active:scale-95 shadow-lg shadow-green-500/20">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('register', ['referral_code' => $user->referral_code]) }}" target="_blank"
                           class="flex-1 px-4 py-3 bg-[#0077b5] hover:bg-[#006396] text-white rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition-all active:scale-95 shadow-lg shadow-blue-500/20">
                            <i class="fab fa-linkedin-in"></i> LinkedIn
                        </a>
                    </div>
                </div>

                <!-- Referral Code Card -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-lg overflow-hidden flex flex-col">
                    <div class="p-8 flex-1">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-icons">qr_code</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Active Referral ID</h3>
                                <p class="text-xs text-slate-500 mt-1">Manual entry for institutional checkout.</p>
                            </div>
                        </div>

                        <div class="bg-primary/5 dark:bg-primary/10 p-6 rounded-[2rem] border-2 border-dashed border-primary/20 flex flex-col items-center justify-center gap-4">
                            <div class="text-4xl font-black text-primary tracking-[0.2em] italic uppercase">{{ $user->referral_code }}</div>
                            <button onclick="copyToClipboard('{{ $user->referral_code }}', 'code')" class="bg-white dark:bg-slate-900 text-slate-800 dark:text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-xl shadow-slate-200 dark:shadow-none active:scale-95 transition-all flex items-center gap-2 border border-slate-100 dark:border-slate-800">
                                <span class="material-icons text-sm">content_copy</span>
                                Copy Institutional ID
                            </button>
                        </div>
                    </div>
                    <div class="px-8 py-6 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Share this ID for offline/manual registrations</p>
                    </div>
                </div>
            </div>

            <!-- My Network Table -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-lg overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest">My Network</h3>
                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Global Impact</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Member</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Joined</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Impact</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($directReferrals as $referral)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex-shrink-0 overflow-hidden">
                                            @if($referral->profile_image)
                                                <img src="{{ asset($referral->profile_image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs font-bold">
                                                    {{ substr($referral->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-800 dark:text-white">{{ $referral->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $referral->profession ?? 'Member' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs font-medium text-slate-500">
                                    {{ $referral->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-md text-[10px] font-black uppercase tracking-wider {{ $referral->status === 'Active' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                        {{ $referral->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-600 dark:text-slate-400">
                                    {{ $referral->referral_count }} Referrals
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-sm">
                                    You haven't referred anyone yet. Share your code to start building your legacy!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-slate-100 dark:border-slate-700">
                    {{ $directReferrals->links() }}
                </div>
            </div>

        </div>
    </main>
</div>

<script>
    function copyToClipboard(text, type) {
        navigator.clipboard.writeText(text).then(() => {
            alert(type === 'code' ? 'Referral Code Copied!' : 'Referral Link Copied!');
        }).catch(err => {
            console.error('Failed to copy: ', err);
            // Fallback
            const el = document.createElement('textarea');
            el.value = text;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            alert(type === 'code' ? 'Referral Code Copied!' : 'Referral Link Copied!');
        });
    }
</script>
@endsection
