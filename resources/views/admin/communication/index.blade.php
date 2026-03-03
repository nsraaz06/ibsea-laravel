@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Communication Hub</h2>
            <p class="text-slate-500 font-semibold italic">Dispatch targeted notifications and internal alerts.</p>
        </div>
    </header>

    @if(session('success'))
        <div class="mb-10 p-6 bg-green-50 text-green-600 rounded-[2rem] border border-green-100 flex items-center gap-4 font-bold shadow-sm shadow-green-100/50">
            <span class="material-icons">check_circle</span> 
            <div class="text-sm tracking-wide">{{ session('success') }}</div>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
        <!-- Composer -->
        <div class="xl:col-span-2 space-y-8">
            <div class="bg-white rounded-[2.5rem] p-10 shadow-premium border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                
                <h3 class="text-xl font-bold text-slate-800 flex items-center gap-3 mb-8">
                    <span class="w-10 h-10 bg-accent rounded-xl flex items-center justify-center text-white shadow-lg shadow-accent/20">
                        <span class="material-icons text-xl">edit_note</span>
                    </span>
                    Message Composer
                </h3>

                <form action="{{ route('admin.communication.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-widest px-1">Notification Title</label>
                        <input type="text" name="title" required placeholder="e.g., Upcoming Summit Information" 
                            class="w-full bg-slate-50 border border-primary/5 rounded-2xl px-6 py-5 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <label class="text-[11px] font-black text-primary uppercase tracking-widest px-1">Target Audience</label>
                            <select name="target" required class="w-full bg-white border border-primary/20 rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all" style="color: #1e293b !important; background-color: #ffffff !important;">
                                <option value="all" style="color: black !important; background-color: white !important;">Global (All Members)</option>
                                <optgroup label="By Official Role" style="color: black !important; background-color: white !important; font-weight: bold !important;">
                                    @foreach($roles as $role)
                                        <option value="role:{{ $role->id }}" style="color: black !important; background-color: white !important;">{{ $role->role_name }} Only</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="By Membership Tier" style="color: black !important; background-color: white !important; font-weight: bold !important;">
                                    @foreach($plans as $plan)
                                        <option value="plan:{{ $plan->id }}" style="color: black !important; background-color: white !important;">{{ $plan->title }} Members</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="By Regional Chapter" style="color: black !important; background-color: white !important; font-weight: bold !important;">
                                    @foreach($chapters as $chapter)
                                        <option value="chapter:{{ $chapter->id }}" style="color: black !important; background-color: white !important;">{{ $chapter->name }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="By National Council" style="color: black !important; background-color: white !important; font-weight: bold !important;">
                                    @foreach($councils as $council)
                                        <option value="council:{{ $council->id }}" style="color: black !important; background-color: white !important;">{{ $council->name }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="space-y-4">
                            <label class="text-[11px] font-black text-primary uppercase tracking-widest px-1">Message Type</label>
                            <select name="type" class="w-full bg-white border border-primary/20 rounded-2xl px-6 py-4 text-sm font-bold text-slate-800 focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all" style="color: #1e293b !important; background-color: #ffffff !important;">
                                <option value="General" style="color: black !important; background-color: white !important;">General News</option>
                                <option value="Event" style="color: black !important; background-color: white !important;">Event Alert</option>
                                <option value="Renewal" style="color: black !important; background-color: white !important;">Renewal Reminder</option>
                                <option value="Birthday" style="color: black !important; background-color: white !important;">Celebration</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-widest px-1">Delivery Channels</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-primary/5 cursor-pointer hover:border-accent/20 transition-all">
                                <div class="flex items-center gap-3">
                                    <span class="material-icons text-primary">notifications_active</span>
                                    <span class="text-xs font-bold text-slate-800">In-App Notice</span>
                                </div>
                                <input type="checkbox" checked disabled class="rounded text-accent focus:ring-accent w-5 h-5">
                            </label>
                            <label class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-primary/5 cursor-pointer hover:border-accent/20 transition-all">
                                <div class="flex items-center gap-3">
                                    <span class="material-icons text-primary">email</span>
                                    <span class="text-xs font-bold text-slate-800">Direct Email</span>
                                </div>
                                <input type="checkbox" name="send_email" class="rounded text-accent focus:ring-accent w-5 h-5 border-slate-300">
                            </label>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-widest px-1">Content Intelligence</label>
                        <textarea name="message" rows="6" placeholder="Construct your institutional dispatch here..." 
                            class="w-full bg-slate-50 border border-primary/5 rounded-2xl px-6 py-5 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-accent text-white py-6 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-accent/20 hover:bg-primary hover:-translate-y-1 transition-all flex items-center justify-center gap-3 active:scale-95">
                        <span class="material-icons">send</span> Dispatch Intelligence Now
                    </button>
                </form>
            </div>
        </div>

        <!-- History -->
        <div class="space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-premium border border-slate-100">
                <h3 class="text-lg font-black text-primary uppercase tracking-widest mb-6">Recent Dispatches</h3>
                <div class="space-y-6">
                    @forelse($recentNotifications as $msg)
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-accent/30 transition-all">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[9px] font-black text-accent uppercase tracking-widest">{{ $msg->type }}</span>
                            <span class="text-[9px] text-slate-400 font-bold">{{ $msg->created_at->format('d M, H:i') }}</span>
                        </div>
                        <p class="font-bold text-slate-800 text-xs mb-1">{{ $msg->title }}</p>
                        <div class="flex items-center gap-2">
                            <span class="material-icons text-[10px] text-slate-400">group</span>
                            <span class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">{{ $msg->target }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="py-12 text-center text-slate-400">
                        <span class="material-icons text-4xl mb-2 opacity-20">history</span>
                        <p class="text-[10px] font-black uppercase tracking-widest">No dispatch history</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-primary rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-primary/30">
                <div class="absolute -right-20 -top-20 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <span class="material-icons text-accent text-4xl mb-4">tips_and_updates</span>
                    <h4 class="text-lg font-bold mb-2 tracking-tight">Strategy Tip</h4>
                    <p class="text-xs text-blue-100 leading-relaxed font-medium">Use targeted notifications to mobilize specific leadership tiers. Strategic advisors respond best to "Event Alert" types.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
