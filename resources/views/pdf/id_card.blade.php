<!DOCTYPE html>
<html>
<head>
    <title>Member ID Card</title>
    <style>
        @page { margin: 0px; }
        body { margin: 0px; font-family: 'Helvetica', sans-serif; background-color: #fff; }
        .card-container {
            width: 100%;
            height: 100%;
            background: #0f172a;
            color: white;
            position: relative;
            overflow: hidden;
            display: flex;
        }
        .left-panel {
            width: 35%;
            background: #1e293b;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #d4af37;
            object-fit: cover;
            background: #334155;
            margin-bottom: 10px;
        }
        .right-panel {
            width: 65%;
            padding: 20px;
            position: relative;
        }
        .logo {
            font-size: 18px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .org-name {
            font-size: 8px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .label {
            font-size: 6px;
            color: #64748b;
            text-transform: uppercase;
            display: block;
        }
        .value {
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .id-number {
             font-size: 8px;
             color: #d4af37;
             margin-top: 5px;
             letter-spacing: 1px;
        }
        .qr-placeholder {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: black;
            font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="left-panel">
            <!-- Checking if image is local path or URL, handling handled by dompdf ideally local path -->
            <img src="{{ public_path($user->profile_image ?? 'default-profile.png') }}" class="profile-img" onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='">
            <div class="id-number">ID: {{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>
        <div class="right-panel">
            <div class="logo">IBSEA</div>
            <div class="org-name">International Business & Strategic Economic Alliance</div>
            
            <div class="info-row">
                <span class="label">Name</span>
                <span class="value">{{ $user->name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Designation</span>
                <span class="value">{{ $user->profession ?? 'Member' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Valid Until</span>
                <span class="value">{{ $valid_until }}</span>
            </div>

            <div class="qr-placeholder">
                QR
            </div>
        </div>
    </div>
</body>
</html>
