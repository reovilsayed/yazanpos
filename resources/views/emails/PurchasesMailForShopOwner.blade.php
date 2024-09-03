@extends('layouts.email')
@section('content')
    <x-emails.tableImage :logo="asset('images/orderSuccess.jpg')" />

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 27px;">
        <tbody>
            <tr>
                <td>
                    <div class="title title-2 text-center">
                        <h2 style="font-size: 20px;font-weight: 700;margin: 24px 0 0;">A Purchase Has
                            Been Made.
                        </h2>
                        <p
                            style="font-size: 14px;margin: 5px auto 0;line-height: 1.5;color: #939393;font-weight: 500;width: 70%;">
                            A Purchase has been made by {{ $order->customer->name }} at
                            {{ $order->created_at->diffForHumans() }} </p>


                    </div>
                </td>
            </tr>
        </tbody>
    </table>



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

        </tbody>
    </table>
@endsection
