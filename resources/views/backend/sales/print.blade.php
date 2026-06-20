<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }

        h2, h3 {
            margin: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            background: #eee;
            padding: 6px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
        }

        .no-border td {
            border: none;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
        }

        button {
            margin-bottom: 15px;
            padding: 6px 12px;
            cursor: pointer;
        }

        @media print {
            button {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>

<button onclick="window.print()">Print Invoice</button>

<div class="header">
    <h2>Raza Mall</h2>
    <p>Invoice #{{ $order->order_number }}</p>
    <p>Date: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</p>
</div>

<!-- BILLING + SHIPPING -->
<div class="section">
    <table class="no-border">
        <tr>
            <td width="50%">
                <div class="section-title">Billing Info</div>
                <p>
                    {{ $order->billing_first_name ?? '' }} {{ $order->billing_last_name ?? '' }}<br>
                    {{ $order->billing_email ?? '-' }}<br>
                    {{ $order->billing_phone ?? '-' }}<br>
                    {{ $order->billing_address_1 ?? '' }}<br>
                    {{ $order->billing_address_2 ?? '' }}<br>
                    {{ $order->billing_city ?? '' }} {{ $order->billing_state ?? '' }}<br>
                    {{ $order->billing_country ?? '' }}<br>
                    {{ $order->billing_postcode ?? '' }}
                </p>
            </td>

            <td width="50%">
                <div class="section-title">Shipping Info</div>
                <p>
                    {{ $order->shipping_first_name ?? '' }} {{ $order->shipping_last_name ?? '' }}<br>
                    {{ $order->shipping_email ?? '-' }}<br>
                    {{ $order->shipping_phone ?? '-' }}<br>
                    {{ $order->shipping_address_1 ?? '' }}<br>
                    {{ $order->shipping_address_2 ?? '' }}<br>
                    {{ $order->shipping_city ?? '' }} {{ $order->shipping_state ?? '' }}<br>
                    {{ $order->shipping_country ?? '' }}<br>
                    {{ $order->shipping_postcode ?? '' }}
                </p>
            </td>
        </tr>
    </table>
</div>

<!-- ORDER INFO -->
<div class="section">
    <div class="section-title">Order Info</div>
    <table>
        <tr>
            <td><strong>Status</strong></td>
            <td>{{ ucfirst($order->order_status) }}</td>
        </tr>
        <tr>
            <td><strong>Payment Method</strong></td>
            <td>{{ $order->payment_method ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Payment Status</strong></td>
            <td>{{ ucfirst($order->payment_status) }}</td>
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
                <th>Price (Rs)</th>
                <th>Total (Rs)</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->color_name ?? '-' }}</td>
                <td>{{ $item->attribute_name ?? '-' }} {{ $item->attribute_value ?? '' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 0) }}</td>
                <td>{{ number_format($item->line_total, 0) }}</td>
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
            <td class="text-right">Rs {{ number_format($order->subtotal, 0) }}</td>
        </tr>
        <tr>
            <td>Shipping</td>
            <td class="text-right">Rs {{ number_format($order->shipping_charge, 0) }}</td>
        </tr>
        <tr>
            <td>Discount</td>
            <td class="text-right">Rs {{ number_format($order->discount, 0) }}</td>
        </tr>
        <tr class="total-row">
            <td>Total</td>
            <td class="text-right">Rs {{ number_format($order->total_amount, 0) }}</td>
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
<script>
    window.onload = function() {
        // Adding a slight delay ensures the browser has rendered the styles
        setTimeout(function() {
            window.print();
        }, 500);

        // Detect when the print dialog is closed
        window.onafterprint = function() {
            window.close();
        };
    };
</script>
</body>
</html>