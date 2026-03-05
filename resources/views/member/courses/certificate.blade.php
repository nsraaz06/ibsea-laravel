<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Institutional Certificate - IBSEA</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            color: #1e293b;
        }
        .certificate-container {
            width: 100%;
            height: 100vh;
            padding: 60px;
            box-sizing: border-box;
            background: #fff;
            position: relative;
            border: 20px solid #0f172a; /* Navy Border */
        }
        .inner-border {
            border: 2px solid #e2e8f0;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px;
            position: relative;
        }
        .gold-seal {
            width: 120px;
            height: 120px;
            position: absolute;
            top: -60px;
            left: 50%;
            margin-left: -60px;
            background: #f59e0b; /* Gold */
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
        .header {
            margin-bottom: 60px;
        }
        .logo-text {
            font-size: 32px;
            font-weight: 900;
            letter-spacing: -1px;
            color: #0f172a;
            margin-bottom: 10px;
        }
        .award-text {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 5px;
            color: #64748b;
        }
        .certificate-title {
            font-size: 56px;
            font-weight: 900;
            color: #0f172a;
            margin: 20px 0;
            letter-spacing: -2px;
        }
        .recipient-name {
            font-size: 38px;
            font-weight: 700;
            color: #f59e0b;
            margin: 30px 0;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 15px;
            display: inline-block;
            min-width: 400px;
        }
        .description {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 60px;
            color: #475569;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        .footer {
            margin-top: auto;
            width: 100%;
            display: table;
        }
        .signature-block {
            display: table-cell;
            text-align: center;
            width: 33.33%;
        }
        .signature-line {
            border-top: 1px solid #cbd5e1;
            width: 180px;
            margin: 0 auto 10px;
        }
        .signature-name {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0f172a;
        }
        .signature-title {
            font-size: 10px;
            color: #94a3b8;
        }
        .date-id {
            margin-top: 40px;
            font-size: 10px;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="inner-border">
            <div class="header">
                <div class="logo-text">IBSEA</div>
                <div class="award-text">International Business Strategic Alliance</div>
            </div>

            <div class="award-text">Certificate of Completion</div>
            <h1 class="certificate-title">Institutional Protocol Mastery</h1>

            <p class="description">This is to certify that the following strategic partner has successfully completed the prescribed curriculum and demonstrated proficiency in:</p>

            <div class="recipient-name">{{ $member_name }}</div>

            <p class="description" style="font-weight: 800; color: #0f172a;">{{ $course_title }}</p>

            <div class="footer">
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-name">Strategic Council</div>
                    <div class="signature-title">Board of Directors</div>
                </div>
                <div class="signature-block">
                    <!-- Space for Seal -->
                </div>
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-name">Academic Board</div>
                    <div class="signature-title">Verification Authority</div>
                </div>
            </div>

            <div class="date-id">
                Issued on: {{ $date }} | Verification ID: {{ $verification_id }}
            </div>
        </div>
    </div>
</body>
</html>
