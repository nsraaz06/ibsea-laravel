@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 uppercase tracking-tight">Initiate Mission Initiative</h2>
            <p class="text-slate-500 font-semibold">Schedule and orchestrate a new event for the IBSEA alliance.</p>
        </div>
        <a href="{{ route('admin.events.index') }}" class="bg-slate-100 text-slate-500 px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
            Back to Events Hub
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

    <div class="bg-white p-10 md:p-16 rounded-[2.5rem] shadow-sm border border-slate-100">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            @csrf
            
            <!-- Banner Section -->
            <div class="lg:col-span-1 space-y-8">
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Mission Banner</label>
                    <div class="relative group">
                        <div class="aspect-video bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-primary/50 relative">
                            <img id="banner-preview" class="absolute inset-0 w-full h-full object-cover hidden" />
                            <div id="banner-placeholder" class="text-center p-6">
                                <span class="material-icons text-4xl text-slate-200 mb-2">add_photo_alternate</span>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Upload Banner</p>
                            </div>
                        </div>
                        <input type="file" name="banner_image" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewBanner(this)">
                    </div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center">High resolution JPG or WebP recommended.</p>
                </div>

                <div class="bg-slate-50 p-8 rounded-[2rem] space-y-6">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Engagement Intelligence</h4>
                    
                    <label class="flex items-center justify-between cursor-pointer group">
                        <div>
                            <div class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Feature Initiative</div>
                            <div class="text-[9px] font-bold text-slate-400">Display prominently on home page.</div>
                        </div>
                        <div class="relative inline-flex items-center">
                            <input type="checkbox" name="is_featured" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-primary after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                        </div>
                    </label>

                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Initiative Status</label>
                        <select name="status" class="w-full bg-white border-none rounded-2xl px-6 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary shadow-sm">
                            <option value="Upcoming">Upcoming</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-slate-200">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Document Intelligence</h4>
                        
                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Certificate Design</label>
                            <select name="certificate_template_id" class="w-full bg-white border-none rounded-2xl px-6 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary shadow-sm text-slate-600">
                                <option value="">Default Blade Design</option>
                                @foreach($certificateTemplates as $tmpl)
                                    <option value="{{ $tmpl->id }}">{{ $tmpl->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Ticket Design</label>
                            <select name="ticket_template_id" class="w-full bg-white border-none rounded-2xl px-6 py-3.5 text-sm font-bold focus:ring-2 focus:ring-primary shadow-sm text-slate-600">
                                <option value="">Default Blade Design</option>
                                @foreach($ticketTemplates as $tmpl)
                                    <option value="{{ $tmpl->id }}">{{ $tmpl->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Section -->
            <div class="lg:col-span-2 space-y-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Initiative Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Global Entrepreneurship Summit 2026" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Mission Timeline</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Date</label>
                                <input type="date" name="event_date" value="{{ old('event_date') }}" required class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-base font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Start Time</label>
                                <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-base font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">End Time</label>
                                <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-base font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Location Logistics</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                             <div class="space-y-2 md:col-span-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Venue Name</label>
                                <input type="text" name="venue" value="{{ old('venue') }}" placeholder="e.g. Vigyan Bhawan" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">City</label>
                                <input type="text" name="city" value="{{ old('city') }}" placeholder="e.g. New Delhi" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">State/Country</label>
                                <input type="text" name="state" value="{{ old('state') }}" placeholder="e.g. India" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Digital Assets</label>
                        <input type="url" name="pdf_link" value="{{ old('pdf_link') }}" placeholder="Link to Brochure/PDF (https://...)" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Brief Descriptive Intelligence</label>
                        <textarea name="description" rows="5" placeholder="Detailed objective and agenda of the initiative..." class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="pt-8 flex justify-end">
                    <button type="submit" class="bg-primary text-white px-12 py-5 rounded-3xl font-bold text-xs uppercase tracking-widest shadow-xl shadow-primary/20 hover:bg-primary/90 active:scale-95 transition-all flex items-center gap-3">
                        Orchestrate Initiative <span class="material-icons text-sm">rocket_launch</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewBanner(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('banner-preview').src = e.target.result;
                document.getElementById('banner-preview').classList.remove('hidden');
                document.getElementById('banner-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
