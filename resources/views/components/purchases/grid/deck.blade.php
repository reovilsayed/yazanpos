<div class="row g-2">
    @foreach ($purchases as $purchase)
        <div class="col-lg-3 col-md-6 col-sm-12">
            <x-purchases.grid.card :purchase="$purchase" />
        </div>
    @endforeach
</div>
