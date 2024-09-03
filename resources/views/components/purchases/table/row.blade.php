<tr>
    <td>
        {{ $purchase->supplier->name }}
    </td>
    <td>
        {{ $purchase->invoice }}
    </td>
    <td>
        {{ $purchase->batch_name }}
    </td>
    <td>
        @if ($purchase->active)
            <span
                class="badge @if ($purchase->status == 'PAID') bg-primary @else bg-danger @endif">{{ $purchase->status }}</span>
        @else
            <span class="badge bg-secondary">Draft</span>
        @endif
    </td>
    <td>
        {{ Settings::price($purchase->due_amount) }}
    </td>
    <td>
        {{ Settings::price($purchase->paid_amount) }}

    </td>

    <td>
        {{ $purchase->purcahsed_at->format('d-m-Y') }}
    </td>
    <td>
        {{ $purchase->created_at->format('d-m-Y (H:i A)') }}

    </td>
    <td>
        {{ $purchase->updated_at->format('d-m-Y (H:i A)') }}

    </td>
    <td>
        <a href="{{ route('purchase.invoice', $purchase) }}" class="btn btn-sm btn-primary h-auto"><i
                class="fa fa-eye"></i></a>

        @if (auth()->user()->role->hasPermissionTo('delete supplier'))
                <a href="{{ route('purchase.edit', $purchase) }}" class="btn btn-sm btn-warning"><i
                        class="fa fa-edit"></i></a>
            @endif
            @if (auth()->user()->role->hasPermissionTo('delete purchase'))
            <x-actions.delete :action="route('purchase.destroy', $purchase)" />
            @endif
    </td>
</tr>
