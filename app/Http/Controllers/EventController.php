<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Show the events hub page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = Event::where('status', 'Upcoming')
            ->orderBy('event_date', 'asc')
            ->get();

        return view('events', [
            'title' => 'Events Hub | IBSEA Mission Events',
            'events' => $events
        ]);
    }

    /**
     * Show a single event detail page.
     */
    public function show(Request $request, $id)
    {
        if ($request->has('verify')) {
            return redirect()->route('public.verify-ticket', ['verify' => $request->query('verify')]);
        }

        $event = Event::with('tickets')->findOrFail($id);

        return view('events.show', [
            'title' => $event->name . ' | IBSEA Event Details',
            'event' => $event
        ]);
    }

    /**
     * Public Ticket Verification Page
     */
    public function verifyTicket(Request $request)
    {
        $result = null;
        $error = null;

        if ($request->has('ticket_no')) {
            $formattedTicketNo = strtoupper(trim($request->input('ticket_no')));
            $document = \App\Models\IssuedDocument::where('document_no', $formattedTicketNo)
                                ->where('document_type', 'ticket')
                                ->first();
            
            if ($document && $document->event_booking_id) {
                $booking = \App\Models\EventBooking::with(['member', 'event', 'ticket'])->find($document->event_booking_id);
                if ($booking && in_array($booking->status, ['Paid', 'Confirmed', 'Success'])) {
                    $result = $booking;
                } else {
                    $error = 'Ticket found but marking is invalid or unpaid.';
                }
            } else {
                $error = 'No valid ticket found matching this ticket number.';
            }
        } elseif ($request->has('verify')) {
            $token = $request->input('verify');
            $booking = \App\Models\EventBooking::with(['member', 'event', 'ticket'])
                            ->where('secret_token', $token)
                            ->first();
                            
            if ($booking && in_array($booking->status, ['Paid', 'Confirmed', 'Success'])) {
                $result = $booking;
            } else {
                $error = 'Invalid or expired QR code token.';
            }
        }

        return view('events.verify', compact('result', 'error'));
    }
}
