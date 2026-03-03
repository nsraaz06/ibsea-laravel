<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Confirmed</title>
    <style>
    <style>
        body { margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Segoe UI', Arial, sans-serif; }
        .wrapper { width: 100%; max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #002855, #0A4A95); padding: 40px 40px 30px; text-align: center; }
        .header img { width: 160px; height: auto; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 900; letter-spacing: 1px; margin: 20px 0 4px; text-transform: uppercase; }
        .header p { color: rgba(255,255,255,0.7); font-size: 13px; margin: 0; }
        .body { padding: 40px; }
        .check-icon { width: 64px; height: 64px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 32px; }
        .body h2 { text-align: center; font-size: 20px; font-weight: 900; color: #1e293b; margin-bottom: 8px; }
        .body .intro { text-align: center; color: #64748b; font-size: 14px; margin-bottom: 32px; }
        .section-title { font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 12px; }
        .form-title-pill { display: inline-block; background: #eff6ff; color: #0A4A95; border-radius: 999px; padding: 8px 20px; font-weight: 800; font-size: 14px; margin-bottom: 32px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 32px; }
        .data-table td { padding: 12px 16px; font-size: 13px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        .data-table td:first-child { font-weight: 700; color: #475569; width: 40%; }
        .data-table td:last-child { color: #1e293b; }
        .data-table tr:last-child td { border-bottom: none; }
        .cta-block { background: #f8fafc; border-radius: 16px; padding: 24px; text-align: center; margin-bottom: 32px; }
        .cta-block p { margin: 0 0 16px; font-size: 14px; color: #64748b; }
        .cta-button { display: inline-block; background: #0A4A95; color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 12px; font-weight: 900; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; }
        .footer { background: #f8fafc; padding: 24px 40px; text-align: center; }
        .footer p { color: #94a3b8; font-size: 11px; margin: 4px 0; }
        .accent { color: #f26f21; }

        @media only screen and (max-width: 620px) {
            .wrapper { margin: 0 !important; border-radius: 0 !important; }
            .body { padding: 30px 20px !important; }
            .header { padding: 30px 20px !important; }
            .data-table td { padding: 10px 8px !important; font-size: 12px !important; }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Header -->
    <div class="header">
        <img src="{{ asset('storage/email-logo.png') }}" alt="IBSEA">
        <h1>Submission Confirmed</h1>
        <p>Indian Business & Strategic Excellence Alliance</p>
    </div>

    <!-- Body -->
    <div class="body">
        <div class="check-icon">✓</div>
        <h2>We've received your response!</h2>
        <p class="intro">Thank you for taking the time to fill out our form. Here is a summary of what you submitted.</p>

        <div class="section-title">Form</div>
        <span class="form-title-pill">{{ $submission->form->title ?? 'Form Submission' }}</span>

        <div class="section-title">Your Submission</div>
        <table class="data-table">
            @foreach((array)$submission->data as $key => $value)
            <tr>
                <td>{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                <td>
                    @if(is_array($value))
                        {{ implode(', ', $value) }}
                    @else
                        {{ $value ?: '—' }}
                    @endif
                </td>
            </tr>
            @endforeach
        </table>

        <div class="section-title">Submitted At</div>
        <p style="font-size:13px; color:#475569; margin-bottom:32px;">
            {{ $submission->created_at->format('d M Y, h:i A') }}
        </p>

        <div class="cta-block">
            <p>Have questions or need to follow up? Our team is here to help.</p>
            <a href="{{ config('app.url') }}" class="cta-button">Visit IBSEA Portal</a>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong class="accent">IBSEA</strong> — Indian Business & Strategic Excellence Alliance</p>
        <p>This is an automated confirmation. Please do not reply to this email.</p>
    </div>
</div>
</body>
</html>
