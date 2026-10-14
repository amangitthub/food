@php
    $primary = '#00813d';  
    $accent  = '#ffb936';   
    $red     = '#d12525';  
    $dark    = '#212121';   
    $text    = '#5c5c5b';   
    $line    = '#d9d9d9';   
    $cream   = '#f4f1ea';   
    $muted   = '#8a8a86';
    $onGreen = '#d6efe1';   

    /* ---------- Payment info ---------- */
    $pay = $order->payment;
    $payRaw = strtolower((string) ($pay->status ?? 'pending'));
    $payLabel = [
        'success' => 'Paid', 'paid' => 'Paid', 'pending' => 'Pending',
        'failed' => 'Failed', 'refunded' => 'Refunded',
    ][$payRaw] ?? ucfirst($payRaw);

    // Tag colours (background, text) for the payment badge
    $tagColors = [
        'Paid'     => ['#dff3e8', $primary],
        'Pending'  => ['#fff0cc', '#8a5a00'],
        'Failed'   => ['#f9dada', $red],
        'Refunded' => ['#ececec', '#444444'],
    ];
    [$tagBg, $tagFg] = $tagColors[$payLabel] ?? ['#ececec', '#444444'];

    $method = strtoupper(str_replace('_', ' ', (string) ($pay->method ?? 'cash')));
    $paidAmount = (float) ($pay->amount ?? $order->total);

    $details = [
        ['Payment Method', $method],
        ['Payment Status', $payLabel],
        ['Amount', '₹' . number_format($paidAmount, 2)],
    ];
    if (!empty($pay->gateway))            { $details[] = ['Gateway', ucfirst($pay->gateway)]; }
    if (!empty($pay->gateway_order_id))   { $details[] = ['Gateway Order ID', $pay->gateway_order_id]; }
    if (!empty($pay->gateway_payment_id)) { $details[] = ['Payment ID', $pay->gateway_payment_id]; }
    $detailRows = array_chunk($details, 2);

    /* ---------- Taxes ---------- */
    $cgstAmount = $order->cgst_amount ?? $order->cgst ?? 0;
    $sgstAmount = $order->sgst_amount ?? $order->sgst ?? 0;
    $igstAmount = $order->igst_amount ?? $order->igst ?? 0;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Receipt - {{ $order->order_no }}</title>

    <style>
        @page { margin: 22px; }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: {{ $text }};
            font-size: 12px;
            line-height: 1.55;
            margin: 0;
        }

        table { border-collapse: collapse; }
        .right { text-align: right; }

        .label {
            color: {{ $muted }}; font-size: 9px; font-weight: bold;
            letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 7px;
        }

        .items th {
            color: {{ $primary }}; font-size: 9px; font-weight: bold; letter-spacing: 1.5px;
            text-transform: uppercase; text-align: left; padding: 0 0 9px;
            border-bottom: 2px solid {{ $primary }};
        }
        .items td { padding: 12px 0; border-bottom: 1px dotted {{ $line }}; vertical-align: top; color: {{ $dark }}; }

        .pay td { padding: 10px 12px; font-size: 11px; border-bottom: 1px solid {{ $line }}; color: {{ $dark }}; }
    </style>
</head>
<body>

