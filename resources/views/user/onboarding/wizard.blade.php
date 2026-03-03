@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-slate-50 dark:bg-slate-950">
    @include('partials.member_sidebar')

    <main class="flex-1 overflow-y-auto p-4 md:p-12">
        <div class="max-w-4xl mx-auto py-12 px-4">
            <!-- Progress Stepper -->
            <div class="mb-12 relative">
                <div class="flex justify-between items-center relative z-10">
                    @foreach(['Identity', 'Professional', 'Digital', 'Contact'] as $index => $step)
                        <div class="flex flex-col items-center step-item" data-step="{{ $index + 1 }}">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-lg transition-all duration-500 {{ $index == 0 ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'bg-white dark:bg-slate-900 text-slate-400 border border-slate-100 dark:border-slate-800' }}">
                                {{ $index + 1 }}
                            </div>
                            <span class="mt-3 text-[10px] font-black uppercase tracking-widest {{ $index == 0 ? 'text-primary' : 'text-slate-400' }}">{{ $step }}</span>
                        </div>
                    @endforeach
                </div>
                <!-- Progress Line -->
                <div class="absolute top-6 left-0 w-full h-0.5 bg-slate-200 dark:bg-slate-800 -z-0">
                    <div id="progress-line" class="h-full bg-primary transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Wizard Card -->
            <div class="bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl overflow-hidden border border-slate-100 dark:border-slate-800">
                <form id="onboardingForm" action="{{ route('user.onboarding.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Step 1: Identity -->
                    <div class="wizard-step p-10 md:p-16 space-y-10" id="step-1">
                        <div class="text-center space-y-4">
                            <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
                                <span class="material-icons text-xs">face</span>
                                Phase 01: Your Identity
                            </div>
                            <h2 class="text-4xl font-black text-slate-800 dark:text-white uppercase">Who are you?</h2>
                            <p class="text-slate-500 font-medium">Your profile image and basic details establish institutional trust.</p>
                        </div>

                        <div class="flex flex-col items-center gap-8">
                            <div class="relative group">
                                <div class="w-40 h-40 rounded-[3rem] bg-slate-100 dark:bg-slate-800 border-4 border-white dark:border-slate-900 overflow-hidden shadow-2xl group-hover:scale-95 transition-transform duration-500">
                                    @if($user->profile_image)
                                        <img src="{{ asset($user->profile_image) }}" id="preview" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300" id="placeholder">
                                            <span class="material-icons text-6xl">add_a_photo</span>
                                        </div>
                                        <img src="" id="preview" class="w-full h-full object-cover hidden">
                                    @endif
                                </div>
                                <label class="absolute -bottom-4 left-1/2 -translate-x-1/2 cursor-pointer bg-primary text-white p-3 rounded-2xl shadow-xl hover:bg-orange-600 transition-all active:scale-90">
                                    <span class="material-icons text-xl">camera_alt</span>
                                    <input type="file" name="profile_image" class="hidden" onchange="previewAvatar(this)">
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-2xl pt-10">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Date of Birth</label>
                                    <input type="date" name="dob" value="{{ $user->dob }}" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-primary/10">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Regional Chapter</label>
                                    <select name="chapter_id" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-primary/10 text-black dark:text-white" style="color: black !important; background-color: white !important;">
                                        <option value="" class="text-slate-900 border-none outline-none">Select Region</option>
                                        @foreach($chapters as $chapter)
                                            <option value="{{ $chapter->id }}" {{ $user->chapter_id == $chapter->id ? 'selected' : '' }} class="text-slate-900 border-none outline-none">
                                                {{ $chapter->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Professional Brand -->
                    <div class="wizard-step p-10 md:p-16 space-y-10 hidden" id="step-2">
                        <div class="text-center space-y-4">
                            <div class="inline-flex items-center gap-2 bg-blue-500/10 text-blue-500 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
                                <span class="material-icons text-xs">business_center</span>
                                Phase 02: Strategic Brand
                            </div>
                            <h2 class="text-4xl font-black text-slate-800 dark:text-white uppercase">Your Mission</h2>
                            <p class="text-slate-500 font-medium">Define your professional headline and background.</p>
                        </div>

                        <div class="max-w-2xl mx-auto space-y-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Professional Headline</label>
                                <input type="text" name="short_description" value="{{ $user->short_description }}" placeholder="e.g. Strategic Advisor & Global Investor" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-blue-500/10">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Industry</label>
                                    <input type="text" name="industry" value="{{ $user->industry }}" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-blue-500/10">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Profession</label>
                                    <input type="text" name="profession" value="{{ $user->profession }}" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-blue-500/10">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Dossier / Bio</label>
                                <textarea name="bio" rows="4" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-blue-500/10">{{ $user->bio ?? $user->full_description }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Digital Footprint -->
                    <div class="wizard-step p-10 md:p-16 space-y-10 hidden" id="step-3">
                        <div class="text-center space-y-4">
                            <div class="inline-flex items-center gap-2 bg-purple-500/10 text-purple-500 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
                                <span class="material-icons text-xs">public</span>
                                Phase 03: Digital Footprint
                            </div>
                            <h2 class="text-4xl font-black text-slate-800 dark:text-white uppercase">Connections</h2>
                            <p class="text-slate-500 font-medium">Link your professional networks and list your victories.</p>
                        </div>

                        <div class="max-w-2xl mx-auto space-y-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">LinkedIn Profile</label>
                                <input type="url" name="linkedin_url" value="{{ $user->linkedin_url }}" placeholder="https://linkedin.com/in/..." class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-purple-500/10">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Official Website</label>
                                <input type="url" name="website_url" value="{{ $user->website_url }}" placeholder="https://..." class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-purple-500/10">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Key Achievements</label>
                                <textarea name="achievements" rows="4" placeholder="List your key milestones..." class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-purple-500/10">{{ $user->achievements }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Contact & Location -->
                    <div class="wizard-step p-10 md:p-16 space-y-10 hidden" id="step-4">
                        <div class="text-center space-y-4">
                            <div class="inline-flex items-center gap-2 bg-green-500/10 text-green-500 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
                                <span class="material-icons text-xs">location_on</span>
                                Phase 04: Geography
                            </div>
                            <h2 class="text-4xl font-black text-slate-800 dark:text-white uppercase">Location</h2>
                            <p class="text-slate-500 font-medium">Where in the world are you operating from?</p>
                        </div>

                        <div class="max-w-2xl mx-auto space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">City</label>
                                    <input type="text" name="city" value="{{ $user->city }}" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-green-500/10">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">State / Country</label>
                                    <input type="text" name="state_country" value="{{ $user->state_country }}" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-green-500/10">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Official Address</label>
                                <textarea name="address_line" rows="3" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl px-6 py-5 font-bold text-slate-700 dark:text-white outline-none focus:ring-4 focus:ring-green-500/10">{{ $user->address_line ?? $user->address }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Navigation -->
                    <div class="p-10 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
                        <button type="button" id="prevBtn" class="invisible px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-800 dark:hover:text-white transition-all">
                            Previous Phase
                        </button>
                        <div class="flex gap-4">
                            <a href="{{ route('user.dashboard') }}" class="px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-800 dark:hover:text-white transition-all">
                                Skip for later
                            </a>
                            <button type="button" id="nextBtn" class="bg-primary text-white px-12 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                                <span>Next Phase</span>
                                <span class="material-icons text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 4;
    const form = document.getElementById('onboardingForm');
    
    function updateWizard() {
        // Hide all steps
        document.querySelectorAll('.wizard-step').forEach(step => step.classList.add('hidden'));
        // Show current step
        document.getElementById(`step-${currentStep}`).classList.remove('hidden');
        
        // Update Steps UI
        document.querySelectorAll('.step-item').forEach((item, index) => {
            const stepNum = index + 1;
            const circle = item.querySelector('div');
            const label = item.querySelector('span');
            
            if (stepNum < currentStep) {
                circle.classList.remove('bg-white', 'dark:bg-slate-900', 'text-slate-400', 'border', 'bg-primary');
                circle.classList.add('bg-green-500', 'text-white', 'shadow-green-500/20');
                circle.innerHTML = '<span class="material-icons">check</span>';
                label.classList.remove('text-primary', 'text-slate-400');
                label.classList.add('text-green-500');
            } else if (stepNum === currentStep) {
                circle.classList.remove('bg-white', 'dark:bg-slate-900', 'text-slate-400', 'border', 'bg-green-500');
                circle.classList.add('bg-primary', 'text-white', 'shadow-primary/20');
                circle.innerHTML = stepNum;
                label.classList.remove('text-green-500', 'text-slate-400');
                label.classList.add('text-primary');
            } else {
                circle.classList.remove('bg-primary', 'bg-green-500', 'text-white');
                circle.classList.add('bg-white', 'dark:bg-slate-900', 'text-slate-400', 'border');
                circle.innerHTML = stepNum;
                label.classList.remove('text-primary', 'text-green-500');
                label.classList.add('text-slate-400');
            }
        });
        
        // Update Progress Line
        document.getElementById('progress-line').style.width = ((currentStep - 1) / (totalSteps - 1) * 100) + '%';
        
        // Update Buttons
        document.getElementById('prevBtn').classList.toggle('invisible', currentStep === 1);
        
        const nextBtnSpan = document.querySelector('#nextBtn span:first-child');
        if (currentStep === totalSteps) {
            nextBtnSpan.innerText = 'Finalize Dossier';
        } else {
            nextBtnSpan.innerText = 'Next Phase';
        }
    }

    document.getElementById('nextBtn').addEventListener('click', async () => {
        const formData = new FormData(form);
        formData.append('step', currentStep === totalSteps ? 'final' : currentStep);
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.redirected) {
                window.location.href = response.url;
                return;
            }

            const result = await response.json();
            if (result.success) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateWizard();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        } catch (error) {
            console.error('Update failed:', error);
        }
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            updateWizard();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                const placeholder = document.getElementById('placeholder');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    updateWizard();
</script>
@endsection
