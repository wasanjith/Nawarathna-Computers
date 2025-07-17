@php
    $logoPath = asset('photos/logo.png'); // Use your actual logo path
    $customer = $customer ?? null;
    $device = $device ?? null;
    $checklist = $checklist ?? null;
    $total = $record->total ?? 0;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $record->invoice_number }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
        body {
            background: #f4f6fb;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            background: #fff;
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            border-radius: 10px;
            padding: 0 0 32px 0;
            position: relative;
        }
        .header {
            background: #222;
            color: #fff;
            padding: 32px 40px 16px 40px;
            border-radius: 10px 10px 0 0;
            display: flex;
            align-items: center;
        }
        .header img {
            height: 70px;
            margin-right: 32px;
        }
        .header .company {
            font-size: 2.2rem;
            font-weight: bold;
            letter-spacing: 0.1em;
        }
        .header .contact {
            margin-left: auto;
            text-align: right;
            font-size: 1rem;
            color: #ffe082;
        }
        .invoice-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 32px 40px 0 40px;
        }
        .invoice-title {
            font-size: 2.2rem;
            color: #222;
            font-weight: 600;
            letter-spacing: 0.1em;
        }
        .invoice-meta {
            text-align: right;
            font-size: 1rem;
            color: #444;
        }
        .section {
            margin-bottom: 24px;
            padding: 0 40px;
        }
        .section-title {
            font-size: 1.1rem;
            color: #222;
            font-weight: bold;
            background: #ffe082;
            padding: 6px 16px;
            border-radius: 5px 5px 0 0;
            margin-bottom: 0;
            display: inline-block;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            background: #fafafa;
        }
        .details-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #e0e7ef;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 1rem;
        }
        .items-table th, .items-table td {
            border: 1px solid #ffe082;
            padding: 10px 12px;
            text-align: left;
        }
        .items-table th {
            background: #ffe082;
            color: #222;
            font-weight: bold;
        }
        .items-table tr:nth-child(even) td {
            background: #f7fbff;
        }
        .total-row td {
            font-weight: bold;
            color: #222;
            background: #ffe082;
        }
        .print-btn {
            position: absolute;
            top: 32px;
            right: 40px;
            background: #ffe082;
            color: #222;
            border: none;
            border-radius: 5px;
            padding: 10px 24px;
            font-size: 1rem;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }
        .print-btn:hover {
            background: #ffd54f;
        }
        .footer {
            padding: 24px 40px 0 40px;
            color: #888;
            font-size: 0.95rem;
            text-align: left;
        }
        .signature {
            margin-top: 40px;
            text-align: right;
            padding-right: 40px;
        }
        .signature .name {
            font-weight: bold;
            font-size: 1.1rem;
            margin-top: 40px;
        }
        .signature .role {
            font-size: 0.95rem;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <button class="print-btn no-print" onclick="window.print()">Print Invoice</button>
        <div class="header">
            <img src="{{ $logoPath }}" alt="Logo">
            <div>
                <div class="company">NAWARATHNA<br>Cellular & Computer Systems</div>
                <div style="font-size:1.1rem;font-weight:600;margin-top:2px;">No 339, Colombo Road, Pilimathalawa</div>
                <div style="font-size:1rem;">thences@gmail.com | www.nccs.lk</div>
                <div style="font-size:1rem;">081-2577370, 0777-977070, 0777-535121</div>
            </div>
            <div class="contact">
                <!-- Optionally add more contact info here -->
            </div>
        </div>
        <div class="invoice-title-row">
            <div class="invoice-title">INVOICE</div>
            <div class="invoice-meta">
                <div>Invoice No: <b>{{ $record->invoice_number }}</b></div>
                <div>Date: <b>{{ $record->created_at->format('Y-m-d') }}</b></div>
            </div>
        </div>
        <div class="section" style="margin-top:16px;">
            <span class="section-title">Billed To</span>
            <table class="details-table">
                <tr><td>Name:</td><td>{{ $customer->name ?? '-' }}</td></tr>
                <tr><td>Phone:</td><td>{{ $customer->phone ?? '-' }}</td></tr>
                <tr><td>City:</td><td>{{ $customer->city ?? '-' }}</td></tr>
            </table>
        </div>
        <div class="section">
            <span class="section-title">Device Details</span>
            <table class="details-table">
                <tr><td>Type:</td><td>{{ $device->device_type ?? '-' }}</td></tr>
                <tr><td>Brand:</td><td>{{ $device->brand ?? '-' }}</td></tr>
                <tr><td>Model:</td><td>{{ $device->model ?? '-' }}</td></tr>
                <tr><td>Slug:</td><td>{{ $device->slug ?? '-' }}</td></tr>
            </table>
        </div>
        <div class="section">
            <span class="section-title">Replaced Items</span>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item Description</th>
                        <th>Brand</th>
                        <th>Price (Rs.)</th>
                        <th>Qty</th>
                        <th>Total (Rs.)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subTotal = 0; @endphp
                    @forelse(($record->replaced_items ?? []) as $item)
                        @php
                            $qty = 1;
                            $price = floatval($item['price'] ?? 0);
                            $lineTotal = $price * $qty;
                            $subTotal += $lineTotal;
                        @endphp
                        <tr>
                            <td>{{ $item['item'] ?? '-' }}</td>
                            <td>{{ $item['brand'] ?? '-' }}</td>
                            <td>{{ number_format($price, 2) }}</td>
                            <td>1</td>
                            <td>{{ number_format($lineTotal, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;color:#aaa;">No replaced items</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="section">
            <span class="section-title">Summary</span>
            <table class="details-table" style="margin-bottom:0;">
                <tr><td>Repair Cost:</td><td>Rs. {{ number_format($record->repair_cost ?? 0, 2) }}</td></tr>
                <tr><td>Sub Total:</td><td>Rs. {{ number_format($subTotal + ($record->repair_cost ?? 0), 2) }}</td></tr>
                <tr class="total-row">
                    <td style="font-weight:bold;">GRAND TOTAL</td>
                    <td style="font-weight:bold;">Rs. {{ number_format($total, 2) }}</td>
                </tr>
                <tr><td>Payment Status:</td><td>{{ ucfirst($record->payment_status) }}</td></tr>
            </table>
        </div>
        <div class="footer">
            <b>Thank you for your business!</b><br>
            <span>TERMS: Payment due upon receipt. Please contact us for any questions regarding this invoice.</span>
        </div>
        <div class="signature">
            <div class="role">Authorized Signature</div>
            <div class="name">Nawarathna Computers</div>
        </div>
    </div>
</body>
</html> 