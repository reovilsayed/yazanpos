<tr>
    <td>
        <img class="" height="100" width="100" src="{{ $product->image_url }}" alt="">
    </td>
    <td>
        <div>

            <div class="mb-1">

                <span class="h6">{{ $product->name }}
                </span>
                <span class="badge bg-danger">{{ $product->category?->name }}</span>
            </div>
        </div>
        @if ($product->generic)
            <span class="badge bg-primary">{{ $product->generic->name }}</span>
        @endif
        <span class="badge bg-success">{{ $product->strength }}</span>
        <span class="badge bg-secondary mt-1">{{ $product->is_bonus }}</span>
    </td>
    {{-- <td>{{$product->category->name}}</td> --}}
    <td>{{ $product->supplier?->name }}</td>
    <td>
        {{ $product->sold_unit }}
    </td>
    <td>
        Unit Price: {{ Settings::price($product->price) }} <br>
        @if ($product->box_price)
            Box Size: {{ $product->box_size }} <br>
            Box Price:{{ $product->box_price }} <br>
        @endif
        @if ($product->strip_price)
            Strip Price:{{ $product->strip_price }}
        @endif

    </td>


    <td>
        @if ($product->status)
            <span class="badge bg-primary">True</span>
        @else
            <span class="badge bg-danger">False</span>
        @endif
    </td>
    <td>


        <div class="d-flex gap-1">
            {{-- <a class="btn btn-sm btn-success" href=""><i
                        class="fa fa-eye"></i></a> --}}
            @if (auth()->user()->role->hasPermissionTo('edit product'))
                <a class="btn btn-sm btn-primary" href="{{ route('products.createOrEdit', $product) }}"><i
                        class="fa fa-edit"></i></a>
            @endif
            <button class="btn btn-sm btn-success" title="Duplicate Product"
                onclick="duplicateProduct('{{ $product->id }}')">
                <i class="fa fa-clone"></i>
            </button>
            @if (auth()->user()->role->hasPermissionTo('delete product'))
                <x-actions.delete :action="route('products.delete', $product)" />
            @endif

        </div>
    </td>


</tr>
