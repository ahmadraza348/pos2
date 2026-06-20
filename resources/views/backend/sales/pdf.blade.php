<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            background: #f2f2f2;
            padding: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 6px;
            text-align: left;
        }

        .no-border td {
            border: none;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

<div class="header">
    <h2>Invoice</h2>
    <p>Order #{{ $order->order_number }}</p>
</div>

<!-- BILLING + SHIPPING -->
<table class="no-border">
    <tr>
        <td width="50%">
            <div class="section-title">Billing Info</div>
            <p>
                {{ $order->billing_first_name }} {{ $order->billing_last_name }}<br>
                {{ $order->billing_email }}<br>
                {{ $order->billing_phone }}<br>
                {{ $order->billing_address_1 }}<br>
                {{ $order->billing_address_2 }}<br>
                {{ $order->billing_city }} - {{ $order->billing_state }}<br>
                {{ $order->billing_country }}<br>
                {{ $order->billing_postcode }}<br>
                {{ $order->billing_company }}
            </p>
        </td>

        <td width="50%">
            <div class="section-title">Shipping Info</div>
            <p>
                {{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br>
                {{ $order->shipping_email }}<br>
                {{ $order->shipping_phone }}<br>
                {{ $order->shipping_address_1 }}<br>
                {{ $order->shipping_address_2 }}<br>
                {{ $order->shipping_city }} - {{ $order->shipping_state }}<br>
                {{ $order->shipping_country }}<br>
                {{ $order->shipping_postcode }}<br>
                {{ $order->shipping_company }}
            </p>
        </td>
    </tr>
</table>

<!-- ORDER INFO -->
<div class="section">
    <div class="section-title">Order Info</div>
    <table>
        <tr>
            <td><strong>Order Number</strong></td>
            <td>{{ $order->order_number }}</td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td>{{ $order->order_status }}</td>
        </tr>
        <tr>
            <td><strong>Payment Method</strong></td>
            <td>{{ $order->payment_method }}</td>
        </tr>
        <tr>
            <td><strong>Payment Status</strong></td>
            <td>{{ $order->payment_status }}</td>
        </tr>
        <tr>
            <td><strong>Order Date</strong></td>
            <td>{{ $order->created_at }}</td>
        </tr>
    </table>
</div>

<!-- PRODUCTS -->
<div class="section">
    <div class="section-title">Products</div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Color</th>
                <th>Attribute</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->color_name ?? '-' }}</td>
                <td>
                    {{ $item->attribute_name ?? '-' }} 
                    {{ $item->attribute_value ?? '' }}
                </td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->line_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- TOTALS -->
<div class="section">
    <div class="section-title">Summary</div>

    <table>
        <tr>
            <td>Subtotal</td>
            <td class="text-right">{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>Shipping</td>
            <td class="text-right">{{ number_format($order->shipping_charge, 2) }}</td>
        </tr>
        <tr>
            <td>Discount</td>
            <td class="text-right">{{ number_format($order->discount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total</strong></td>
            <td class="text-right"><strong>{{ number_format($order->total_amount, 2) }}</strong></td>
        </tr>
    </table>
</div>

<!-- NOTE -->
@if($order->order_note)
<div class="section">
    <div class="section-title">Order Note</div>
    <p>{{ $order->order_note }}</p>
</div>
@endif

</body>
</html>