<tr>

    <td>
        <a class="{{ $customer->orders_sum_due > 0 ? 'text-danger' : 'text-primary' }} text-decoration-underline"
            href="{{ route('orders.index', ['search[column]' => 'customer.name', 'search[query]' => $customer->name]) }}">

            <h6>{{ $customer->name }}</h6>
        </a>
    </td>
    <td>
        <h6>{{ $customer->email }}</h6>
    </td>
    <td>
        <h6>{{ $customer->phone }}</h6>
    </td>
    <td>
        <h6>{{ $customer->address }}</h6>
    </td>
    <td>
        <h6>{{ $customer->gender }}</h6>
    </td>
    <td>
        <h6>{{ $customer->discount }}</h6>
    </td>
    <td>
        <h6 class="{{ $customer->orders_sum_due > 0 ? 'text-danger' : 'text-primary' }}">
            {{ Settings::price($customer->orders_sum_due) }}</h6>
    </td>


    <td class="d-flex">
        <a class="btn btn-sm btn-primary me-2" href="{{ route('customers.edit', $customer) }}"><i
                class="fa fa-edit"></i></a>
        <a class="btn btn-sm btn-primary me-2" href="{{ route('customers.show', $customer) }}"><i
                class="fa fa-eye"></i></a>
        <x-actions.delete :action="route('customers.destroy', $customer)" />
    </td>
</tr>
