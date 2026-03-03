<!DOCTYPE html>
<html>
<head>
    <title>Institutional Secure Gateway | IBSEA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background: #f8fafc; font-family: system-ui, -apple-system, sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0;">
    <div style="text-align: center; padding: 2rem; background: white; border-radius: 2rem; shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <div style="color: #004a95; font-weight: 800; font-size: 1.5rem; margin-bottom: 0.5rem;">IBSEA Institutional Gateway</div>
        <p style="color: #64748b; font-size: 0.875rem; font-weight: 600;">Authenticating Secure Connection...</p>
        
        <button id="rzp-button1" style="display: none;"></button>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <form name='razorpayform' action="{{ route('payment.verify') }}" method="GET">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
        <input type="hidden" name="order_id" value="{{ $order_id }}">
        <input type="hidden" name="gateway" value="razorpay">
    </form>

    <script>
    var options = {
        "key": "{{ $key_id }}",
        "amount": "{{ $amount }}",
        "currency": "{{ $currency }}",
        "name": "IBSEA",
        "description": "{{ $item_name }}",
        "image": "https://ui-avatars.com/api/?name=IBSEA&background=004a95&color=fff",
        "order_id": "{{ $razorpay_order_id }}",
        "handler": function (response){
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.forms['razorpayform'].submit();
        },
        "prefill": {
            "name": "{{ $user_name }}",
            "email": "{{ $user_email }}",
            "contact": "{{ $user_mobile }}"
        },
        "theme": {
            "color": "#004a95"
        },
        "modal": {
            "ondismiss": function(){
                window.location.href = "{{ route('home') }}?error=Payment+Cancelled";
            }
        }
    };
    var rzp1 = new Razorpay(options);
    window.onload = function(){
        rzp1.open();
    };
    </script>
</body>
</html>
