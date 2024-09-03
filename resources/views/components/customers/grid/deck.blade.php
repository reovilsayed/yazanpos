<div class="row g-3">
    @foreach ($customers as $customer)
        <div class="col-lg-3 col-md-6 col-sm-12">
            <x-customers.grid.card :customer="$customer" />
        </div>
    @endforeach
</div>
