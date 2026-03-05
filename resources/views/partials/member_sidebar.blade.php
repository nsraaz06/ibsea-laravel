    <!-- Sidebar (Matching Legacy exactly) -->
    <aside class="w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col hidden md:flex sticky top-20 h-[calc(100vh-80px)] overflow-y-auto">
        <div class="p-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-primary/20">I</div>
                <h1 class="text-2xl font-bold tracking-tight text-navy-accent dark:text-white uppercase">IBSEA</h1>
            </a>
        </div>
        
        <nav class="flex-1 px-4 space-y-1 mt-6">
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('user.dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5' }} rounded-xl font-bold text-sm transition-all" href="{{ route('user.dashboard') }}">
                <span class="material-icons text-xl">dashboard</span>
                Dashboard Home
            </a>
            
            @if(!Auth::guard('member')->user()->isRestricted())
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('user.profile') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5' }} rounded-xl font-bold text-sm transition-all" href="{{ route('user.profile') }}">
                <span class="material-icons text-xl">account_circle</span>
                Professional Portfolio
            </a>
            @endif

            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5 rounded-xl font-bold text-sm transition-all" href="{{ route('user.notifications.index') }}">
                <div class="relative">
                    <span class="material-icons text-xl">notifications</span>
                    @php $unread = \App\Models\Notification::where('user_id', Auth::guard('member')->id())->where('is_read', false)->count(); @endphp
                    @if($unread > 0)
                        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                    @endif
                </div>
                Notifications
            </a>
            
            @if(!Auth::guard('member')->user()->isRestricted() && (\App\Models\SiteSetting::where('key', 'allow_certificate_download')->value('value') == 1 || \App\Models\SiteSetting::where('key', 'allow_id_card_download')->value('value') == 1))
            <div class="px-4 py-2 mt-2">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2">My Assets</p>
                @if(\App\Models\SiteSetting::where('key', 'allow_certificate_download')->value('value') == 1)
                <a class="flex items-center gap-3 px-4 py-2 text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-primary/5 rounded-xl font-bold text-xs transition-all mb-1" href="{{ route('user.assets.preview', ['type' => 'certificate']) }}">
                    <span class="material-icons text-sm">workspace_premium</span>
                    Certificate
                </a>
                @endif
                @if(\App\Models\SiteSetting::where('key', 'allow_id_card_download')->value('value') == 1)
                <a class="flex items-center gap-3 px-4 py-2 text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-primary/5 rounded-xl font-bold text-xs transition-all" href="{{ route('user.assets.preview', ['type' => 'id_card']) }}">
                    <span class="material-icons text-sm">badge</span>
                    ID Card
                </a>
                @endif
            </div>
            @endif

            <!-- Referral Hub Link (Phase 39) -->
            @if(!Auth::guard('member')->user()->isRestricted() && \App\Models\SiteSetting::where('key', 'allow_referral_program')->value('value') == 1)
            <div class="px-4 py-2 mt-2">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2">Growth</p>
                <a class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('user.referral.*') ? 'text-primary bg-primary/5' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-primary/5' }} rounded-xl font-bold text-xs transition-all mb-1" href="{{ route('user.referral.index') }}">
                    <span class="material-icons text-sm">hub</span>
                    Referral Hub
                </a>
            </div>
            @endif

            <!-- Learning CMS Link (New) -->
            @if(\App\Models\SiteSetting::where('key', 'allow_course_cms')->value('value') == 1)
            <div class="px-4 py-2 mt-2">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2">Education</p>
                <a class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('user.courses.*') ? 'text-primary bg-primary/5' : 'text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-primary/5' }} rounded-xl font-bold text-xs transition-all mb-1" href="{{ route('user.courses.index') }}">
                    <span class="material-icons text-sm">school</span>
                    Learning Hub
                </a>
            </div>
            @endif

            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('user.events.find') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5' }} rounded-xl font-bold text-sm transition-all" href="{{ route('user.events.find') }}">
                <span class="material-icons text-xl">explore</span>
                Browse Events
            </a>

            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('user.tickets') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5' }} rounded-xl font-bold text-sm transition-all" href="{{ route('user.tickets') }}">
                <span class="material-icons text-xl">confirmation_number</span>
                My Tickets
            </a>

            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('user.transactions') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5' }} rounded-xl font-bold text-sm transition-all" href="{{ route('user.transactions') }}">
                <span class="material-icons text-xl">receipt_long</span>
                Transaction History
            </a>

            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('user.settings') ? 'bg-primary/10 text-primary' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5' }} rounded-xl font-bold text-sm transition-all" href="{{ route('user.settings') }}">
                <span class="material-icons text-xl">settings</span>
                Account Settings
            </a>

            <form action="{{ route('member.logout') }}" method="POST" class="mt-auto p-4">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-xl font-bold text-sm transition-all">
                    <span class="material-icons text-xl">logout</span>
                    Sign Out
                </button>
            </form>
        </nav>
    </aside>
