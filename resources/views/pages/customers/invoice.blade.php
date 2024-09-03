<x-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="row">
                    <div class="col-md-3">
                        <button onclick="printDiv('printableArea')" class="btn btn-success me-1 mb-2"><i
                                class="fa fa-print me-2"></i>Print</button>
                        @if ($customer->email)
                            <a href="{{ route('reports.send', $customer) }}" class="btn btn-success me-1 mb-2"><i
                                    class="fa fa-envelope me-2"></i></a>
                        @endif
                        @if ($customer->orders->sum('due') > 0)
                            <button type="button" class="btn btn-success" title="Deposite" data-bs-toggle="modal"
                                data-bs-target="#deposite_full"><i class="fas fa-money-bill-wave"></i></button>
                        @endif
                    </div>
                    <div class="col-md-9 text-end mb-3">
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-md-5">
                                    <input class="form-control" type="date" name="form">
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control" type="date" name="to">
                                </div>
                                <div class="col-md-2">
                                    <input class="btn btn-success pt-2 pb-2" type="submit">
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
                {{--  --}}
                <div class="card" id="printableArea">
                    <div class="card-body mt-4">
                        <div class="row justify-content-end">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Billed To:</h5>
                                    <h5 class="font-size-15 mb-2">{{ $customer->name ?? 'Walk in customer' }}
                                    </h5>
                                    <p class="mb-1">{{ $customer->address }}</p>
                                    <p class="mb-1">{{ $customer->email }}</p>
                                    <p>{{ $customer->phone }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">Billed From:</h5>
                                    <h5 class="font-size-15 mb-2">{{ Settings::option('shopName') }}</h5>
                                    <p class="mb-1">{{ Settings::option('address') }}</p>
                                    <p class="mb-1">{{ Settings::option('email') }}</p>
                                    <p>{{ Settings::option('phone') }}</p>
                                </div>
                            </div>

                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="py-2">
                            <h5 class="font-size-15">Order Summary</h5>

                            <div>
                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 70px;">ID.</th>
                                            <th>Created At</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr class="text-center">
                                                <th scope="row">{{ $order->id }}</th>
                                                <td>{{ $order->created_at->format('d-M-Y ') }}</td>
                                                <th>{{ Settings::price($order->paid) }}</th>
                                                <th>{{ Settings::price($order->due) }}</th>
                                                <td>
                                                    <button
                                                        class="btn {{ $order->due > 0 ? 'btn-danger' : 'btn-success' }}">{{ $order->status }}</button>
                                                </td>

                                                <td>
                                                    <a target="_blank"
                                                        href="{{ route('orders.invoice', ['order' => $order->id]) }}"
                                                        class="btn btn-info"> <i class="fa fa-eye"></i> </a>
                                                    @if ($order->due > 0)
                                                        <button type="button" class="btn btn-success" title="Deposite"
                                                            data-order="{{ $order->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#deposite"><i
                                                                class="fas fa-money-bill-wave"></i></button>
                                                        <form action="{{ route('orders.mark.pay') }}" method="post"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to mark this order as paid?')">
                                                            @csrf
                                                            <input type="hidden" name="orders[]"
                                                                value="{{ $order->id }}">
                                                            <button type="submit" class="btn btn-dark"><i
                                                                    class="fas fa-check"></i> Mark as Paid</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="row m-0">
                                    <div class="col-md-12">
                                        <div class="row pb-1 ">
                                            <div class="col-md-9 col-sm-8 text-end">
                                                <p>Sub Total :</p>
                                            </div>
                                            <div class="col-md-3 col-sm-4">
                                                <p class="text-end">
                                                    {{ Settings::price($customer->orders->sum('sub_total')) }}</p>
                                            </div>
                                        </div>

                                        <div class="row pt-2 pb-2">
                                            <div class="col-md-9 col-sm-8 text-end">
                                                <p>Discount :</p>
                                            </div>
                                            <div class="col-md-3 col-sm-4">
                                                <p class="text-end">
                                                    {{ Settings::price($customer->orders->sum('discount')) }}</p>
                                            </div>
                                        </div>

                                        <div class="row pt-2 pb-2">
                                            <div class="col-md-9 col-sm-8 text-end">
                                                <h5>Total</h5>
                                            </div>
                                            <div class="col-md-3 col-sm-4">
                                                <h4 class="m-0 fw-semibold text-end">
                                                    {{ Settings::price($customer->orders->sum('total')) }}</h4>
                                            </div>
                                        </div>

                                        <div class="row pt-2 pb-2 bg-success">
                                            <div class="col-md-9 col-sm-8 text-end">
                                                <p>Paid Amount:</p>
                                            </div>
                                            <div class="col-md-3 col-sm-4">
                                                <p class="text-end">
                                                    {{ Settings::price($customer->orders->sum('paid')) }}</p>
                                            </div>
                                        </div>

                                        <div class="row pt-2 pb-2 bg-danger">
                                            <div class="col-md-9 col-sm-8 text-end">
                                                <p>Due Amount :</p>
                                            </div>
                                            <div class="col-md-3 col-sm-4">
                                                <p class="text-end">
                                                    {{ Settings::price($customer->orders->sum('due')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($transactions->count() > 0)
                    <div class="card mt-2">
                        <div class="card-body mt-4">
                            <div class="py-2">
                                <h5 class="font-size-15">Transaction History</h5>
                                <div>
                                    <table class="table">
                                        <thead>
                                            <tr class="text-center">
                                                <th style="width: 70px;">ID.</th>
                                                <th>Amount</th>
                                                <th>Transaction Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions as $transaction)
                                                <tr class="text-center">
                                                    <th scope="row">{{ $transaction->id }}</th>
                                                    <th scope="row">{{ Settings::price($transaction->amount) }}
                                                    </th>
                                                    <td>{{ $transaction->created_at->format('d-M-Y ') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>

        <div class="modal fade" id="deposite" tabindex="-1" aria-labelledby="depositeLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="depositeLabel">Pay the due amount</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('orders.due.pay') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <x-form.input name="amount" label="Amount *" value="" autofocus required
                                type="number" step="any" />
                            <input type="hidden" name="order_id" id="orderId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deposite_full" tabindex="-1" aria-labelledby="deposite_fullLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deposite_fullLabel">Deposite total due</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('deposite.full', ['user' => $customer]) }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <x-form.input name="amount" label="Amount *"
                                value="{{ $customer->orders->sum('due') }}" autofocus required type="number"
                                step="any" />
                            <input type="hidden" name="order_id" id="orderId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @push('script')
            <script>
                // Extract and display data when the modal is shown
                $('#deposite').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var order = button.data('order');
                    var modal = $(this);
                    modal.find('#orderId').val(order);

                });
            </script>
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
