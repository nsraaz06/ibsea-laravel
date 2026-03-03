🥇 1. Use Absolute Positioning (For Certificates)

For certificates, NEVER rely on:

flex

grid

floats

Instead use:

position: absolute;
top: ___px;
left: ___px;

Example:

<div style="position:absolute; top:350px; left:200px;">
    {{ $name }}
</div>

Certificates are fixed-layout documents — absolute positioning works best.

🥇 2. Use Fixed Canvas Size

Set exact page size:

@page {
    size: A4 landscape;
    margin: 0;
}

body {
    width: 1123px;
    height: 794px;
    margin: 0;
}

Or exact px dimensions matching your background image.

Never rely on auto width.

🥇 3. Use Background Image Instead of Many Elements

Best practice:

✔ Use ONE certificate background image
✔ Overlay only dynamic fields (name, date, number)

Example:

<img src="{{ public_path('cert-bg.png') }}" 
     style="position:absolute; top:0; left:0; width:100%;">

Then only place:

Name

Certificate No

Date

Signature

This avoids layout break.

🥇 4. Always Use public_path() for Images

Wrong:

<img src="/images/signature.png">

Correct:

<img src="{{ public_path('images/signature.png') }}">

PDF engines can’t read browser URLs.

🥇 5. Embed Fonts Properly

If font changes in PDF:

Download font .ttf

Place in public/fonts

Use:

@font-face {
    font-family: 'GreatFont';
    src: url("{{ public_path('fonts/greatfont.ttf') }}") format('truetype');
}

PDF generators do NOT reliably load Google Fonts.

🥇 6. Avoid These CSS Properties

DO NOT USE:

flex

grid

transform

position: sticky

z-index heavy stacking

vh / vw units

Use only:

px

absolute positioning

simple margins

🔥 BEST ENGINE FOR PERFECT OUTPUT

If layout accuracy is critical:

🥇 Use Headless Chrome (Best Option)

Instead of DOMPDF.

Tools:

spatie/browsershot

Puppeteer

Headless Chrome renders exactly like browser.

Much more accurate than DOMPDF.

🏆 Gold Standard Setup (Professional)

If building production-grade certificate system:

✔ A4 Landscape fixed
✔ Background image
✔ Absolute positioned dynamic text
✔ Embedded fonts
✔ Chrome-based renderer
✔ Store generated PDF after creation

📌 Example Ideal Certificate Structure
<div style="position:relative; width:1123px; height:794px;">

    <img src="{{ public_path('cert-bg.png') }}" 
         style="position:absolute; top:0; left:0; width:1123px;">

    <div style="position:absolute; top:380px; left:0; width:100%; text-align:center; font-size:48px;">
        {{ $name }}
    </div>

    <div style="position:absolute; top:520px; left:200px;">
        Certificate No: {{ $certificate_no }}
    </div>

</div>

That will NEVER shift.

💡 Extra Stability Tip

Generate PDF like this:

$pdf = Pdf::loadView('certificate.template', $data)
          ->setPaper('a4', 'landscape');

Always match orientation with design.