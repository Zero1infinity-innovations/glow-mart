{{-- <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .invoice-box {
            max-width: 280px;
            /* approx. 3 inches (80mm = 3.15 inches) */
            margin: auto;
            padding: 10px;
            border: none;
            /* optional: remove border for thermal printers */
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .header {
            text-align: center;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .header h2 {
            font-size: 16px;
            margin-bottom: 2px;
        }

        .header small {
            font-size: 10px;
            display: block;
        }

        .invoice-info {
            margin-bottom: 10px;
            width: 100%;
            font-size: 11px;
        }

        .invoice-info td {
            padding: 2px 0;
            vertical-align: top;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table th,
        .table td {
            border: 1px dashed #ddd;
            padding: 3px;
            font-size: 11px;
            text-align: center;
        }

        .table th {
            background: #f0f0f0;
        }

        .totals {
            width: 100%;
            margin-top: 10px;
            font-size: 11px;
        }

        .totals td {
            padding: 2px;
        }

        .signature {
            margin-top: 20px;
            text-align: right;
            font-size: 11px;
        }

        .footer-note {
            margin-top: 15px;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }

        .terms {
            margin-top: 10px;
            font-size: 10px;
        }
    </style>

</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <h2>Glowmart Smart Retail</h2>
            <small>P.No. 68 - Maa Kripa Apartment, Near Shyam Nagar Bypass, New Azad Nagar, Kanpur, Uttar Pradesh -
                208011</small>
            <small>Phone: 8840610761 | Email: realglowmart@gmail.com</small>
            <small>GSTIN: 09KOXPK8285J1ZJ</small>
        </div>

        <h3 class="text-center">SALE INVOICE</h3>

        <table class="invoice-info">
            <tr>
                <td>
                    <strong>Invoice #:</strong> INV - {{ $invoiceId }}<br>
                    <strong>Order #:</strong> {{ $order->order_number }}<br>
                    <strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <strong>Customer:</strong> {{ $order->user->name }}<br>
                    <strong>Mobile:</strong> {{ $order->user->mobile }}<br>
                    <strong>Address:</strong> {{ $order->user->address }}, {{ $order->user->city }},
                    {{ $order->user->state }} - {{ $order->user->pincode }}
                </td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>MRP</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->product->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹{{ number_format($item->product->mrp_price, 2) }}</td>
                        <td>₹{{ number_format($item->product->sale_price, 2) }}</td>
                        <td>₹{{ number_format($item->quantity * $item->product->sale_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals">
            <tr>
                <td style="text-align:right"><strong>Sub Total:</strong></td>
                <td style="text-align:right">₹{{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align:right"><strong>Total Payable:</strong></td>
                <td style="text-align:right"><strong>₹{{ number_format($total, 2) }}</strong></td>
            </tr>
            <tr>
                <td style="text-align:right"><strong>Received:</strong></td>
                <td style="text-align:right">₹{{ number_format($receivedAmount ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align:right"><strong>Balance:</strong></td>
                <td style="text-align:right">₹{{ number_format($total - ($receivedAmount ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td style="text-align:right"><strong>You saved:</strong></td>
                <td style="text-align:right">₹{{ number_format($totalSavings ?? 0, 2) }}</td>
            </tr>
        </table>

        <div class="signature">
            For GLOWMART<br><br><br>
            (Signatory)
        </div>

        <div class="footer-note">
            Thank you for your Business
        </div>

        <div class="terms">
            <strong>Terms & Conditions:</strong><br>
            All goods remain the property of GLOWMART until full payment has been received.
        </div>
    </div>
</body>

</html> --}}


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .invoice-box {
            max-width: 280px;
            margin: auto;
            padding: 10px;
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .header {
            text-align: center;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .header h2 {
            font-size: 16px;
            margin-bottom: 2px;
        }

        .header small {
            font-size: 10px;
            display: block;
        }

        .invoice-info {
            margin-bottom: 10px;
            width: 100%;
            font-size: 11px;
        }

        .invoice-info td {
            padding: 2px 0;
            vertical-align: top;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table th,
        .table td {
            border: 1px dashed #ddd;
            padding: 3px;
            font-size: 11px;
            text-align: center;
        }

        .table th {
            background: #f0f0f0;
        }

        .totals {
            width: 100%;
            margin-top: 10px;
            font-size: 11px;
        }

        .totals td {
            padding: 2px;
        }

        .signature {
            margin-top: 20px;
            text-align: right;
            font-size: 11px;
        }

        .footer-note {
            margin-top: 15px;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }

        .terms {
            margin-top: 10px;
            font-size: 10px;
        }

        small {
            font-size: 10px;
            display: block;
            text-align: left;
        }
    </style>

</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <h2>Glowmart Smart Retail</h2>
            <small>P.No. 68 - Maa Kripa Apartment, Near Shyam Nagar Bypass, New Azad Nagar, Kanpur, Uttar Pradesh -
                208011</small>
            <small>Phone: 8840610761 | Email: realglowmart@gmail.com</small>
            <small>GSTIN: 09KOXPK8285J1ZJ</small>
        </div>

        <h3 class="text-center">SALE INVOICE</h3>

        <table class="invoice-info">
            <tr>
                <td>
                    <strong>Invoice #:</strong> INV - {{ $invoiceId }}<br>
                    <strong>Order #:</strong> {{ $order->order_number }}<br>
                    <strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}
                </td>
                <td>
                    <strong>Customer:</strong> {{ $order->user->name ?? $order->username }}<br>
                    <strong>Mobile:</strong> {{ $order->user->mobile ?? '' }}<br>
                    <strong>Address:</strong> {{ $order->user->address?? $order->shipping_address }}, {{ $order->user->city?? '' }},
                    {{ $order->user->state?? '' }} - {{ $order->user->pincode?? '' }}
                </td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>MRP</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($order->orderItems as $item)
                    @php
                        $variant = $variants[$item->sku] ?? null;
                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            {{ $item->product->product_name }}
                            @if ($variant)
                                <small>{{ $variant->size }}</small>
                            @endif
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹{{ number_format($item->product->mrp_price, 2) }}/UNIT</td>
                        <td>₹{{ number_format($item->price, 2) }}</td>
                        <td>₹{{ number_format($item->quantity * $item->product->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals">
            <tr>
                <td style="text-align:right"><strong>Sub Total:</strong></td>
                <td style="text-align:right">₹{{ number_format($subtotal, 2) }}</td>
            </tr>
            @if ($taxAmount > 0)
                <tr>
                    <td style="text-align:right"><strong>Tax ({{ $taxPercentage }}%):</strong></td>
                    <td style="text-align:right">₹{{ number_format($taxAmount, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td style="text-align:right"><strong>Total Payable:</strong></td>
                <td style="text-align:right"><strong>₹{{ number_format($total, 2) }}</strong></td>
            </tr>
            <tr>
                <td style="text-align:right"><strong>Received:</strong></td>
                <td style="text-align:right">₹{{ number_format($receivedAmount ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align:right"><strong>Balance:</strong></td>
                <td style="text-align:right">₹{{ number_format($total - ($receivedAmount ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td style="text-align:right"><strong>You saved:</strong></td>
                <td style="text-align:right">₹{{ number_format($totalSavings ?? 0, 2) }}</td>
            </tr>
        </table>

        <div class="signature">
            For GLOWMART<br><br><br>
            (Signatory)
        </div>

        <div class="footer-note">
            Thank you for your Business
        </div>

        <div class="terms">
            <strong>Terms & Conditions:</strong><br>
            All goods remain the property of GLOWMART until full payment has been received.
        </div>
    </div>
</body>

</html>
