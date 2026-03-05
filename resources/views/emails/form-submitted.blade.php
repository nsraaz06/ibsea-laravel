<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; background-color: #f8fafc; color: #1e293b; padding: 40px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0; }
        .header { background: #004a95; color: white; padding: 40px; text-align: center; }
        .content { padding: 40px; }
        .footer { background: #f1f5f9; padding: 20px; text-align: center; font-size: 12px; color: #64748b; }
        h1 { margin: 0; font-size: 24px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
        h2 { font-size: 14px; color: #004a95; text-transform: uppercase; margin-top: 30px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
        .field { margin-bottom: 20px; }
        .label { font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 5px; }
        .value { font-size: 14px; font-weight: 700; color: #1e293b; }
        .button { display: inline-block; background: #f26f21; color: white; padding: 15px 30px; border-radius: 12px; text-decoration: none; font-weight: 800; font-size: 12px; text-transform: uppercase; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Submission</h1>
            <p style="margin-top: 10px; font-size: 14px; opacity: 0.8;">Protocol: {{ $submission->form->title }}</p>
        </div>
        <div class="content">
            <p style="font-size: 14px; line-height: 1.6;">A new intelligence report has been securely transmitted and logged in the IBSEA Command Center.</p>
            
            <h2>Reporting Agent</h2>
            <div class="field">
                <span class="label">Name</span>
                <span class="value">{{ $submission->member ? $submission->member->name : 'Guest User' }}</span>
            </div>
            <div class="field">
                <span class="label">Email</span>
                <span class="value">{{ $submission->member ? $submission->member->email : 'N/A' }}</span>
            </div>
            <div class="field">
                <span class="label">Source IP</span>
                <span class="value">{{ $submission->ip_address }}</span>
            </div>

            <h2>Submitted Intelligence</h2>
            @foreach($submission->form->fields as $field)
                <div class="field">
                    <span class="label">{{ $field['label'] }}</span>
                    <span class="value">
                        @php $val = $submission->data[$field['name']] ?? 'N/A'; @endphp
                        @if(is_array($val))
                            {{ implode(', ', $val) }}
                        @else
                            {{ $val }}
                        @endif
                    </span>
                </div>
            @endforeach

            <div style="text-align: center;">
                <a href="{{ url('/admin/submissions/detail/' . $submission->id) }}" class="button">Examine in Command Center</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} IBSEA - International Business and Startup Association.<br>
            Secure Transmission Protocol v4.0
        </div>
    </div>
</body>
</html>
