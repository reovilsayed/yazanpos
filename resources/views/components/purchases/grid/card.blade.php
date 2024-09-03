<div class="card mb-3 custom-fade-in">
    <div class="card-header" style="background-color: #205E61; color: #fff">
        <div class="row position-relative">
            <div class="col-md-9 col-9">
                <h5 class="card-title" style="font-size: 1rem">
                    {{ $purchase->supplier->name }}
                    <br>
                </h5>
                <span class="text-white">Invoice: {{ $purchase->invoice ?? '(No Invoice)' }}</span>
            </div>
            <div class="col-md-3 col-3 text-end pe-0">
                @if ($purchase->active)
                    <span
                        class="badge @if ($purchase->status == 'PAID') bg-primary @else bg-danger @endif">{{ $purchase->status }}</span>
                @else
                    <span class="badge bg-secondary">Draft</span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <p class="card-text">Batch Name: {{ $purchase->batch_name }}</p>
        <p class="card-text">Due Amount: {{ Settings::price($purchase->due_amount) }}</p>
        <p class="card-text">Paid Amount: {{ Settings::price($purchase->paid_amount) }}</p>
        <p class="card-text">Purchased At: {{ $purchase->purcahsed_at ? $purchase->purcahsed_at->format('d-m-Y') : '' }}
        </p>

        <div class="d-flex justify-content-end align-items-center gap-1">
            <a href="{{ route('purchase.invoice', $purchase) }}" class="btn btn-sm btn-primary"><i
                    class="fa fa-sm fa-eye"></i></a>
            @if (auth()->user()->role->hasPermissionTo('delete supplier'))
                <a href="{{ route('purchase.edit', $purchase) }}" class="btn btn-sm btn-warning"><i
                        class="fa fa-edit"></i></a>
            @endif
            @if (auth()->user()->role->hasPermissionTo('delete purchase'))
            <x-actions.delete :action="route('purchase.destroy', $purchase)" />
            @endif
        </div>
    </div>
</div>
