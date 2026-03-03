<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to Secure Checkout...</title>
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
</head>
<body style="background: #f8fafc; display: flex; align-items: center; justify-content: center; height: 100vh; font-family: sans-serif; margin: 0;">
    <div style="text-align: center; padding: 40px; background: white; border-radius: 24px; shadow: 0 10px 25px -5px rgba(0,0,0,0.1);">
        <h2 style="color: #0f172a; margin-bottom: 8px;">Initializing Secure Payment</h2>
        <p style="color: #64748b; font-size: 14px;">Please do not refresh or close this window.</p>
        <div style="margin-top: 24px;">
            <svg style="animation: spin 1s linear infinite; height: 32px; width: 32px; color: #f97316;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path style="opacity: 0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    <style>
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>

    <script>
        const cashfree = Cashfree({
            mode: "{{ $mode }}"
        });
        cashfree.checkout({
            paymentSessionId: "{{ $session_id }}",
            redirectTarget: "_self"
        });
    </script>
</body>
</html>
