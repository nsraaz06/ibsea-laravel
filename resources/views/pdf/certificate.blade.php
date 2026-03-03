<!DOCTYPE html>
<html>
<head>
    <title>Membership Certificate</title>
    <style>
        @page { margin: 0px; }
        body { margin: 0px; font-family: 'Helvetica', sans-serif; background-color: #f8f9fa; }
        .certificate-container {
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            padding: 40px;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }
        .border-frame {
            position: absolute;
            top: 20px; left: 20px; right: 20px; bottom: 20px;
            border: 2px solid #d4af37; /* Gold */
            border-radius: 20px;
            pointer-events: none;
        }
        .header {
            text-align: center;
            margin-top: 40px;
        }
        .title {
            font-size: 48px;
            font-weight: bold;
            color: #d4af37;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #94a3b8;
        }
        .content {
            text-align: center;
            margin-top: 60px;
        }
        .presented-to {
            font-size: 14px;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }
        .member-name {
            font-size: 42px;
            font-weight: bold;
            color: white;
            border-bottom: 1px solid #d4af37;
            display: inline-block;
            padding-bottom: 10px;
            margin-bottom: 30px;
            min-width: 400px;
        }
        .details {
            display: table;
            width: 80%;
            margin: 0 auto;
            margin-top: 40px;
        }
        .detail-row {
            display: table-row;
        }
        .detail-cell {
            display: table-cell;
            text-align: center;
            padding: 10px;
            width: 33%;
        }
        .label {
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            font-size: 16px;
            font-weight: bold;
            color: #d4af37;
        }
        .footer {
            position: absolute;
            bottom: 40px;
            width: 100%;
            text-align: center;
            color: #64748b;
            font-size: 10px;
            letter-spacing: 1px;
            left: 0;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 200px;
            color: white;
            opacity: 0.03;
            font-weight: bold;
            pointer-events: none;
            z-index: 0;
        }
        .signature {
            margin-top: 30px;
            border-top: 1px solid #64748b;
            width: 200px;
            margin: 30px auto 0;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="watermark">IBSEA</div>
        <div class="border-frame"></div>
        
        <div class="header">
            <div class="title">Certificate of Membership</div>
            <div class="subtitle">International Business & Strategic Economic Alliance</div>
        </div>

        <div class="content">
            <p class="presented-to">This is to certify that</p>
            <div class="member-name">{{ $user->name }}</div>
            <p class="presented-to">Is strictly verified as a strategic member of the alliance.</p>
        </div>

        <div class="details">
            <div class="detail-row">
                <div class="detail-cell">
                    <span class="label">Membership ID</span>
                    <span class="value">{{ $certificate_id }}</span>
                </div>
                <div class="detail-cell">
                    <span class="label">Date of Issue</span>
                    <span class="value">{{ $date }}</span>
                </div>
                <div class="detail-cell">
                    <span class="label">Chapter Region</span>
                    <span class="value">{{ $user->chapter ? $user->chapter->name : 'Global Member' }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="signature">Authorized Signature</div>
            <p style="margin-top: 20px;">IBSEA Global Secretariat • Official Document • Verify at ibsea.org</p>
        </div>
    </div>
</body>
</html>
