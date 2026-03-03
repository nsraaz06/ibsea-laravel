<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\SiteSetting;
use App\Models\DesignTemplate;
use Illuminate\Support\Facades\Storage;
use App\Services\DocumentService;

class AssetController extends Controller
{
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    private function getBase64Image($path)
    {
        if (!$path) return null;
        
        // Handle full URLs
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            try {
                $client = new \GuzzleHttp\Client(['verify' => false, 'timeout' => 5]);
                $response = $client->get($path);
                $type = $response->getHeaderLine('Content-Type');
                if (!$type) $type = 'image/' . (pathinfo($path, PATHINFO_EXTENSION) ?: 'png');
                return 'data:' . $type . ';base64,' . base64_encode($response->getBody()->getContents());
            } catch (\Exception $e) {
                return null;
            }
        }

        $paths = [
            storage_path('app/public/' . $path),
            public_path('storage/' . $path),
            public_path($path),
            storage_path($path)
        ];

        $fullPath = null;
        foreach ($paths as $p) {
            if (file_exists($p) && !is_dir($p)) {
                $fullPath = $p;
                break;
            }
        }

        if (!$fullPath) return null;

        $type = 'image/' . pathinfo($fullPath, PATHINFO_EXTENSION);
        $data = file_get_contents($fullPath);
        return 'data:' . $type . ';base64,' . base64_encode($data);
    }

    public function downloadCertificate()
    {
        if (!SiteSetting::where('key', 'allow_certificate_download')->value('value')) {
            return redirect()->back()->with('error', 'Certificate downloads are currently disabled.');
        }

        $user = Auth::guard('member')->user();
        $plan = $user->membershipPlan;
        
        $template = null;
        
        // Priority 1: Membership Plan Custom Template
        if ($plan && $plan->certificate_template_id) {
            $template = DesignTemplate::find($plan->certificate_template_id);
        }

        if (!$template) {
            // Check if latest event booking has a specific template
            $latestBooking = \App\Models\EventBooking::where('member_id', $user->id)->with('event', 'ticket')->latest()->first();
            if ($latestBooking && $latestBooking->event->certificate_template_id) {
                $template = DesignTemplate::find($latestBooking->event->certificate_template_id);
            }
        }

        if (!$template) {
            // Fallback to the latest template of this type if not explicitly assigned
            $template = DesignTemplate::where('type', 'certificate')->latest()->first();
        }

        if ($template) {
            $certificateNo = $this->documentService->getUniqueDocumentNo($user, 'certificate', $latestBooking->id ?? null);
            
            $data = [
                'user' => $user,
                'event' => $latestBooking->event ?? null,
                'background' => $this->getBase64Image($template->background_path),
                'elements' => $template->layout_json['objects'] ?? [],
                'width' => $template->width,
                'height' => $template->height,
                'date' => now()->format('F d, Y'),
                'serial_id' => 'IBSEA-' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                'certificate_no' => $certificateNo,
                'membership_type' => $user->membershipPlan->title ?? 'Standard Member',
                'start_date' => $user->membership_start ? \Carbon\Carbon::parse($user->membership_start)->format('d M, Y') : 'N/A',
                'end_date' => $user->membership_end ? \Carbon\Carbon::parse($user->membership_end)->format('d M, Y') : 'N/A',
                'event_venue' => $latestBooking->event->venue ?? '',
                'event_time' => ($latestBooking && $latestBooking->event->start_time) ? (\Carbon\Carbon::parse($latestBooking->event->start_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($latestBooking->event->end_time)->format('h:i A')) : '',
                'ticket_type' => $latestBooking->ticket->ticket_name ?? 'General',
                'event_image' => $latestBooking ? $this->getBase64Image($latestBooking->event->featured_image ?? null) : null,
                'profile_image' => $this->getBase64Image($user->profile_image),
            ];
            $pdf = PDF::loadView('pdf.dynamic', $data);
            $orientation = $template->width > $template->height ? 'landscape' : 'portrait';
            // Use 1:1 Pixel-to-Point mapping for zero-shift alignment
            $pdf->setPaper([0, 0, $template->width, $template->height], $orientation);
            return $pdf->download('IBSEA_Certificate.pdf');
        }

        // Fallback to static
        $data = [
            'user' => $user,
            'date' => now()->format('F d, Y'),
            'certificate_id' => 'IBSEA-' . str_pad($user->id, 6, '0', STR_PAD_LEFT)
        ];
        $pdf = PDF::loadView('pdf.certificate', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('IBSEA_Membership_Certificate.pdf');
    }

    public function downloadIdCard()
    {
        if (!SiteSetting::where('key', 'allow_id_card_download')->value('value')) {
            return redirect()->back()->with('error', 'ID Card downloads are currently disabled.');
        }

        $user = Auth::guard('member')->user();
        $plan = $user->membershipPlan;
        
        $template = null;
        if ($plan && $plan->id_card_template_id) {
            $template = DesignTemplate::find($plan->id_card_template_id);
        }

        if (!$template) {
            // Fallback to the latest template of this type if not explicitly assigned
            $template = DesignTemplate::where('type', 'id_card')->latest()->first();
        }

        if ($template) {
            $idCardNo = $this->documentService->getUniqueDocumentNo($user, 'id_card');

            $data = [
                'user' => $user,
                'background' => $this->getBase64Image($template->background_path),
                'elements' => $template->layout_json['objects'] ?? [],
                'width' => $template->width,
                'height' => $template->height,
                'valid_until' => $user->membership_end ? \Carbon\Carbon::parse($user->membership_end)->format('M Y') : 'N/A',
                'certificate_no' => $idCardNo,
                'membership_type' => $user->membershipPlan->title ?? 'Member',
                'start_date' => $user->membership_start ? \Carbon\Carbon::parse($user->membership_start)->format('d M, Y') : 'N/A',
                'end_date' => $user->membership_end ? \Carbon\Carbon::parse($user->membership_end)->format('d M, Y') : 'N/A',
                'profile_image' => $this->getBase64Image($user->profile_image),
            ];
            $pdf = PDF::loadView('pdf.dynamic', $data);
            $orientation = $template->width > $template->height ? 'landscape' : 'portrait';
            // Use 1:1 Pixel-to-Point mapping for zero-shift alignment
            $pdf->setPaper([0, 0, $template->width, $template->height], $orientation);
            return $pdf->download('IBSEA_ID_Card.pdf');
        }

        // Fallback to static
        $data = [
            'user' => $user,
            'valid_until' => $user->membership_end ? \Carbon\Carbon::parse($user->membership_end)->format('M Y') : 'N/A'
        ];
        $pdf = PDF::loadView('pdf.id_card', $data);
        $customPaper = array(0,0,243,153);
        $pdf->setPaper($customPaper, 'landscape');
        return $pdf->download('IBSEA_ID_Card.pdf');
    }

    public function downloadTicket($id)
    {
        $setting = SiteSetting::where('key', 'allow_ticket_download')->first();
        if ($setting && $setting->value === '0') {
            return redirect()->back()->with('error', 'Ticket downloads are currently disabled.');
        }

        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', '60');

        try {
            $user = Auth::guard('member')->user();
            $booking = \App\Models\EventBooking::where('id', $id)
                ->where('member_id', $user->id)
                ->with('event', 'ticket')
                ->firstOrFail();

            if (!$booking->secret_token) {
                $booking->update(['secret_token' => \Illuminate\Support\Str::random(32)]);
            }

            $qrData = route('public.events.show', $booking->event_id) . '?verify=' . $booking->secret_token;
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrData);
            
            // Fetch QR code as base64
            $qrCodeBase64 = '';
            try {
                $client = new \GuzzleHttp\Client(['verify' => false, 'timeout' => 5]);
                $response = $client->get($qrUrl);
                $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($response->getBody()->getContents());
            } catch (\Exception $e) {}

            $template = null;
            if ($booking->event->ticket_template_id) {
                $template = DesignTemplate::find($booking->event->ticket_template_id);
            }

            if (!$template) {
                // Fallback to the latest template of this type if not explicitly assigned
                $template = DesignTemplate::where('type', 'ticket')->latest()->first();
            }

            if ($template) {
                $ticketNo = $this->documentService->getUniqueDocumentNo($user, 'ticket', $booking->id);

                $data = [
                    'user' => $user,
                    'event' => $booking->event,
                    'booking' => $booking,
                    'background' => $this->getBase64Image($template->background_path),
                    'elements' => $template->layout_json['objects'] ?? [],
                    'width' => $template->width,
                    'height' => $template->height,
                    'qrCode' => $qrCodeBase64,
                    'date' => now()->format('F d, Y'),
                    'transaction_id' => 'TKT-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                    'ticket_no' => $ticketNo,
                    'certificate_no' => $ticketNo, // Fallback for old templates
                    'membership_type' => $user->membershipPlan->title ?? 'Member',
                    'event_venue' => $booking->event->venue ?? '',
                    'event_time' => ($booking->event->start_time) ? (\Carbon\Carbon::parse($booking->event->start_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($booking->event->end_time)->format('h:i A')) : '',
                    'event_date' => ($booking->event->start_time) ? \Carbon\Carbon::parse($booking->event->start_time)->format('F d, Y') : '',
                    'ticket_type' => $booking->ticket->ticket_name ?? 'General',
                    'event_image' => $this->getBase64Image($booking->event->featured_image ?? null),
                    'profile_image' => $this->getBase64Image($user->profile_image),
                ];
                $pdf = PDF::loadView('pdf.dynamic', $data);
                $orientation = $template->width > $template->height ? 'landscape' : 'portrait';
                // Use 1:1 Pixel-to-Point mapping for zero-shift alignment
                $pdf->setPaper([0, 0, $template->width, $template->height], $orientation);
                return response($pdf->output(), 200)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'attachment; filename="IBSEA_Ticket_'.$booking->id.'.pdf"');
            }

            // Fallback to static
            $data = [
                'user' => $user,
                'booking' => $booking,
                'qrCode' => $qrCodeBase64,
                'logo' => '', 
                'date' => now()->format('F d, Y')
            ];
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.ticket', $data);
            $pdf->setPaper('a4', 'portrait');
            return response($pdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="IBSEA_Ticket_'.$booking->id.'.pdf"');

        } catch (\Exception $e) {
            return response('Ticket Generation Error: ' . $e->getMessage(), 500);
        }
    }

    public function preview($type, $id = null)
    {
        $user = Auth::guard('member')->user();
        $template = null;
        $booking = null;

        if ($type === 'certificate') {
            $plan = $user->membershipPlan;
            if ($plan && $plan->certificate_template_id) {
                $template = DesignTemplate::find($plan->certificate_template_id);
            }
            if (!$template) {
                $booking = \App\Models\EventBooking::where('member_id', $user->id)->with('event')->latest()->first();
                if ($booking && $booking->event->certificate_template_id) {
                    $template = DesignTemplate::find($booking->event->certificate_template_id);
                }
            }
        } elseif ($type === 'id_card') {
            $plan = $user->membershipPlan;
            if ($plan && $plan->id_card_template_id) {
                $template = DesignTemplate::find($plan->id_card_template_id);
            }
        } elseif ($type === 'ticket' && $id) {
            $booking = \App\Models\EventBooking::where('id', $id)
                ->where('member_id', $user->id)
                ->with('event', 'ticket')
                ->firstOrFail();
            if ($booking->event->ticket_template_id) {
                $template = DesignTemplate::find($booking->event->ticket_template_id);
            }
        }

        if (!$template) {
            // Fallback to the latest template of this type if not explicitly assigned
            $template = DesignTemplate::where('type', $type)->latest()->first();
        }

        if (!$template) {
            return redirect()->back()->with('error', 'Design template not found for this asset.');
        }

        $qrCodeBase64 = '';
        if (($type === 'ticket' || $type === 'certificate') && $booking) {
            if (!$booking->secret_token) {
                $booking->update(['secret_token' => \Illuminate\Support\Str::random(32)]);
            }
            $qrData = route('public.events.show', $booking->event_id) . '?verify=' . $booking->secret_token;
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrData);
            try {
                $client = new \GuzzleHttp\Client(['verify' => false, 'timeout' => 5]);
                $response = $client->get($qrUrl);
                $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($response->getBody()->getContents());
            } catch (\Exception $e) {}
        }

        $certificateNo = $this->documentService->getUniqueDocumentNo($user, $type, $booking->id ?? null);

        $data = [
            'type' => $type,
            'template' => $template,
            'user' => $user,
            'booking' => $booking,
            'background' => $this->getBase64Image($template->background_path),
            'qrCode' => $qrCodeBase64,
            'certificate_no' => $certificateNo,
            'date' => now()->format('F d, Y'),
            'serial_id' => 'IBSEA-' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
            'membership_type' => $user->membershipPlan->title ?? 'Standard Member',
            'start_date' => $user->membership_start ? \Carbon\Carbon::parse($user->membership_start)->format('d M, Y') : 'N/A',
            'end_date' => $user->membership_end ? \Carbon\Carbon::parse($user->membership_end)->format('d M, Y') : 'N/A',
            'event_venue' => $booking->event->venue ?? '',
            'event_time' => ($booking && $booking->event->start_time) ? (\Carbon\Carbon::parse($booking->event->start_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($booking->event->end_time)->format('h:i A')) : '',
            'event_date' => ($booking && $booking->event->start_time) ? \Carbon\Carbon::parse($booking->event->start_time)->format('F d, Y') : '',
            'ticket_type' => $booking->ticket->ticket_name ?? $booking->ticket->type ?? 'General',
            'ticket_no' => $certificateNo,
            'transaction_id' => $booking ? 'TKT-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT) : '',
            'event_image' => ($booking && $booking->event && $booking->event->featured_image) ? $this->getBase64Image($booking->event->featured_image) : null,
            'profile_image' => $this->getBase64Image($user->profile_image),
            'certificateNo' => $certificateNo, // Add this for consistency with service
        ];

        return view('user.assets.preview', $data);
    }
}
