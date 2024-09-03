<tr>
    <td class="text-center" scope="row">
        @if ($order->due > 0)
            <input class="form-check-input orderCheckBox" type="checkbox" value="{{ $order->id }}">
        @endif
    </td>

    <td>
        {{ $order->customer->name ?? 'Walk in customer' }}
        <br>
        <br>
        <a href="tel:{{ $order->customer->phone }}">{{ $order->customer->phone }}</a>
    </td>

    <td>
        Total: {{ Settings::price($order->total) }} <br>
        Paid : {{ Settings::price($order->paid) }} <br>
        @if ($order->discount > 0)
            Disount : {{ Settings::price($order->discount) }} <br>
        @endif
        @if ($order->due > 0)
            <span class="text-danger">Due :
                {{ Settings::price($order->due) }}</span>
        @endif
    </td>
    <td class="{{ $order->status == 'PAID' || $order->status == 'Paid' ? 'text-success' : 'text-danger' }}">
        {{ $order->status }}</td>
    <td>
        {{ $order->created_at->format('d M, Y ') }}
        {{ $order->created_at->format('h:i A') }}
    </td>
    <td>
        <a class="btn btn-primary" href="{{ route('orders.invoice', $order) }}">Invoice</a>
        @if ($order->due > 0)
            <button type="button" class="btn btn-success" data-order="{{ $order->id }}" data-bs-toggle="modal"
                data-bs-target="#deposite">Deposite</button>

            <form action="{{ route('orders.mark.pay') }}" method="post" class=" mt-1"
                onsubmit="return confirm('Are you sure you want to mark this order as paid?')">
                @csrf
                <input type="hidden" name="orders[]" value="{{ $order->id }}">

                <button type="submit" class="btn btn-dark">Mark as Pay</button>
            </form>
        @endif
    </td>
</tr>
