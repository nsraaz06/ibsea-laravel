<?php

namespace App\Services;

use App\Models\IssuedDocument;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DocumentService
{
    /**
     * Get or create a unique document number.
     */
    public function getUniqueDocumentNo($member, $type, $bookingId = null)
    {
        // Check if already issued
        $query = IssuedDocument::where('member_id', $member->id)
            ->where('document_type', $type);
        
        if ($bookingId) {
            $query->where('event_booking_id', $bookingId);
        }

        $issued = $query->first();

        if ($issued) {
            return $issued->document_no;
        }

        // Generate new one
        $year = Carbon::now()->year;
        $prefix = $this->getPrefix($type);
        
        // Get next sequence number for this year and type
        $lastSequence = IssuedDocument::where('year', $year)
            ->where('document_type', $type)
            ->max('sequence_number') ?: 0;
        
        $nextSequence = $lastSequence + 1;
        $paddedSequence = str_pad($nextSequence, 6, '0', STR_PAD_LEFT);
        $randomHash = strtoupper(Str::random(4));

        $documentNo = "{$prefix}-{$year}-{$paddedSequence}-{$randomHash}";

        // Persist
        IssuedDocument::create([
            'document_no' => $documentNo,
            'member_id' => $member->id,
            'event_booking_id' => $bookingId,
            'document_type' => $type,
            'year' => $year,
            'sequence_number' => $nextSequence,
            'issued_at' => Carbon::now()
        ]);

        return $documentNo;
    }

    private function getPrefix($type)
    {
        return match ($type) {
            'certificate' => 'CERT',
            'id_card' => 'ID',
            'ticket' => 'TCKT',
            default => 'DOC',
        };
    }
}
