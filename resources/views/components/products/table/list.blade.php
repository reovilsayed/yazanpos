<table class="list_table all custom-fade-in">
    <thead>

        <tr>
            <th>image</th>
            <th>name</th>
            <th>Supplier</th>
            <th>Sold unit</th>
            <th>Price</th>
            <th>
                Status
            </th>
            <th>
                Actions
            </th>

        </tr>
    </thead>

    <tbody>
        @foreach ($products as $product)
            <x-products.table.row :product="$product" />
        @endforeach
    </tbody>
</table>
