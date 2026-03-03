<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventTicket;
use Illuminate\Http\Request;

class EventTicketController extends Controller
{
    /**
     * Display the specified ticket.
     */
    public function show($id)
    {
        $ticket = EventTicket::findOrFail($id);
        return response()->json($ticket);
    }

    /**
     * Store a newly created ticket.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_name' => 'required|string|max:100',
            'ticket_quantity' => 'required|integer|min:0',
            'original_price' => 'required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0',
            'last_date_to_buy' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'benefits' => 'nullable|string',
            'allow_membership_pass' => 'nullable|boolean',
        ]);

        $ticket = EventTicket::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ticket created successfully',
            'ticket' => $ticket
        ]);
    }

    /**
     * Update the specified ticket.
     */
    public function update(Request $request, $id)
    {
        $ticket = EventTicket::findOrFail($id);

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_name' => 'required|string|max:100',
            'ticket_quantity' => 'required|integer|min:0',
            'original_price' => 'required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0',
            'last_date_to_buy' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'benefits' => 'nullable|string',
            'allow_membership_pass' => 'nullable|boolean',
        ]);

        $ticket->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ticket updated successfully',
            'ticket' => $ticket
        ]);
    }

    /**
     * Remove the specified ticket.
     */
    public function destroy($id)
    {
        $ticket = EventTicket::findOrFail($id);
        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ticket deleted successfully'
        ]);
    }
}
