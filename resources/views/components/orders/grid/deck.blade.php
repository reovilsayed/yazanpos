<div class="row g-2">
    @foreach ($orders as $order)
        <div class="col-lg-3 col-md-6 col-sm-12">
            <x-orders.grid.card :order="$order" />
        </div>
    @endforeach
</div>
