@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Mission Partner Details</h2>
            <p class="text-slate-500 font-medium">Comprehensive profile of <span class="capitalize">{{ $member->name }}</span>.</p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.members.edit', $member) }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-primary/20 active:scale-95 transition-all flex items-center gap-2">
                <span class="material-icons text-sm">edit</span>
                Modify Profile
            </a>
            <a href="{{ route('admin.members.index') }}" class="bg-slate-100 text-slate-500 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                Directory
            </a>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Identity Card -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-24 bg-slate-900"></div>
                <div class="relative z-10 pt-4">
                    <div class="w-40 h-40 mx-auto mb-8 relative">
                        <img src="{{ $member->profile_image ? (Str::startsWith($member->profile_image, 'uploads/') ? asset($member->profile_image) : asset('storage/' . $member->profile_image)) : 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&size=200&background=f1f5f9&color=0f172a&bold=true' }}" class="w-full h-full rounded-full object-cover border-4 border-white shadow-2xl" />
                        <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></div>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 capitalize tracking-tight">{{ $member->name }}</h3>
                    <p class="text-primary font-black text-[10px] uppercase tracking-[0.2em] mt-1">{{ $member->memberRole->role_name ?? $member->role }}</p>
                    <div class="mt-6 inline-flex px-4 py-1.5 rounded-full {{ $member->status == 'Active' ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-600' }} text-[9px] font-black uppercase tracking-widest">
                        Mission Status: {{ $member->status }}
                    </div>
                </div>
                
                <div class="mt-10 pt-10 border-t border-slate-50 grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Institutional ID</div>
                        <div class="text-[10px] font-black text-primary uppercase tracking-widest">{{ $member->membership_id }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Joined</div>
                        <div class="text-sm font-black text-slate-700">{{ $member->created_at->format('M Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Institutional Affiliation -->
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8 border-b border-slate-50 pb-4 flex items-center gap-2">
                    <span class="material-icons text-sm text-primary">lan</span>
                    Strategic Affiliation
                </h3>
                <div class="space-y-6">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Regional Chapter</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-primary">
                                <span class="material-icons text-sm">map</span>
                            </div>
                            <span class="text-sm font-black text-slate-700 uppercase tracking-tight">{{ $member->chapter->name ?? 'Global Alliance (Core)' }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Operational Council</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-primary">
                                <span class="material-icons text-sm">groups_3</span>
                            </div>
                            <span class="text-sm font-black text-slate-700 uppercase tracking-tight">{{ $member->council->name ?? 'None Assigned' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content: Details & Activity -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-10 md:p-16 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight mb-10 flex items-center gap-4">
                    Personal Intelligence
                    <div class="h-1 flex-1 bg-slate-50 rounded-full"></div>
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-10 gap-x-12">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Official Email</p>
                        <div class="flex items-center gap-3 group">
                            <span class="material-icons text-slate-200 text-lg group-hover:text-primary transition-colors">alternate_email</span>
                            <span class="text-sm font-bold text-slate-700">{{ $member->email }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Encrypted Contact</p>
                        <div class="flex items-center gap-3 group">
                            <span class="material-icons text-slate-200 text-lg group-hover:text-primary transition-colors">call</span>
                            <span class="text-sm font-bold text-slate-700">{{ $member->mobile ?? 'Not Disclosed' }}</span>
                        </div>
                    </div>
                    @if($member->whatsapp_no)
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">WhatsApp Contact</p>
                        <div class="flex items-center gap-3 group">
                            <span class="material-icons text-slate-200 text-lg group-hover:text-green-500 transition-colors">chat</span>
                            <span class="text-sm font-bold text-slate-700">{{ $member->whatsapp_no }}</span>
                        </div>
                    </div>
                    @endif
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">My Date of Birth</p>
                         <div class="flex items-center gap-3 group">
                            <span class="material-icons text-slate-200 text-lg group-hover:text-primary transition-colors">cake</span>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">{{ $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d M, Y') : 'Not Provided' }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Professional Title</p>
                        <div class="flex items-center gap-3 group">
                            <span class="material-icons text-slate-200 text-lg group-hover:text-primary transition-colors">badge</span>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">{{ $member->designation ?? 'Mission Partner' }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Security Clearance</p>
                        <div class="flex items-center gap-3 group">
                            <span class="material-icons text-slate-200 text-lg group-hover:text-primary transition-colors">shield</span>
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-tight">{{ $member->status == 'Active' ? 'Level 4 (Full Access)' : 'Level 2 (Guest)' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-12 border-t border-slate-50">
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight mb-10 flex items-center gap-4">
                        Professional Profile
                        <div class="h-1 flex-1 bg-slate-50 rounded-full"></div>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-10 gap-x-12">
                         @if($member->business_name)
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Business Name</p>
                            <div class="flex items-center gap-3">
                                <span class="material-icons text-slate-200 text-lg">business</span>
                                <span class="text-sm font-bold text-slate-700">{{ $member->business_name }}</span>
                            </div>
                        </div>
                        @endif
                        @if($member->industry)
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Industry</p>
                            <div class="flex items-center gap-3">
                                <span class="material-icons text-slate-200 text-lg">factory</span>
                                <span class="text-sm font-bold text-slate-700">{{ $member->industry }}</span>
                            </div>
                        </div>
                        @endif
                         @if($member->profession)
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Profession</p>
                            <div class="flex items-center gap-3">
                                <span class="material-icons text-slate-200 text-lg">work</span>
                                <span class="text-sm font-bold text-slate-700">{{ $member->profession }}</span>
                            </div>
                        </div>
                        @endif
                        @if($member->business_category)
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Category</p>
                            <div class="flex items-center gap-3">
                                <span class="material-icons text-slate-200 text-lg">category</span>
                                <span class="text-sm font-bold text-slate-700">{{ $member->business_category }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="mt-12 pt-12 border-t border-slate-50">
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight mb-10 flex items-center gap-4">
                        Digital Presence
                        <div class="h-1 flex-1 bg-slate-50 rounded-full"></div>
                    </h3>
                    <div class="flex flex-wrap gap-4">
                        @if($member->website_url)
                        <a href="{{ $member->website_url }}" target="_blank" class="flex items-center gap-3 px-6 py-4 bg-slate-50 rounded-2xl hover:bg-slate-100 transition-colors">
                            <span class="material-icons text-slate-400">language</span>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Website</p>
                                <p class="text-xs font-bold text-primary truncate max-w-[150px]">{{ $member->website_url }}</p>
                            </div>
                        </a>
                        @endif
                        @if($member->linkedin_url)
                        <a href="{{ $member->linkedin_url }}" target="_blank" class="flex items-center gap-3 px-6 py-4 bg-blue-50 rounded-2xl hover:bg-blue-100 transition-colors">
                            <span class="material-icons text-blue-400">link</span>
                            <div>
                                <p class="text-[9px] font-black text-blue-300 uppercase tracking-widest">LinkedIn</p>
                                <p class="text-xs font-bold text-blue-700 truncate max-w-[150px]">View Profile</p>
                            </div>
                        </a>
                        @endif
                         @if(!$member->website_url && !$member->linkedin_url)
                            <p class="text-slate-400 text-sm italic">No digital footprints recorded.</p>
                        @endif
                    </div>
                </div>
                
                 <div class="mt-12 pt-12 border-t border-slate-50">
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight mb-10 flex items-center gap-4">
                        Location Data
                        <div class="h-1 flex-1 bg-slate-50 rounded-full"></div>
                    </h3>
                    @if($member->address_line || $member->city || $member->state_country)
                    <div class="flex items-start gap-4 p-6 bg-slate-50 rounded-3xl">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 shadow-sm shrink-0">
                            <span class="material-icons">place</span>
                        </div>
                        <div>
                             <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Registered Address</p>
                             <p class="text-sm font-bold text-slate-700 leading-relaxed">
                                 {{ $member->address_line }}<br>
                                 {{ $member->city ? $member->city . ',' : '' }} {{ $member->state_country }} {{ $member->pincode }}
                             </p>
                        </div>
                    </div>
                    @else
                        <p class="text-slate-400 text-sm italic">Location data not available.</p>
                    @endif
                </div>


                @if($member->short_description)
                <div class="mt-12 pt-12 border-t border-slate-50">
                     <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 uppercase">Short Bio</p>
                     <p class="text-slate-700 font-bold text-lg">{{ $member->short_description }}</p>
                </div>
                @endif

                @if($member->bio)
                <div class="mt-12 pt-12 border-t border-slate-50">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 uppercase">Mission Statement / Full Bio</p>
                    <div class="text-slate-500 font-medium leading-relaxed italic border-l-4 border-slate-50 pl-6">
                        "{{ $member->bio }}"
                    </div>
                </div>
                @endif
            </div>

            <!-- Financial Activity / Membership -->
            <div class="bg-white p-10 md:p-16 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight mb-10 flex items-center gap-4">
                    Membership Ledger
                    <div class="h-1 flex-1 bg-slate-50 rounded-full"></div>
                </h3>
                 <div class="grid grid-cols-2 gap-8 mb-8">
                    <div class="p-6 bg-slate-50 rounded-3xl text-center">
                         <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Member Since</p>
                         <p class="text-lg font-black text-slate-800">{{ $member->membership_start ? \Carbon\Carbon::parse($member->membership_start)->format('d M Y') : 'N/A' }}</p>
                    </div>
                     <div class="p-6 bg-slate-50 rounded-3xl text-center">
                         <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Valid Until</p>
                         <p class="text-lg font-black text-slate-800">{{ $member->membership_end ? \Carbon\Carbon::parse($member->membership_end)->format('d M Y') : 'Lifetime' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
