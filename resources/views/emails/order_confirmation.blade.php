@extends('layouts.email')
@section('content')

    <x-emails.tableImage :logo="asset('images/orderSuccess.jpg')" />

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 27px;">
        <tbody>
            <tr>
                <td>
                    <div class="title title-2 text-center">
                        <h2 style="font-size: 20px;font-weight: 700;margin: 24px 0 0;">Thank You for
                            Your Purchase!
                        </h2>
                        <p
                            style="font-size: 14px;margin: 5px auto 0;line-height: 1.5;color: #939393;font-weight: 500;width: 70%;">
                            Thank you for choosing our service. Your purchase has been successful. If
                            you have any questions or need further assistance, feel free to contact us.
                        </p>

                        <p
                            style="font-size: 14px;margin: 5px auto 0;line-height: 1.5;color: #939393;font-weight: 500;width: 70%;">
                            Best regards, {{ Settings::option('shopName') }}</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    @php
        $previousDues = $order->customer->orders->where('id', '!=', $order->id)->where('due', '!=', 0);
    @endphp

    <table class="shipping-table" align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="padding: 0 27px;">
        <thead>
            <tr>
                <th
                    style="font-size: 17px;font-weight: 700;padding-bottom: 8px;border-bottom: 1px solid rgba(217, 217, 217, 0.5);text-align: left;">
                    Purchased Items</th>
            </tr>
        </thead>
        <tbody>
            <tr
                style="column-count: 1; column-rule-style: dashed; column-rule-color: rgba(82, 82, 108, 0.7); column-gap: 0; column-rule-width: 0; ">
                <td style="width: 100%;" align="center">
                    <table class="product-table" align="center" border="0" cellpadding="0" cellspacing="0"
                        width="100%">
                        <tbody>
                            @foreach ($order->products as $product)
                                <tr>
                                    <td
                                        style="
                                                    padding: 28px 0;
                                                    border-bottom: 1px solid rgba(217, 217, 217, 0.5);
                                                  ">
                                        <img src="{{ $product->image_url }}" alt="" />
                                    </td>
                                    <td
                                        style="
                                                    padding: 28px 0;
                                                    border-bottom: 1px solid rgba(217, 217, 217, 0.5);
                                                  ">
                                        <ul class="product-detail">
                                            <li>{{ $product->name }}
                                                <span
                                                    style="color: #000; font-size: 13px;">({{ $product->category?->name }})</span>
                                            </li>

                                            <li>{{ $product->strength }}</li>
                                            <li>QTY: <span>{{ $product->pivot->quantity }}</span></li>
                                            <li>Price:
                                                <span>{{ Settings::price($product->pivot->price) }}</span>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>

                {{-- <td style="width: 100%;">
                                    <table class="dilivery-table" align="center" border="0" cellpadding="0"
                                        cellspacing="0" width="100%"
                                        style="background-color: #F7F7F7; padding: 14px;">
                                        <tbody>
                                            <tr>
                                                <td style="font-weight: 700; font-size: 17px; padding-bottom: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);"
                                                    colspan="2">Order summary</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                    Subtotal</td>
                                                <td
                                                    style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                    {{ $order->sub_total }}</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                    Discount</td>
                                                <td
                                                    style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                    {{ $order->discount }}</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="text-align: left; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                    Paid</td>
                                                <td
                                                    style="text-align: right; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                    {{ $order->paid }}</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="text-align: left; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                    Due</td>
                                                <td
                                                    style="text-align: right; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                                    {{ $order->due }}</td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="text-align: left; font-size: 15px; font-weight: 600; padding-top: 15px;">
                                                    Total</td>
                                                <td
                                                    style="text-align: right; font-size: 15px; font-weight: 600; padding-top: 15px;">
                                                    {{ $order->total }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td> --}}
            </tr>
            <tr
                style="column-count: 1; column-rule-style: dashed; column-rule-color: rgba(82, 82, 108, 0.7); column-gap: 0; column-rule-width: 0;">


                <td style="width: 100%;" align="center">
                    <table class="dilivery-table" align="center" border="0" cellpadding="0" cellspacing="0"
                        width="100%" style="background-color: #F7F7F7; padding: 14px;">
                        <tbody>
                            <tr>
                                <td style="font-weight: 700; font-size: 17px; padding-bottom: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);"
                                    colspan="2">Order summary</td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Subtotal</td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ Settings::price($order->sub_total) }}</td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Discount</td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ Settings::price($order->discount) }}</td>
                            </tr>

                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Total</td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ Settings::price($order->total) }}</td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Paid</td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ Settings::price($order->paid) }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left; font-size: 15px; font-weight: 600; padding-top: 15px; ">
                                    Due</td>
                                <td style="text-align: right; font-size: 15px; font-weight: 600; padding-top: 15px;">
                                    {{ Settings::price($order->due) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            @if ($previousDues->count() > 0)
                <tr style="height: 30px;"></tr>

                <tr
                    style="column-count: 1; column-rule-style: dashed; column-rule-color: rgba(82, 82, 108, 0.7); column-gap: 0; column-rule-width: 0;">


                    <td style="width: 100%;" align="center">
                        <table class="dilivery-table" align="center" border="0" cellpadding="0" cellspacing="0"
                            width="100%" style="background-color: #F7F7F7; padding: 14px;">
                            <tbody>
                                <tr>
                                    <td style="font-weight: 700; font-size: 17px; padding-bottom: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);"
                                        colspan="2">Previous Dues</td>
                                </tr>
                                @foreach ($previousDues as $order)
                                    <tr>
                                        <td
                                            style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                            Order Id: {{ $order->id }}</td>
                                        <td
                                            style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                            Order Created: {{ $order->created_at->format('d-M-y') }}
                                        </td>
                                        <td
                                            style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                            Due: {{ Settings::price($order->due) }}</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    {{-- <td colspan="2"
                                                        style="text-align: left; font-size: 15px; font-weight: 600; padding-top: 15px; ">
                                                    </td> --}}
                                    <td colspan="3"
                                        style="text-align: right; font-size: 15px; font-weight: 600; padding-top: 15px;">
                                        Total Due {{ Settings::price($previousDues->sum('due')) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endif

        </tbody>
    </table>

@endsection
