<div class="card custom-fade-in h-100">

    <img class="card-img-top image-fluid" style="height: 320px" src="{{ $product->image_url }}" alt="{{ $product->name }}">
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <span class="badge bg-danger">{{ $product->category?->name }}</span>
        @if ($product->generic)
            <span class="badge bg-primary">{{ $product->generic->name }}</span>
        @endif
        <span class="badge bg-success">{{ $product->strength }}</span>
        <span class="badge bg-secondary">{{ $product->is_bonus }}</span>
        <p class="card-text">{{ $product->supplier?->name }}</p>
        @if ($product->unit)
            <div class="col-12">
                <span class="card-text">Unit: {{ $product->unit }}</span>
            </div>
        @endif
        <div class="d-flex justify-content-between mb-2">
            <span class="card-text">Unit Sold: {{ $product->sold_unit }}</span>
            @if ($product->status)
                <span class="badge bg-primary">Status: True</span>
            @else
                <span class="badge bg-danger">Status: False</span>
            @endif
        </div>
        <div class="row row-cols-2  g-2">
            <div class="box col">
                <p class="mb-0">Unit Price: </p>
                <p class="card-text">{{ Settings::price($product->price) }}</p>
            </div>
            @if ($product->box_price)
                <div class="box col ">
                    <p class="card-text">Box Size: </p>
                    <p class="card-text">{{ $product->box_size }}</p>
                </div>
                <div class="box col">
                    <p class="card-text">Box Price:</p>
                    <p class="card-text">{{ Settings::price($product->box_price) }}</p>

                </div>
            @endif
            @if ($product->strip_price)
                <div class="box col">
                    <p class="card-text">Strip Price:</p>
                    <p class="card-text">{{ Settings::price($product->strip_price) }}</p>
                </div>
            @endif
        </div>

        <div class="d-flex gap-1 mt-3 justify-content-evenly">
            @if (auth()->user()->role->hasPermissionTo('edit product'))
            <a class="btn btn-sm btn-primary" href="{{ route('products.createOrEdit', $product) }}">
                <i class="fa fa-edit"></i>
            </a>
            @endif
            <button class="btn btn-sm btn-success" onclick="duplicateProduct('{{ $product->id }}')">
                <i class="fa fa-clone"></i> Duplicate
            </button>
            @if (auth()->user()->role->hasPermissionTo('delete product'))
            <x-actions.delete :action="route('products.delete', $product)" />
            @endif
        </div>
    </div>
</div>
