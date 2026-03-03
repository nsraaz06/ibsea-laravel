@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 uppercase tracking-tight">Edit Member Identity</h2>
            <p class="text-slate-500 font-semibold">Update the institutional and personal details of <span class="capitalize">{{ $member->name }}</span>.</p>
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

    <form action="{{ route('admin.members.update', $member) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PUT')

        <!-- Profile Section -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 text-center">
                <div class="relative w-40 h-40 mx-auto mb-8">
                    <img id="profile-preview" src="{{ $member->profile_image ? (Str::startsWith($member->profile_image, 'uploads/') ? asset($member->profile_image) : asset('storage/' . $member->profile_image)) : 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&size=200&background=f1f5f9&color=0f172a&bold=true' }}" class="w-full h-full rounded-full object-cover border-4 border-slate-50 shadow-xl" />
                    <label for="profile_image" class="absolute bottom-1 right-1 bg-slate-900 text-white p-3 rounded-full cursor-pointer hover:scale-110 active:scale-95 transition-all shadow-lg hover:bg-black">
                        <span class="material-icons text-sm">photo_camera</span>
                        <input type="file" name="profile_image" id="profile_image" class="hidden" onchange="previewImage(this)">
                    </label>
                </div>
                <h3 class="text-lg font-bold text-slate-900 capitalize tracking-tight">{{ $member->name }}</h3>
                <p class="text-slate-500 font-semibold text-[10px] uppercase tracking-widest">{{ $member->email }}</p>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-6">Mission Status</h3>
                <div class="space-y-3">
                    @foreach(['Pending', 'Vetted', 'Active', 'Suspended'] as $status)
                        <label class="flex items-center gap-4 p-4 rounded-2xl border-2 {{ $member->status == $status ? 'border-accent bg-orange-50/30' : 'border-slate-100 bg-white hover:border-slate-200' }} cursor-pointer transition-all group">
                            <input type="radio" name="status" value="{{ $status }}" {{ $member->status == $status ? 'checked' : '' }} class="hidden" onchange="updateStatusUI(this)">
                            <div class="w-5 h-5 rounded-full border-2 {{ $member->status == $status ? 'border-accent flex items-center justify-center' : 'border-slate-300 group-hover:border-slate-400' }}">
                                @if($member->status == $status) <div class="w-2.5 h-2.5 bg-accent rounded-full"></div> @endif
                            </div>
                            <span class="text-xs font-bold uppercase tracking-widest {{ $member->status == $status ? 'text-slate-900' : 'text-slate-500 group-hover:text-slate-700' }}">{{ $status }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Form Fields -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-10 md:p-16 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="space-y-8">
                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight border-b border-slate-100 pb-4">Personal Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $member->email) }}" required class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Leadership Email (Professional)</label>
                            <input type="email" name="leadership_email" value="{{ old('leadership_email', $member->leadership_email) }}" placeholder="e.g. president.state@ibseanational.org" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary transition-all font-mono">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 px-1">This email will reflect in the Leadership Hub dashboard.</p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Mobile Number</label>
                            <input type="text" name="mobile" value="{{ old('mobile', $member->mobile) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">WhatsApp Number</label>
                            <input type="text" name="whatsapp_no" value="{{ old('whatsapp_no', $member->whatsapp_no) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob', $member->dob) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>
                    </div>

                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight border-b border-slate-100 pb-4 pt-4">Professional Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Business Name</label>
                            <input type="text" name="business_name" value="{{ old('business_name', $member->business_name) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Industry</label>
                            <input type="text" name="industry" value="{{ old('industry', $member->industry) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Profession</label>
                            <input type="text" name="profession" value="{{ old('profession', $member->profession) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Business Category</label>
                            <input type="text" name="business_category" value="{{ old('business_category', $member->business_category) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Website URL</label>
                            <input type="url" name="website_url" value="{{ old('website_url', $member->website_url) }}" placeholder="https://" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">LinkedIn URL</label>
                            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $member->linkedin_url) }}" placeholder="https://linkedin.com/in/..." class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>
                    </div>

                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight border-b border-slate-100 pb-4 pt-4">Institutional Role</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest px-1">Institutional Role (System)</label>
                            <select name="role_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary transition-all">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $member->role_id) == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                        </div>

                         <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest px-1">Role Title (Display)</label>
                            <input type="text" name="role" value="{{ old('role', $member->role) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-700 uppercase tracking-widest px-1">Membership Plan</label>
                            <select name="membership_plan_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary transition-all">
                                <option value="">No Plan Allocated</option>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" {{ old('membership_plan_id', $member->membership_plan_id) == $plan->id ? 'selected' : '' }}>{{ $plan->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Institutional Chapter</label>
                            <select name="chapter_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                                <option value="">Global Core</option>
                                @foreach($chapters as $chapter)
                                    <option value="{{ $chapter->id }}" {{ old('chapter_id', $member->chapter_id) == $chapter->id ? 'selected' : '' }}>{{ $chapter->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Strategic Council</label>
                            <select name="council_id" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                                <option value="">None Assigned</option>
                                @foreach($councils as $council)
                                    <option value="{{ $council->id }}" {{ old('council_id', $member->council_id) == $council->id ? 'selected' : '' }}>{{ $council->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                         <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Alliance Name</label>
                            <input type="text" name="alliance_name" value="{{ old('alliance_name', $member->alliance_name) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>
                    </div>

                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight border-b border-slate-100 pb-4 pt-4">Location & Address</h4>
                    <div class="grid grid-cols-1 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Address Line</label>
                            <input type="text" name="address_line" value="{{ old('address_line', $member->address_line) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">City</label>
                                <input type="text" name="city" value="{{ old('city', $member->city) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">State / Country</label>
                                <input type="text" name="state_country" value="{{ old('state_country', $member->state_country) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Pincode</label>
                                <input type="text" name="pincode" value="{{ old('pincode', $member->pincode) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                        </div>
                    </div>

                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight border-b border-slate-100 pb-4 pt-4">Membership Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                         <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Membership Start Date</label>
                            <input type="date" name="membership_start" value="{{ old('membership_start', $member->membership_start) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>
                         <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Membership Expiry Date</label>
                            <input type="date" name="membership_end" value="{{ old('membership_end', $member->membership_end) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>
                    </div>

                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight border-b border-slate-100 pb-4 pt-4">Biography & Description</h4>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Short Description (One Liner)</label>
                        <input type="text" name="short_description" value="{{ old('short_description', $member->short_description) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Bio / Mission Statement</label>
                        <textarea name="bio" rows="4" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">{{ old('bio', $member->bio) }}</textarea>
                    </div>

                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight border-b border-slate-100 pb-4 pt-4">Security</h4>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Access Key (Leave blank to keep same)</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                    </div>
                </div>

                <div class="mt-12 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-12 py-5 rounded-3xl font-bold text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:bg-primary/90 active:scale-95 transition-all">
                        Update Mission Profile
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

    function updateStatusUI(radio) {
        // Reset all labels
        const labels = radio.closest('.space-y-3').querySelectorAll('label');
        labels.forEach(label => {
            // Reset Container
            label.className = 'flex items-center gap-4 p-4 rounded-2xl border-2 border-slate-100 bg-white hover:border-slate-200 cursor-pointer transition-all group';
            
            // Reset Circle
            const circle = label.querySelector('div');
            circle.className = 'w-5 h-5 rounded-full border-2 border-slate-300 group-hover:border-slate-400';
            circle.innerHTML = ''; // Remove dot

            // Reset Text
            const text = label.querySelector('span');
            text.className = 'text-xs font-bold uppercase tracking-widest text-slate-500 group-hover:text-slate-700';
        });

        // Activate Selected
        const activeLabel = radio.closest('label');
        activeLabel.className = 'flex items-center gap-4 p-4 rounded-2xl border-2 border-accent bg-orange-50/30 cursor-pointer transition-all group';

        const activeCircle = activeLabel.querySelector('div');
        activeCircle.className = 'w-5 h-5 rounded-full border-2 border-accent flex items-center justify-center';
        activeCircle.innerHTML = '<div class="w-2.5 h-2.5 bg-accent rounded-full"></div>';

        const activeText = activeLabel.querySelector('span');
        activeText.className = 'text-xs font-bold uppercase tracking-widest text-slate-900';
    }
</script>
@endsection
