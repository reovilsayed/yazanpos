<table class="list_table all custom-fade-in">
    <thead>
        <tr>
            <th scope="col">Supplier</th>
            <th scope="col">Invoice</th>
            <th scope="col">Batch Name</th>
            <th scope="col">Status</th>
            <th scope="col">Due</th>
            <th scope="col">Paid</th>
            <th scope="col">Purchased At</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($purchases as $purchase)
            <x-purchases.table.row :purchase="$purchase" />
        @endforeach
    </tbody>
</table>
