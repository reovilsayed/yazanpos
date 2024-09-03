<x-layout>
    <div class="container">
        <div class="row justify-content-center mt-3">

            <div class="col-lg-10">
                <button onclick="printDiv('printableArea')" class="btn btn-success me-1 mb-2"><i
                        class="fa fa-print me-2"></i>Print</button>
                <div class="card" id="printableArea">
                    <div class="card-body">
                        <div class="invoice-title">
                            <p class="float-end font-size-15">Invoice #{{ $purchase->invoice }} <span
                                    class="badge bg-success font-size-12 ms-2">{{ $purchase->status }}</span></p>

                            <div class="text-muted">

                                <p class="mb-1">{{ $purchase->details }}</p>
                                {{-- <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> xyz@987.com</p>
                                    <p><i class="uil uil-phone me-1"></i> 012-345-6789</p> --}}

                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Supplied By:</h5>
                                    <img src="{{ $purchase->supplier->imageUrl }}" alt="" style="height: 100px">
                                    <h5 class="font-size-15 mb-2">{{ $purchase->supplier->name }}</h5>
                                    <p class="mb-1">{{ $purchase->supplier->address }}</p>
                                    <p class="mb-1">{{ $purchase->supplier->company_email }}</p>
                                    <p>{{ $purchase->supplier->company_phone }}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Supplier :</h5>
                                    <h5 class="font-size-15 mb-2">{{ $purchase->supplier->contact_person }}</h5>
                                    <p class="mb-1">{{ $purchase->supplier->contact_person_designation }}</p>
                                    <p class="mb-1">{{ $purchase->supplier->contact_person_email }}</p>
                                    <p>{{ $purchase->supplier->contact_person_phone }}</p>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-sm-3">
                                <div class="text-muted text-sm-end">
                                    <div>
                                        <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                        <p>#{{ $purchase->invoice }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                        <p>{{ $purchase->purcahsed_at->format('d M,Y') }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <h5 class="font-size-15 mb-1">Payment type:</h5>
                                        <h4><span class="badge bg-success  ms-2">{{ $purchase->payment_type }}</span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Product Info</th>
                                            <th>Dates</th>
                                            <th>Purchased unit</th>
                                            <th>Purchase quantity</th>
                                            <th>Supplier rate</th>
                                            <th>Price</th>
                                            {{-- <th>Quantity</th>
                                                <th class="text-end" style="width: 120px;">Total</th> --}}
                                        </tr>
                                    </thead><!-- end thead -->
                                    {{-- @dd($purchase->products[0]->pivot) --}}
                                    <tbody>
                                        @foreach ($purchase->products as $product)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>
                                                    <div>
                                                        <h5 class="text-truncate font-size-14 mb-1">
                                                            {{ $product->name }}</h5>
                                                        <p class="text-muted mb-0">{{ $product->sku }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p class="text-muted mb-1"><span class="fw-bold">Manufacture
                                                                date:</span> {{ $product->pivot->manufacture_date }}
                                                        </p>
                                                        <p class="text-muted mb-0"> <span class="fw-bold">Expiry date
                                                                :</span> {{ $product->pivot->expiry_date }}</p>
                                                    </div>
                                                </td>
                                                <td>{{ $product->pivot->purchased_unit }}</td>
                                                <td>{{ $product->pivot->purchase_quantity }}</td>
                                                <td>{{ Settings::price($product->pivot->supplier_rate) }}</td>
                                                <td>{{ Settings::price($product->pivot->total) }}</td>


                                            </tr>
                                        @endforeach

                                        <!-- end tr -->

                                        <tr>
                                            <th scope="row" colspan="6" class="text-end">Sub Total</th>
                                            <td class="text-end">{{ Settings::price($purchase->subtotal) }}</td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="6" class="border-0 text-end">
                                                vat :</th>
                                            <td class="border-0 text-end">{{ Settings::price($purchase->vat) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="6" class="border-0 text-end">
                                                Discount :</th>
                                            <td class="border-0 text-end">- {{ Settings::price($purchase->discount) }}
                                            </td>
                                        </tr>
                                        <!-- end tr -->

                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="6" class="border-0 text-end">
                                                <h5>Total :</h5>
                                            </th>
                                            <td class="border-0 text-end">
                                                <h5 class="m-0 fw-semibold">
                                                    {{ Settings::price($purchase->grand_total) }}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" colspan="6" class="border-0 text-end">
                                                Paid Ammount:</th>
                                            <td class="border-0 text-end">{{ Settings::price($purchase->paid_amount) }}
                                            </td>
                                        </tr>
                                        <!-- end tr -->
                                        <tr>
                                            <th scope="row" colspan="6" class="border-0 text-end">
                                                Due Ammount :</th>
                                            <td class="border-0 text-end">{{ Settings::price($purchase->due_amount) }}
                                            </td>
                                        </tr>
                                        <!-- end tr -->
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div><!-- end table responsive -->
                            <div class="d-print-none mt-4">
                                <div class="float-end">

                                    {{-- <a href="#" class="btn btn-primary w-md">Send</a> --}}
                                </div>
                            </div>
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
