<table class="list_table all custom-fade-in">
    <thead>

        <tr>
            <th>
                <form action="{{ route('orders.mark.pay') }}" method="post"
                    onsubmit="return confirm('Are you sure you want to mark this order as paid?')">
                    @csrf
                    <div id="hiddenInputsContainer"></div>

                    <button type="submit" class="btn btn-sm btn-dark">Mark as Paid</button>
                </form>
            </th>
            <th scope="col">Customer</th>
            <th scope="col">Payment</th>
            <th scope="col">Status</th>
            <th>Date & Time</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <x-orders.table.row :order="$order" />
        @endforeach
    </tbody>
</table>
