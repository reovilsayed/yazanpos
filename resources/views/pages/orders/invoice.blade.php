<x-layout>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <button onclick="printDiv('printableArea')" class="btn btn-success me-1 mb-2"><i
                        class="fa fa-print me-2"></i>Print</button>
                <div class="card" id="printableArea">
                    <div class="card-body">

                        @if ($order->notes)
                            <div class="text-start">

                                <span class="text-danger fw-bolder fs-6">Note: {{ $order->notes }}</span>
                            </div>
                        @endif
                        <hr class="mt-3 mb-4">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Billed To:</h5>
                                    <h5 class="font-size-15 mb-2">{{ $order->customer->name ?? 'Walk in customer' }}
                                    </h5>
                                    <p class="mb-1">{{ $order->customer->address }}</p>
                                    <p class="mb-1">{{ $order->customer->email }}</p>
                                    <p>{{ $order->customer->phone }}</p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="text-muted text-sm-end">
                                    <div>
                                        <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                        <p>#{{ $order->id }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                        <p>{{ $order->created_at->format('d-M-y') }}</p>
                                    </div>

                                </div>
                            </div>

                        </div>


                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th class="text-end" style="width: 120px;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($order->products as $product)
                                            <tr>
                                                <th scope="row">{{ $product->id }}</th>
                                                <td>
                                                    <div>
                                                        <h5 class="text-truncate font-size-14 mb-1">
                                                            {{ $product->name ?? ($product->pivot->name ?? '') }}
                                                        </h5>
                                                        <p class="text-muted mb-0">
                                                            @if ($product->category != null || $product->supplier != null)
                                                                {{ $product->category->name ?? '' }},{{ $product->supplier->name ?? '' }}
                                                            @else
                                                                Custom Product
                                                            @endif
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>{{ $product->pivot->quantity }}</td>
                                                <td class="text-end">{{ Settings::price($product->pivot->price) }}</td>
                                                <td class="text-end">
                                                    {{ Settings::price($product->pivot->price * $product->pivot->quantity) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th scope="row" colspan="4" class="text-end">Sub Total</th>
                                            <td class="text-end">{{ Settings::price($order->sub_total) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Discount :</th>
                                            <td class="border-0 text-end">- {{ Settings::price($order->discount) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                                            <td class="border-0 text-end">
                                                <h4 class="m-0 fw-semibold">{{ Settings::price($order->total) }}</h4>
                                            </td>
                                        </tr>

                                        <tr class="bg-success">
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Paid Ammount:</th>
                                            <td class="border-0 text-end">{{ Settings::price($order->paid) }}
                                            </td>
                                        </tr>
                                        <tr class="bg-warning">
                                            <th scope="row" colspan="4" class="border-0 text-end">
                                                Due Ammount :</th>
                                            <td class="border-0 text-end">{{ Settings::price($order->due) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            @if ($order->transactions->count() > 0)
                                <h5 class="font-size-15 mt-3">Due payment transaction history</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->transactions as $transaction)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>
                                                    {{ Settings::price($transaction->amount) }}
                                                </td>
                                                <td>{{ $transaction->created_at->format('M d,Y') }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
    </div>

    @push('script')
        <script type="text/javascript">
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
    @endpush
</x-layout>
