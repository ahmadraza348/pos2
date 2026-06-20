<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - {{ $order->order_number }}</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        .email-container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .banner { width: 100%; height: 200px; object-fit: cover; }
        .content { padding: 40px 30px; text-align: center; }
        .order-number { background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 50px; display: inline-block; font-weight: bold; margin: 20px 0; font-size: 14px; }
        .cta-button { background-color: #7367f0; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block; margin-top: 25px; }
        .footer { background: #f8fafc; padding: 30px; text-align: center; color: #94a3b8; font-size: 13px; }
        .social-icons { margin-bottom: 20px; }
        .social-icons a { margin: 0 10px; text-decoration: none; }
        .social-icons img { width: 24px; opacity: 0.6; }
    </style>
</head>
<body>
    <div class="email-container">
        <img src="https://images.unsplash.com/photo-1557821552-17105176677c?auto=format&fit=crop&w=600&q=80" alt="Order Confirmed" class="banner">

        <div class="content">
            <h1 style="color: #1e293b; margin: 0; font-size: 28px;">Success!</h1>
            <p style="color: #64748b; font-size: 16px; line-height: 1.6; margin-top: 10px;">
                Hello <strong>{{ $order->billing_first_name }}</strong>,<br>
                Your order has been placed successfully. We’re currently getting everything ready for you!
            </p>

            <div class="order-number">
                ORDER #{{ $order->order_number }}
            </div>

            <p style="color: #1e293b; font-size: 18px; font-weight: 600;">
                Total Amount: RS {{ number_format($order->total_amount) }}
            </p>

            <p style="color: #94a3b8; font-size: 14px; margin-top: 20px;">
                For your records, we have attached your formal invoice as a PDF to this email.
            </p>

            <a href="{{ url('/account/orders/'.$order->id) }}" class="cta-button">
                Track My Order
            </a>
        </div>

        <div class="footer">
            <div class="social-icons">
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="FB"></a>
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="IG"></a>
                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/5968/5968830.png" alt="X"></a>
            </div>
            <p style="margin: 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p style="margin: 5px 0;">Gojra, Punjab, Pakistan</p>
        </div>
    </div>
</body>
</html>