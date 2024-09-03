@extends('layouts.email')
@section('content')
  
    <x-emails.tableImage :logo="asset('images/orderSuccess.jpg')" />
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 27px;">
        <tbody>
            <tr>
                <td>
                    <div class="title title-2 text-center">
                        <h2 style="font-size: 20px;font-weight: 700;margin: 24px 0 0;">Thank you for
                            clearing your due!
                        </h2>
                        <p
                            style="font-size: 14px;margin: 5px auto 0;line-height: 1.5;color: #939393;font-weight: 500;width: 70%;">

                            Dear {{ $order->customer->name }},

                            Thank you for your prompt attention to clearing your due. We appreciate your
                            cooperation and look forward to continuing our positive collaboration.
                        </p>

                        <p
                            style="font-size: 14px;margin: 5px auto 0;line-height: 1.5;color: #939393;font-weight: 500;width: 70%;">
                            Best regards, {{ Settings::option('shopName') }}</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>


    <table class="shipping-table" align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="padding: 0 27px;">
        {{-- <thead>
    <tr>
        <th
            style="font-size: 17px;font-weight: 700;padding-bottom: 8px;border-bottom: 1px solid rgba(217, 217, 217, 0.5);text-align: left;">
            Purchased Items</th>
    </tr>
</thead> --}}
        <tbody>
            <tr style="height: 30px;"></tr>
            <tr
                style="column-count: 1; column-rule-style: dashed; column-rule-color: rgba(82, 82, 108, 0.7); column-gap: 0; column-rule-width: 0;">


                <td style="width: 100%;" align="center">
                    <table class="dilivery-table" align="center" border="0" cellpadding="0" cellspacing="0"
                        width="100%" style="background-color: #F7F7F7; padding: 14px;">
                        <tbody>
                            <tr>
                                <td style="font-weight: 700; font-size: 17px; padding-bottom: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);"
                                    colspan="2">Due Paid</td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Order Id:</td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    #{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Order Created: </td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 400; padding: 15px 0; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ $order->created_at->format('d-M-Y') }}</td>
                            </tr>

                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Due Paid: </td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ Settings::price($amount) }}</td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: left; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    Due Left: </td>
                                <td
                                    style="text-align: right; font-size: 15px; font-weight: 600; padding-top: 15px; border-bottom: 1px solid rgba(217, 217, 217, 0.5);">
                                    {{ Settings::price($order->due) }}</td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
@endsection
