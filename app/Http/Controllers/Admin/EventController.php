<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\DesignTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of upcoming and past events.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->withCount(['bookings as confirmed_bookings_count' => function($q) {
            $q->where('status', 'Confirmed');
        }])->orderBy('event_date', 'desc')->paginate(15);

        return view('admin.events.index', [
            'events' => $events,
            'title' => 'Event Management | IBSEA Admin'
        ]);
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $certificateTemplates = DesignTemplate::where('type', 'certificate')->where('status', true)->get();
        $ticketTemplates = DesignTemplate::where('type', 'ticket')->where('status', true)->get();

        return view('admin.events.create', [
            'title' => 'Orchestrate New Event | IBSEA Admin',
            'certificateTemplates' => $certificateTemplates,
            'ticketTemplates' => $ticketTemplates
        ]);
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'venue' => 'nullable|string|max:255',

            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pdf_link' => 'nullable|url',
            'status' => 'required|in:Upcoming,Completed,Cancelled',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('events', 'public');
            $data['featured_image'] = $path;
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event orchestrated successfully.');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        $event->load('tickets');
        $certificateTemplates = DesignTemplate::where('type', 'certificate')->where('status', true)->get();
        $ticketTemplates = DesignTemplate::where('type', 'ticket')->where('status', true)->get();
        
        return view('admin.events.edit', [
            'event' => $event,
            'title' => 'Refine Event | ' . $event->name,
            'certificateTemplates' => $certificateTemplates,
            'ticketTemplates' => $ticketTemplates
        ]);
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'venue' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pdf_link' => 'nullable|url',
            'status' => 'required|in:Upcoming,Completed,Cancelled',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('banner_image')) {
            if ($event->featured_image) {
                Storage::disk('public')->delete($event->featured_image);
            }
            $path = $request->file('banner_image')->store('events', 'public');
            $data['featured_image'] = $path;
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event intelligence updated.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return redirect()->route('public.events.show', $event->id);
    }

    /**
     * Display sales analytics for the specific event.
     */
    public function sales(Event $event)
    {
        $event->load([
            'tickets' => function($q) {
                $q->withCount(['bookings' => function($qb) {
                    $qb->where('status', 'Confirmed');
                }]);
            },
            'bookings' => function($q) {
                $q->where('status', 'Confirmed')->with(['member', 'ticket', 'payment']);
            }
        ]);

        $totalRevenue = $event->bookings->sum(function($booking) {
            return $booking->payment ? $booking->payment->amount : 0;
        });

        $totalTicketsSold = $event->bookings->count();

        return view('admin.events.sales', [
            'event' => $event,
            'totalRevenue' => $totalRevenue,
            'totalTicketsSold' => $totalTicketsSold,
            'title' => 'Sales Analytics | ' . $event->name
        ]);
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->featured_image) {
            Storage::disk('public')->delete($event->featured_image);
        }
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event data archived.');
    }
}
