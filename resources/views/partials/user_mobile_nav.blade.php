<!-- Mobile Member Horizontal Navigation -->
<div class="md:hidden sticky top-[72px] z-[990] bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm overflow-x-auto hide-scrollbar">
    <div class="flex items-center gap-2 px-4 py-3 min-w-max">
        
        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('user.dashboard') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700' }}">
            <span class="material-icons text-[16px]">dashboard</span>
            Home
        </a>

        @if(!Auth::guard('member')->user()->isRestricted())
            <a href="{{ route('user.profile') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('user.profile') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700' }}">
                <span class="material-icons text-[16px]">account_circle</span>
                Portfolio
            </a>
        @endif

        <a href="{{ route('user.notifications.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('user.notifications.index') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700' }}">
            <div class="relative">
                <span class="material-icons text-[16px]">notifications</span>
                @php $unread = \App\Models\Notification::where('user_id', Auth::guard('member')->id())->where('is_read', false)->count(); @endphp
                @if($unread > 0)
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                @endif
            </div>
            Alerts
        </a>

        @if(!Auth::guard('member')->user()->isRestricted())
            @if(\App\Models\SiteSetting::where('key', 'allow_certificate_download')->value('value') == 1)
                <a href="{{ route('user.assets.preview', ['type' => 'certificate']) }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700">
                    <span class="material-icons text-[16px] text-primary">workspace_premium</span>
                    Certificate
                </a>
            @endif
            @if(\App\Models\SiteSetting::where('key', 'allow_id_card_download')->value('value') == 1)
                <a href="{{ route('user.assets.preview', ['type' => 'id_card']) }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700">
                    <span class="material-icons text-[16px] text-primary">badge</span>
                    ID Card
                </a>
            @endif
        @endif

        @if(!Auth::guard('member')->user()->isRestricted() && \App\Models\SiteSetting::where('key', 'allow_referral_program')->value('value') == 1)
            <a href="{{ route('user.referral.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('user.referral.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700' }}">
                <span class="material-icons text-[16px] text-orange-500">hub</span>
                Growth
            </a>
        @endif

        <a href="{{ route('user.events.find') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('user.events.find') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700' }}">
            <span class="material-icons text-[16px]">explore</span>
            Events
        </a>

        <a href="{{ route('user.tickets') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('user.tickets') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700' }}">
            <span class="material-icons text-[16px]">confirmation_number</span>
            Tickets
        </a>

        <a href="{{ route('user.transactions') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('user.transactions') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700' }}">
            <span class="material-icons text-[16px]">receipt_long</span>
            Billing
        </a>

        <a href="{{ route('user.settings') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('user.settings') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700' }}">
            <span class="material-icons text-[16px]">settings</span>
            Settings
        </a>

    </div>
</div>

<style>
/* Hide standard scrollbar for a cleaner look, but keep functionality */
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
