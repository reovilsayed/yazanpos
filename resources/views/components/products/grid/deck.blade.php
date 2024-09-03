<div class="row g-2">
    @foreach ($products as $product)
        <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
            <x-products.grid.card :product="$product" />
        </div>
    @endforeach
</div>
