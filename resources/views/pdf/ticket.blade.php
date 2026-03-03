<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 40px;
            color: #1e293b;
        }
        .ticket-container {
            border: 2px solid #e2e8f0;
            border-radius: 30px;
            padding: 40px;
            position: relative;
            background: #ffffff;
        }
        .header {
            margin-bottom: 40px;
            border-bottom: 2px solid #f26f21;
            padding-bottom: 20px;
        }
        .logo {
            height: 50px;
            margin-bottom: 15px;
        }
        .event-title {
            font-size: 28px;
            font-weight: 900;
            text-transform: uppercase;
            margin: 10px 0;
            color: #0f172a;
        }
        .details-grid {
            width: 100%;
            margin-top: 30px;
        }
        .detail-item {
            padding: 15px 0;
        }
        .label {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        .value {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
        }
        .qr-section {
            text-align: center;
            margin-top: 50px;
            padding-top: 40px;
            border-top: 1px dashed #e2e8f0;
        }
        .qr-code {
            width: 200px;
            height: 200px;
            margin-bottom: 15px;
        }
        .secret-token {
            font-family: monospace;
            font-size: 10px;
            color: #94a3b8;
        }
        .footer {
            margin-top: 40px;
            font-size: 10px;
            text-align: center;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 900;
            letter-spacing: 1px;
        }
        .watermark {
            position: absolute;
            right: 40px;
            top: 40px;
            font-size: 12px;
            font-weight: 900;
            color: #f26f21;
            border: 1px solid #f26f21;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="watermark">OFFICIAL PASS</div>
        
        <div class="header">
            @if($logo)
                <img src="{{ $logo }}" class="logo">
            @endif
            <div class="label">IBSEA Event Ticket</div>
            <div class="event-title">{{ $booking->event->title }}</div>
        </div>

        <table class="details-grid">
            <tr>
                <td class="detail-item" width="50%">
                    <div class="label">Strategic Delegate</div>
                    <div class="value">{{ $user->name }}</div>
                </td>
                <td class="detail-item">
                    <div class="label">Date & Time</div>
                    <div class="value">{{ $booking->event->event_date->format('d M, Y') }} @ {{ $booking->event->event_time }}</div>
                </td>
            </tr>
            <tr>
                <td class="detail-item">
                    <div class="label">Venue</div>
                    <div class="value">{{ $booking->event->venue }}</div>
                </td>
                <td class="detail-item">
                    <div class="label">Access Level</div>
                    <div class="value">{{ $booking->ticket->ticket_name }}</div>
                </td>
            </tr>
        </table>

        <div class="qr-section">
            <div class="label">Unique Entry Identifier</div>
            <img src="{{ $qrCode }}" width="180" height="180">
            <div class="secret-token" style="margin-top: 10px;">ID: {{ $booking->secret_token }}</div>
            <p style="font-size: 11px; font-weight: 700; color: #64748b; margin-top: 10px;">
                Scan at the mission entrance for institutional verification.
            </p>
        </div>

        <div class="footer">
            International Business and Startup Association • Global Alliance Network
        </div>
    </div>
</body>
</html>
