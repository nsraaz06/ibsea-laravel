@extends('layouts.admin')

@section('content')
<div class="p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-bold text-accent tracking-tight">Refine Mission Initiative</h2>
            <p class="text-slate-500 font-semibold">Update the details of {{ $event->name }}.</p>
        </div>
        <a href="{{ route('admin.events.index') }}" class="bg-slate-100 text-slate-500 px-8 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-accent hover:text-white transition-all shadow-sm">
            Back to Events Hub
        </a>
    </header>

    @if ($errors->any())
        <div class="bg-red-50/50 backdrop-blur-sm text-red-600 p-8 rounded-[2rem] mb-10 border border-red-100 flex items-start gap-4">
            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-icons">report_problem</span>
            </div>
            <div>
                <h3 class="font-black uppercase text-xs tracking-widest mb-2">Attention Required</h3>
                <ul class="list-disc pl-5 text-sm font-semibold opacity-80">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white p-10 md:p-16 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border-t-8 border-primary relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            @csrf
            @method('PUT')
            
            <!-- Banner & Key Meta Section -->
            <div class="lg:col-span-1 space-y-8">
                <div class="space-y-4">
                    <label class="text-md font-black text-primary tracking-widest px-1">Mission Banner</label>
                    <div class="relative group">
                        <div class="aspect-video bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-primary/50 relative">
                            <img id="banner-preview" src="{{ $event->featured_image ? (str_starts_with($event->featured_image, 'uploads/') ? asset($event->featured_image) : asset('storage/' . $event->featured_image)) : '' }}" class="absolute inset-0 w-full h-full object-cover {{ $event->featured_image ? '' : 'hidden' }}" />
                            <div id="banner-placeholder" class="text-center p-6 {{ $event->featured_image ? 'hidden' : '' }}">
                                <span class="material-icons text-4xl text-slate-600 mb-2">add_photo_alternate</span>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Upload Banner</p>
                            </div>
                        </div>
                        <input type="file" name="banner_image" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewBanner(this)">
                    </div>
                    <p class="text-[9px] font-bold text-slate-600 uppercase tracking-widest text-center italic">Change image only if revision required.</p>
                </div>

                <div class="bg-blue-50/50 p-8 rounded-[2rem] border border-primary/10 space-y-6">
                    <h4 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] mb-4">Engagement Intelligence</h4>
                    
                    <label class="flex items-center justify-between cursor-pointer group bg-white p-5 rounded-2xl border border-transparent hover:border-accent/20 transition-all">
                        <div>
                            <div class="text-[11px] font-black text-slate-800 uppercase tracking-widest">Feature Initiative</div>
                            <div class="text-[10px] font-semibold text-slate-500">Enable homepage promotion.</div>
                        </div>
                        <div class="relative inline-flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $event->is_featured) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-12 h-7 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-accent after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all shadow-inner"></div>
                        </div>
                    </label>

                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-primary uppercase tracking-widest block px-1">Initiative Status</label>
                        <select name="status" class="w-full bg-white border border-primary/20 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all shadow-sm">
                            <option value="Upcoming" {{ old('status', $event->status) == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="Completed" {{ old('status', $event->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ old('status', $event->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-primary/10">
                        <h4 class="text-[11px] font-black text-primary uppercase tracking-[0.2em] mb-2">Document Intelligence</h4>
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-1">Certificate Design</label>
                            <select name="certificate_template_id" class="w-full bg-white border border-primary/20 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all shadow-sm text-slate-600">
                                <option value="">Default Blade Design</option>
                                @foreach($certificateTemplates as $tmpl)
                                    <option value="{{ $tmpl->id }}" {{ $event->certificate_template_id == $tmpl->id ? 'selected' : '' }}>{{ $tmpl->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-1">Ticket Design</label>
                            <select name="ticket_template_id" class="w-full bg-white border border-primary/20 rounded-2xl px-6 py-4 text-sm font-bold focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all shadow-sm text-slate-600">
                                <option value="">Default Blade Design</option>
                                @foreach($ticketTemplates as $tmpl)
                                    <option value="{{ $tmpl->id }}" {{ $event->ticket_template_id == $tmpl->id ? 'selected' : '' }}>{{ $tmpl->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Intelligence -->
            <div class="lg:col-span-2 space-y-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2 space-y-4">
                        <label class="text-[13px] font-black text-primary uppercase tracking-widest px-1 flex items-center gap-2">
                             Initiative Name <span class="w-1.5 h-1.5 bg-accent rounded-full"></span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $event->name) }}" required class="w-full bg-slate-50 border border-primary/5 rounded-2xl px-6 py-5 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-accent/10 focus:border-accent transition-all">
                    </div>

                    <div class="md:col-span-2 space-y-6">
                        <label class="text-[13px] font-black text-primary uppercase tracking-widest px-1 flex items-center gap-2">
                            Mission Timeline <span class="w-1.5 h-1.5 bg-accent rounded-full"></span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-primary uppercase tracking-widest">Date</label>
                                <input type="date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-base font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-primary uppercase tracking-widest">Start Time</label>
                                <input type="time" name="start_time" value="{{ old('start_time', $event->start_time) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-base font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-primary uppercase tracking-widest">End Time</label>
                                <input type="time" name="end_time" value="{{ old('end_time', $event->end_time) }}" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-base font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-6">
                        <label class="text-[13px] font-black text-primary uppercase tracking-widest px-1 flex items-center gap-2">
                            Location Logistics <span class="w-1.5 h-1.5 bg-accent rounded-full"></span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                             <div class="space-y-2 md:col-span-2">
                                <label class="text-[11px] font-bold text-primary uppercase tracking-widest">Venue Name</label>
                                <input type="text" name="venue" value="{{ old('venue', $event->venue) }}" placeholder="e.g. Vigyan Bhawan" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-primary uppercase tracking-widest">City</label>
                                <input type="text" name="city" value="{{ old('city', $event->city) }}" placeholder="e.g. New Delhi" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-primary uppercase tracking-widest">State/Country</label>
                                <input type="text" name="state" value="{{ old('state', $event->state) }}" placeholder="e.g. India" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[13px] font-black text-primary uppercase tracking-widest px-1">Digital Assets</label>
                        <input type="url" name="pdf_link" value="{{ old('pdf_link', $event->pdf_link) }}" placeholder="Link to Brochure/PDF (https://...)" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[13px] font-black text-primary uppercase tracking-widest px-1">Brief Descriptive Intelligence</label>
                        <textarea name="description" rows="5" class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">{{ old('description', $event->description) }}</textarea>
                    </div>
                </div>

                <!-- Ticket Management Section (Moved outside grid for visibility) -->
                <div class="space-y-8 bg-slate-50 p-10 rounded-[2.5rem] mt-12 border border-primary/5 shadow-inner">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary/20">
                                <span class="material-icons">confirmation_number</span>
                            </div>
                            <div>
                                <h4 class="text-[13px] font-black text-primary uppercase tracking-[0.2em]">Ticket Management</h4>
                                <p class="text-[10px] font-semibold text-slate-500">Configure access levels and pricing intelligence</p>
                            </div>
                        </div>
                        <button type="button" onclick="toggleTicketForm()" class="bg-accent text-white px-8 py-4 rounded-2xl font-bold text-[10px] uppercase tracking-widest hover:bg-primary shadow-xl shadow-accent/20 transition-all flex items-center gap-3 active:scale-95">
                            <span class="material-icons text-sm">add_circle</span> Add Pass Config
                        </button>
                    </div>

                    <!-- Add/Edit Ticket Form (Hidden by default) -->
                    <div id="ticket-form" class="hidden bg-white p-8 rounded-[2.5rem] border-2 border-accent/20 shadow-2xl relative">
                        <div class="absolute -top-4 left-6 bg-accent text-white px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-lg">Pass Configurator</div>
                        <h5 class="text-[11px] font-black text-primary uppercase tracking-widest mb-6">Internal Intelligence</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase">Ticket Name</label>
                                <input type="text" id="ticket_name" placeholder="e.g. VIP Pass" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase">Quantity</label>
                                <input type="number" id="ticket_quantity" placeholder="100" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase">Original Price (₹)</label>
                                <input type="number" step="0.01" id="original_price" placeholder="5000" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase">Offer Price (₹)</label>
                                <input type="number" step="0.01" id="offer_price" placeholder="4000" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase">Last Date to Buy</label>
                                <input type="datetime-local" id="last_date_to_buy" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase">Expiry Date</label>
                                <input type="datetime-local" id="expiry_date" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary">
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[9px] font-bold text-slate-400 uppercase">Benefits</label>
                                <textarea id="benefits" rows="3" placeholder="List all benefits included with this ticket..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary"></textarea>
                            </div>
                            <div class="md:col-span-2 py-2">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <div class="relative inline-flex items-center">
                                        <input type="checkbox" id="allow_membership_pass" value="1" checked class="sr-only peer">
                                        <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-primary after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all shadow-inner"></div>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Allow Membership Pass</span>
                                        <p class="text-[9px] font-medium text-slate-400">Members can use their free pass quota for this ticket.</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex gap-4 mt-8 pt-6 border-t border-slate-100">
                            <button type="button" onclick="saveTicket()" class="bg-primary text-white px-8 py-4 rounded-2xl font-bold text-[10px] uppercase tracking-widest hover:bg-accent shadow-lg shadow-primary/20 transition-all active:scale-95">
                                Save Configuration
                            </button>
                            <button type="button" onclick="toggleTicketForm()" class="bg-slate-100 text-slate-500 px-8 py-4 rounded-2xl font-bold text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all">
                                Cancel
                            </button>
                        </div>
                    </div>

                    <!-- Tickets List -->
                    <div id="tickets-list" class="grid grid-cols-1 gap-4">
                        @forelse($event->tickets as $ticket)
                        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 hover:border-accent/30 hover:shadow-xl hover:shadow-slate-200/50 transition-all group" data-ticket-id="{{ $ticket->id }}">
                             <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-6">
                                <div class="flex-1 w-full text-center md:text-left">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h5 class="text-sm font-black text-slate-800 uppercase">{{ $ticket->ticket_name }}</h5>
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[9px] font-black uppercase">{{ $ticket->ticket_quantity }} Available</span>
                                        @if($ticket->allow_membership_pass)
                                            <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-[9px] font-black uppercase flex items-center gap-1">
                                                <span class="material-icons text-[10px]">auto_awesome</span> Pass Eligible
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-red-50 text-red-400 rounded-full text-[9px] font-black uppercase flex items-center gap-1">
                                                <span class="material-icons text-[10px]">block</span> Pass Disabled
                                            </span>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-[10px] font-bold text-slate-500 mb-3">
                                        <div>
                                            <span class="text-[9px] text-slate-400 uppercase block">Price</span>
                                            @if($ticket->offer_price)
                                                <span class="line-through text-slate-400">₹{{ number_format($ticket->original_price, 2) }}</span>
                                                <span class="text-primary ml-2">₹{{ number_format($ticket->offer_price, 2) }}</span>
                                            @else
                                                <span class="text-primary">₹{{ number_format($ticket->original_price, 2) }}</span>
                                            @endif
                                        </div>
                                        @if($ticket->last_date_to_buy)
                                        <div>
                                            <span class="text-[9px] text-slate-400 uppercase block">Buy Before</span>
                                            {{ \Carbon\Carbon::parse($ticket->last_date_to_buy)->format('d M, Y') }}
                                        </div>
                                        @endif
                                        @if($ticket->expiry_date)
                                        <div>
                                            <span class="text-[9px] text-slate-400 uppercase block">Expires</span>
                                            {{ \Carbon\Carbon::parse($ticket->expiry_date)->format('d M, Y') }}
                                        </div>
                                        @endif
                                    </div>
                                    @if($ticket->benefits)
                                    <div class="text-[10px] font-medium text-slate-600 bg-slate-50 p-3 rounded-xl mt-3">
                                        <span class="text-[9px] text-slate-400 uppercase font-black block mb-1">Benefits:</span>
                                        {{ $ticket->benefits }}
                                    </div>
                                    @endif
                                </div>
                                <div class="flex flex-row gap-2 mt-4 md:mt-0">
                                    <button type="button" onclick="editTicket({{ $ticket->id }})" class="w-10 h-10 rounded-xl bg-blue-50 text-primary hover:bg-accent hover:text-white transition-all flex items-center justify-center shadow-sm">
                                        <span class="material-icons text-base">edit_note</span>
                                    </button>
                                    <button type="button" onclick="deleteTicket({{ $ticket->id }})" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center shadow-sm">
                                        <span class="material-icons text-base">delete_sweep</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 bg-white rounded-2xl border-2 border-dashed border-slate-200">
                            <span class="material-icons text-4xl text-slate-200 mb-2">confirmation_number</span>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No tickets configured yet</p>
                            <p class="text-[9px] font-bold text-slate-400 mt-1">Click "Add Ticket" to create your first ticket type</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="pt-8 flex justify-end">
                    <button type="submit" class="bg-accent text-white px-8 py-3.5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-accent/20 hover:bg-primary hover:-translate-y-0.5 active:scale-95 transition-all flex items-center gap-3">
                        Update Global Intelligence <span class="material-icons text-lg">rocket_launch</span>
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

    // Ticket Management Functions
    let editingTicketId = null;

    function toggleTicketForm() {
        const form = document.getElementById('ticket-form');
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            // Clear form when opening
            clearTicketForm();
        }
    }

    function clearTicketForm() {
        editingTicketId = null;
        document.getElementById('ticket_name').value = '';
        document.getElementById('ticket_quantity').value = '';
        document.getElementById('original_price').value = '';
        document.getElementById('offer_price').value = '';
        document.getElementById('last_date_to_buy').value = '';
        document.getElementById('expiry_date').value = '';
        document.getElementById('benefits').value = '';
        document.getElementById('allow_membership_pass').checked = true;
    }

    function saveTicket() {
        const data = {
            event_id: {{ $event->id }},
            ticket_name: document.getElementById('ticket_name').value,
            ticket_quantity: document.getElementById('ticket_quantity').value,
            original_price: document.getElementById('original_price').value,
            offer_price: document.getElementById('offer_price').value || null,
            last_date_to_buy: document.getElementById('last_date_to_buy').value || null,
            expiry_date: document.getElementById('expiry_date').value || null,
            benefits: document.getElementById('benefits').value || null,
            allow_membership_pass: document.getElementById('allow_membership_pass').checked ? 1 : 0,
            _token: '{{ csrf_token() }}'
        };

        const baseUrl = '{{ url('/') }}';
        const url = editingTicketId 
            ? `${baseUrl}/admin/events/tickets/${editingTicketId}`
            : `${baseUrl}/admin/events/tickets`;
        
        const method = editingTicketId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            if (!response.ok) {
                const errData = await response.json();
                if (response.status === 422) {
                    let errors = [];
                    for (let key in errData.errors) {
                        errors.push(errData.errors[key].join(', '));
                    }
                    throw new Error('Validation failed:\n' + errors.join('\n'));
                }
                throw new Error(errData.message || 'Server error occurred');
            }
            return response.json();
        })
        .then(result => {
            if (result.success) {
                window.location.reload();
            } else {
                alert('Error: ' + (result.message || 'Failed to save ticket'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'An error occurred while saving the ticket');
        });
    }

    function editTicket(ticketId) {
        const baseUrl = '{{ url('/') }}';
        fetch(`${baseUrl}/admin/events/tickets/${ticketId}`)
            .then(response => response.json())
            .then(ticket => {
                editingTicketId = ticketId;
                document.getElementById('ticket_name').value = ticket.ticket_name;
                document.getElementById('ticket_quantity').value = ticket.ticket_quantity;
                document.getElementById('original_price').value = ticket.original_price;
                document.getElementById('offer_price').value = ticket.offer_price || '';
                document.getElementById('last_date_to_buy').value = ticket.last_date_to_buy ? ticket.last_date_to_buy.replace(' ', 'T').substring(0, 16) : '';
                document.getElementById('expiry_date').value = ticket.expiry_date ? ticket.expiry_date.replace(' ', 'T').substring(0, 16) : '';
                document.getElementById('benefits').value = ticket.benefits || '';
                document.getElementById('allow_membership_pass').checked = !!ticket.allow_membership_pass;
                
                document.getElementById('ticket-form').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load ticket details');
            });
    }

    function deleteTicket(ticketId) {
        if (!confirm('Are you sure you want to delete this ticket?')) {
            return;
        }

        const baseUrl = '{{ url('/') }}';
        fetch(`${baseUrl}/admin/events/tickets/${ticketId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                window.location.reload();
            } else {
                alert('Error: ' + (result.message || 'Failed to delete ticket'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the ticket');
        });
    }
</script>
@endsection