<table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid {{ $line }}">
<tr><td style="padding:0">

    {{-- ================= HEADER ================= --}}
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="{{ $primary }}" style="background:{{ $primary }}">
        <tr>
            <td bgcolor="{{ $primary }}" style="background:{{ $primary }}; padding:28px 30px; vertical-align:middle">
                <div style="color:#ffffff; font-size:28px; font-weight:bold; letter-spacing:3px">FOODKING</div>
                <div style="color:{{ $onGreen }}; font-size:9px; letter-spacing:1.5px; margin-top:4px">
                    YOUR DELICIOUS MOMENTS, DELIVERED
                </div>
            </td>
            <td bgcolor="{{ $primary }}" class="right" style="background:{{ $primary }}; padding:28px 30px; vertical-align:middle">
                <div style="color:#ffffff; font-size:32px; font-weight:bold; letter-spacing:4px">RECEIPT</div>
                <div style="color:{{ $accent }}; font-size:11px; font-weight:bold; margin-top:5px"># {{ $order->order_no }}</div>
            </td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="{{ $accent }}">
        <tr><td bgcolor="{{ $accent }}" style="background:{{ $accent }}; height:5px; line-height:5px; font-size:1px">&nbsp;</td></tr>
    </table>

    {{-- ================= BILL TO / ORDER DETAILS ================= --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="border-bottom:1px solid {{ $line }}">
        <tr>
            <td width="50%" style="padding:24px 30px; vertical-align:top">
                <div class="label">Bill to</div>
                <div style="font-size:16px; font-weight:bold; color:{{ $dark }}; margin-bottom:4px">
                    {{ $address->name ?? $customer->name ?? 'Customer' }}
                </div>
                <div style="color:{{ $text }}">{{ $customer->email ?? 'Email not available' }}</div>
                <div style="color:{{ $text }}">{{ $address->mobile ?? 'Phone not available' }}</div>

                <div class="label" style="margin-top:18px">Deliver to</div>
                <div style="color:{{ $dark }}">
                    @if ($address)
                        {{ $address->address }}<br>
                        @if ($address->city){{ $address->city }}, @endif
                        @if ($address->state){{ $address->state }}@endif
                        @if ($address->pincode) - {{ $address->pincode }}@endif
                        <br>{{ $address->country ?? 'India' }}
                    @else
                        Delivery address is not available.
                    @endif
                </div>
            </td>

            <td width="50%" style="padding:24px 30px; vertical-align:top; border-left:1px solid {{ $line }}">
                <div class="label">Order details</div>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding:3px 0; color:{{ $muted }}; width:36%">Order No.</td>
                        <td style="padding:3px 0; color:{{ $dark }}; font-weight:bold">{{ $order->order_no }}</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 0; color:{{ $muted }}">Date</td>
                        <td style="padding:3px 0; color:{{ $dark }}">
                            {{ $order->created_at
                                ? \Illuminate\Support\Carbon::parse($order->created_at)->format('d M Y, h:i A')
                                : 'Not available' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 0; color:{{ $muted }}">Payment</td>
                        <td style="padding:3px 0; color:{{ $dark }}">{{ $payLabel }}</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 0; color:{{ $muted }}">Method</td>
                        <td style="padding:3px 0; color:{{ $dark }}">{{ $method }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- ================= ITEMS ================= --}}
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr><td style="padding:24px 30px 20px">
            <table class="items" width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th width="8%">#</th>
                        <th>Description</th>
                        <th class="right" width="16%">Price</th>
                        <th class="right" width="10%">Qty</th>
                        <th class="right" width="18%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order->items as $item)
                        @php
                            $itemPrice = (float) ($item->price ?? 0);
                            $itemQty = (int) ($item->quantity ?? 1);
                            $itemAmount = (float) ($item->subtotal ?? ($itemPrice * $itemQty));
                        @endphp
                        <tr>
                            <td style="color:{{ $muted }}">{{ sprintf('%02d', $loop->iteration) }}</td>
                            <td style="font-weight:bold">{{ $item->product_name ?? 'Food Product' }}</td>
                            <td class="right">₹{{ number_format($itemPrice, 2) }}</td>
                            <td class="right">{{ $itemQty }}</td>
                            <td class="right" style="font-weight:bold">₹{{ number_format($itemAmount, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="color:{{ $muted }}">No product details available.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </td></tr>
    </table>

    <div style="border-top:2px dashed {{ $line }}; height:0; line-height:0; font-size:0">&nbsp;</div>

    {{-- ================= SUMMARY ================= --}}
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="{{ $cream }}" style="background:{{ $cream }}">
        <tr>
            <td width="50%" bgcolor="{{ $cream }}" style="background:{{ $cream }}; padding:26px 30px; vertical-align:top">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td bgcolor="{{ $tagBg }}" style="background:{{ $tagBg }}; color:{{ $tagFg }}; font-size:9px; font-weight:bold; letter-spacing:1.5px; padding:5px 12px">
                            {{ strtoupper($payLabel) }}
                        </td>
                    </tr>
                </table>
                <div style="color:{{ $dark }}; font-size:21px; font-weight:bold; line-height:1.25; margin:16px 0 8px">
                    Thank you<br>for your order!
                </div>
                <div style="color:{{ $text }}; font-size:11px">Keep this receipt for your records.</div>
            </td>

            <td width="50%" bgcolor="{{ $cream }}" style="background:{{ $cream }}; padding:26px 30px; vertical-align:top">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding:5px 0; color:{{ $text }}">Subtotal</td>
                        <td class="right" style="padding:5px 0; color:{{ $dark }}">₹{{ number_format((float) $order->subtotal, 2) }}</td>
                    </tr>

                    @if ((float) $order->discount > 0)
                        <tr>
                            <td style="padding:5px 0; color:{{ $text }}">Discount</td>
                            <td class="right" style="padding:5px 0; color:{{ $red }}">- ₹{{ number_format((float) $order->discount, 2) }}</td>
                        </tr>
                    @endif

                    @if ((float) $order->shipping > 0)
                        <tr>
                            <td style="padding:5px 0; color:{{ $text }}">Shipping</td>
                            <td class="right" style="padding:5px 0; color:{{ $dark }}">₹{{ number_format((float) $order->shipping, 2) }}</td>
                        </tr>
                    @endif

                    @if ((float) $cgstAmount > 0)
                        <tr>
                            <td style="padding:5px 0; color:{{ $text }}">CGST</td>
                            <td class="right" style="padding:5px 0; color:{{ $dark }}">₹{{ number_format((float) $cgstAmount, 2) }}</td>
                        </tr>
                    @endif

                    @if ((float) $sgstAmount > 0)
                        <tr>
                            <td style="padding:5px 0; color:{{ $text }}">SGST</td>
                            <td class="right" style="padding:5px 0; color:{{ $dark }}">₹{{ number_format((float) $sgstAmount, 2) }}</td>
                        </tr>
                    @endif

                    @if ((float) $igstAmount > 0)
                        <tr>
                            <td style="padding:5px 0; color:{{ $text }}">IGST</td>
                            <td class="right" style="padding:5px 0; color:{{ $dark }}">₹{{ number_format((float) $igstAmount, 2) }}</td>
                        </tr>
                    @endif
                </table>

                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:12px">
                    <tr>
                        <td bgcolor="{{ $primary }}" style="background:{{ $primary }}; color:#ffffff; font-size:11px; font-weight:bold; padding:14px 14px; border-bottom:3px solid {{ $accent }}">
                            Total Payable
                        </td>
                        <td bgcolor="{{ $primary }}" class="right" style="background:{{ $primary }}; color:#ffffff; font-size:18px; font-weight:bold; padding:12px 14px; border-bottom:3px solid {{ $accent }}">
                            ₹{{ number_format((float) $order->total, 2) }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- ================= PAYMENT DETAILS ================= --}}
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr><td style="padding:22px 30px 8px">
            <div class="label">Payment details</div>
            <table class="pay" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid {{ $line }}">
                @foreach ($detailRows as $row)
                    <tr>
                        @foreach ($row as $d)
                            <td width="50%">
                                <span style="color:{{ $muted }}; font-weight:bold">{{ $d[0] }}</span>&nbsp; {{ $d[1] }}
                            </td>
                        @endforeach
                        @if (count($row) < 2)
                            <td width="50%">&nbsp;</td>
                        @endif
                    </tr>
                @endforeach
            </table>

            @if ($order->notes)
                <div class="label" style="margin-top:16px">Order notes</div>
                <table width="100%" cellpadding="0" cellspacing="0" bgcolor="{{ $cream }}">
                    <tr>
                        <td bgcolor="{{ $cream }}" style="background:{{ $cream }}; padding:10px 12px; color:{{ $dark }}">{{ $order->notes }}</td>
                    </tr>
                </table>
            @endif
        </td></tr>
    </table>

    {{-- ================= FOOTER ================= --}}
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding:10px 30px 26px; vertical-align:bottom; font-size:10px; color:{{ $muted }}">
                This is a computer-generated receipt.<br>
                No signature required.
            </td>
            <td class="right" style="padding:10px 30px 26px; vertical-align:bottom; font-size:10px; color:{{ $muted }}">
                <strong style="color:{{ $primary }}; font-size:13px">FOODKING</strong><br>
                Thank you for choosing us!
            </td>
        </tr>
    </table>

</td></tr>
</table>

</body>
</html>