@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 uppercase tracking-tight">Onboard New Member</h2>
            <p class="text-slate-500 font-semibold">Manually register a new mission partner into the IBSEA ecosystem.</p>
        </div>
        <a href="{{ route('admin.members.index') }}" class="bg-slate-100 text-slate-500 px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
            Back to Directory
        </a>
    </header>

    @if ($errors->any())
        <div class="bg-red-50 text-red-600 p-6 rounded-3xl mb-8 border border-red-100">
            <h3 class="font-black uppercase text-xs tracking-widest mb-2 flex items-center gap-2">
                <span class="material-icons text-sm">error</span> Validation Failed
            </h3>
            <ul class="list-disc pl-5 text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf

        <!-- Profile & Status Section -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 text-center">
                <div class="relative w-40 h-40 mx-auto mb-8">
                    <img id="profile-preview" src="https://ui-avatars.com/api/?name=New+Member&size=200&background=f8fafc&color=0f172a&bold=true" class="w-full h-full rounded-full object-cover border-4 border-slate-50 shadow-xl" />
                    <label for="profile_image" class="absolute bottom-1 right-1 bg-slate-900 text-white p-3 rounded-full cursor-pointer hover:scale-110 active:scale-95 transition-all shadow-lg hover:bg-black">
                        <span class="material-icons text-sm">photo_camera</span>
                        <input type="file" name="profile_image" id="profile_image" class="hidden" onchange="previewImage(this)">
                    </label>
                </div>
                <h3 class="text-lg font-bold text-slate-900 uppercase tracking-tight">Initial Profile</h3>
                <p class="text-slate-500 font-semibold text-[10px] uppercase tracking-widest px-6">Upload identity photograph for official records.</p>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-6">Initial Mission Status</h3>
                <div class="space-y-3">
                    @foreach(['Pending', 'Vetted', 'Active', 'Suspended'] as $status)
                        <label class="flex items-center gap-4 p-4 rounded-2xl border-2 {{ (old('status', 'Pending') == $status) ? 'border-accent bg-orange-50/30' : 'border-slate-100 bg-white hover:border-slate-200' }} cursor-pointer transition-all group">
                            <input type="radio" name="status" value="{{ $status }}" {{ (old('status', 'Pending') == $status) ? 'checked' : '' }} class="hidden">
                            <div class="w-5 h-5 rounded-full border-2 {{ (old('status', 'Pending') == $status) ? 'border-accent flex items-center justify-center' : 'border-slate-300 group-hover:border-slate-400' }}">
                                @if(old('status', 'Pending') == $status) <div class="w-2.5 h-2.5 bg-accent rounded-full"></div> @endif
                            </div>
                            <span class="text-xs font-bold uppercase tracking-widest {{ (old('status', 'Pending') == $status) ? 'text-slate-900' : 'text-slate-500 group-hover:text-slate-700' }}">{{ $status }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Form Fields -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-10 md:p-16 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Narendra Modi" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="e.g. contact@domain.com" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Institutional Role</label>
                        <select name="role" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            @foreach(['Member', 'Mentor', 'Investor', 'Advisor', 'Strategic Advisor'] as $role)
                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Membership Plan</label>
                        <select name="membership_plan_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            <option value="">No Plan Allocated</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ old('membership_plan_id') == $plan->id ? 'selected' : '' }}>{{ $plan->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Institutional Chapter</label>
                        <select name="chapter_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            <option value="">Global Core</option>
                            @foreach($chapters as $chapter)
                                <option value="{{ $chapter->id }}" {{ old('chapter_id') == $chapter->id ? 'selected' : '' }}>{{ $chapter->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Strategic Council</label>
                        <select name="council_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            <option value="">None Assigned</option>
                            @foreach($councils as $council)
                                <option value="{{ $council->id }}" {{ old('council_id') == $council->id ? 'selected' : '' }}>{{ $council->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Mobile Number</label>
                        <input type="text" name="mobile" value="{{ old('mobile') }}" placeholder="+91 0000 000000" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Secure Access Key (Password)</label>
                        <div class="relative">
                            <input type="password" name="password" required placeholder="••••••••" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-2 px-1">Minimum 8 characters required for mission security.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-12 py-5 rounded-3xl font-bold text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:bg-primary/90 active:scale-95 transition-all flex items-center gap-3">
                        Onboard Partner <span class="material-icons text-sm">east</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
