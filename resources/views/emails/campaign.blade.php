<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $emailSubject }}</title>
    <!--[if mso]>
    <noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
    <![endif]-->
    <style>
        @media only screen and (max-width: 620px) {
            .email-container { width: 100% !important; margin: auto !important; }
            .stack-column { display: block !important; width: 100% !important; max-width: 100% !important; direction: ltr !important; }
            .content-padding { padding: 30px 20px !important; }
            .mobile-full-width { padding: 0 !important; }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">

<!-- Preheader (hidden preview text for Gmail/Outlook) -->
<div style="display:none; max-height:0; overflow:hidden; font-size:1px; color:#f4f6f9;">
    {{ Str::limit(strip_tags($emailBody), 120) }}
</div>

<!-- Wrapper -->
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
    style="background-color:#f4f6f9; min-width:100%;">
    <tr>
        <td align="center" style="padding:24px 12px;" class="mobile-full-width">

            <!-- Email Card -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                style="width:100%; max-width:600px; background-color:#ffffff;"
                class="email-container">

                <!-- ═══ HEADER ═════════════════════════════════════════ -->
                <tr>
                    <td align="center" bgcolor="#0f172a"
                        style="padding:28px 40px; background-color:#0f172a;">
                        <img src="{{ asset('storage/email-logo.png') }}"
                             alt="IBSEA"
                             width="160"
                             height="auto"
                             border="0"
                             style="display:block; max-width:160px; font-size:14px; color:#ffffff;">
                    </td>
                </tr>

                <!-- ─── Accent stripe ──────────────────────────────── -->
                <tr>
                    <td bgcolor="#004a95" height="4" style="font-size:0; line-height:0; background-color:#004a95;">&nbsp;</td>
                </tr>

                <!-- ═══ BODY ═══════════════════════════════════════════ -->
                <tr>
                    <td style="padding:40px 40px 32px; font-size:15px; line-height:1.75;
                                color:#1e293b; font-family:Arial,Helvetica,sans-serif;">
                        {!! $emailBody !!}
                    </td>
                </tr>

                <!-- ═══ FOOTER DIVIDER ════════════════════════════════ -->
                <tr>
                    <td style="padding:0 40px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td height="1" bgcolor="#e5e7eb"
                                    style="background-color:#e5e7eb; font-size:0; line-height:0;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- ═══ FOOTER ════════════════════════════════════════ -->
                <tr>
                    <td bgcolor="#fafafa"
                        style="padding:24px 40px; font-size:11px; line-height:1.7;
                               color:#6b7280; background-color:#fafafa;
                               font-family:Arial,Helvetica,sans-serif;">

                        <strong style="color:#374151; font-size:12px;">
                            International Business Startup &amp; Entrepreneurs Association (IBSEA)
                        </strong><br><br>

                        🌐 <a href="https://ibsea.in" style="color:#2563eb; text-decoration:none;">www.ibsea.in</a>
                        &nbsp;&bull;&nbsp;
                        📞 +91-7651876071
                        &nbsp;&bull;&nbsp;
                        📧 <a href="mailto:contact@ibsea.in" style="color:#2563eb; text-decoration:none;">contact@ibsea.in</a><br>

                        <a href="https://ibsea.in/membership"
                           style="color:#2563eb; text-decoration:none;">Become a Member</a>
                        &nbsp;&bull;&nbsp;
                        <a href="https://youtu.be/zga-AnQO0PY"
                           style="color:#2563eb; text-decoration:none;">Watch Introduction</a><br><br>

                        &copy; {{ date('Y') }} IBSEA. All rights reserved.<br>
                        You received this email because you are a member or have interacted with IBSEA.<br>
                        If this was in error, contact
                        <a href="mailto:contact@ibsea.in"
                           style="color:#2563eb; text-decoration:none;">contact@ibsea.in</a>.
                    </td>
                </tr>

            </table>
            <!-- End Email Card -->

        </td>
    </tr>
</table>
<!-- End Wrapper -->

<!--[if mso | IE]>
<style type="text/css">
.email-container { width:600px !important; }
</style>
<![endif]-->

</body>
</html>
