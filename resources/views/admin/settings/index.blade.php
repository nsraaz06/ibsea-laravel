@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-primary tracking-tight">Portal Configuration (Settings)</h2>
            <p class="text-slate-500 font-semibold italic">Manage institutional parameters and platform protocols.</p>
        </div>
    </header>

    @if(session('success'))
        <div class="bg-ibsea-green/10 text-ibsea-green p-8 rounded-[2.5rem] mb-10 border border-ibsea-green/20 flex items-center gap-4">
            <div class="w-10 h-10 bg-ibsea-green/20 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-icons">verified</span>
            </div>
            <p class="font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white p-10 md:p-16 rounded-[2.5rem] shadow-premium border-t-8 border-accent relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
        
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-12 relative">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Institutional Identity -->
                <div class="space-y-8">
                    <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-accent"></span> Institutional Identity
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 items-start">
                        <!-- Favicon Upload (1:1) -->
                        <div class="md:col-span-1 space-y-4">
                            <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Favicon (1:1)</label>
                            <div class="relative group">
                                <div class="w-24 h-24 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-accent/40 relative shadow-inner">
                                    <div id="favicon-placeholder" class="text-center p-2 {{ ($settings['favicon'] ?? '') ? 'hidden' : '' }}">
                                        <span class="material-icons text-2xl text-slate-200">add_photo_alternate</span>
                                    </div>
                                    <img id="favicon-preview" src="{{ ($settings['favicon'] ?? '') ? asset($settings['favicon']) : '' }}" class="absolute inset-0 w-full h-full object-contain p-2 {{ ($settings['favicon'] ?? '') ? '' : 'hidden' }}" />
                                </div>
                                <input type="file" name="favicon" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewFavicon(this)">
                            </div>
                        </div>

                        <!-- Site Name -->
                        <div class="md:col-span-3 space-y-4">
                            <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Institutional Name</label>
                            <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'IBSEA' }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all shadow-inner">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest px-1">Global Secretariat Address</label>
                        <textarea name="site_address" rows="3" class="w-full bg-slate-50 border border-slate-100 rounded-[2rem] px-8 py-6 text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all shadow-inner leading-relaxed">{{ $settings['site_address'] ?? '' }}</textarea>
                    </div>
                </div>

                <!-- Contact Intelligence -->
                <div class="space-y-8">
                    <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-accent"></span> Contact Intelligence
                    </h3>

                    <div class="space-y-4">
                        <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Institutional Email</label>
                        <input type="email" name="site_email" value="{{ $settings['site_email'] ?? '' }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all shadow-inner">
                    </div>

                    <div class="space-y-4">
                        <label class="text-[13px] font-black text-slate-800 uppercase tracking-widest px-1">Direct Secretarial Line</label>
                        <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? '' }}" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-8 py-5 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all shadow-inner">
                    </div>
                </div>

                <!-- Social Connectors -->
                <div class="md:col-span-2 space-y-8 pt-6 border-t border-slate-50">
                    <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-accent"></span> Social Connectors
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">LinkedIn Intelligence</label>
                            <input type="url" name="linkedin_url" value="{{ $settings['linkedin_url'] ?? '' }}" placeholder="https://linkedin.com/..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-accent transition-all">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Twitter Broadcast</label>
                            <input type="url" name="twitter_url" value="{{ $settings['twitter_url'] ?? '' }}" placeholder="https://twitter.com/..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-accent transition-all">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Facebook Community</label>
                            <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" placeholder="https://facebook.com/..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-accent transition-all">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Instagram Narrative</label>
                            <input type="url" name="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}" placeholder="https://instagram.com/..." class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-accent transition-all">
                        </div>
                    </div>
                </div>

                <!-- Strategic Feature Control -->
                <div class="md:col-span-2 space-y-8 pt-6 border-t border-slate-50">
                    <h3 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-accent"></span> Strategic Feature Control
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach([
                            'allow_id_card_download' => 'Member ID Card Download',
                            'allow_certificate_download' => 'Membership Certificate Download',
                            'allow_ticket_download' => 'Event Ticket Download',
                            'allow_referral_program' => 'Referral Program Access'
                        ] as $key => $label)
                        <div class="bg-slate-50/50 p-6 rounded-3xl border border-slate-100 flex items-center justify-between group hover:bg-white hover:border-accent/30 hover:shadow-lg transition-all">
                            <div class="space-y-1">
                                <p class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ $label }}</p>
                                <p class="text-[10px] text-slate-500 font-bold italic uppercase tracking-widest">Toggle availability</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="{{ $key }}" value="1" class="sr-only peer" {{ ($settings[$key] ?? '0') == '1' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pt-10 flex justify-end">
                <button type="submit" class="bg-primary text-white px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-premium hover:bg-accent hover:-translate-y-1 active:scale-95 transition-all flex items-center gap-4">
                    Commit Protocol Changes <span class="material-icons text-sm">save_as</span>
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function previewFavicon(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('favicon-preview');
                const placeholder = document.getElementById('favicon-placeholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
