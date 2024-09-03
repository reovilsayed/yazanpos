<x-layout>
    @push('styles')
        <style>
            @keyframes customFadeIn {
                from {
                    opacity: 0;
                    transform: translate3d(0, -20px, 0);
                }

                to {
                    opacity: 1;
                    transform: none;
                }
            }

            .custom-fade-in {
                animation: customFadeIn 0.5s ease-in-out;
            }
        </style>
    @endpush
    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
            <div class="head_row justify-content-between">
                @if (auth()->user()->role->hasPermissionTo('view purchase'))
                <div style="float">
                    <a href="{{ route('purchase.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add new
                        purchase</a>
                </div>
                @endif

            </div>
            <div class="mainData">


                <ul class="nav nav-tabs justify-content-end" id="myTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="grid-tab" data-bs-toggle="tab" href="#grid" role="tab"
                            aria-controls="grid" aria-selected="true"><i class="fas fa-th"></i></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="list-tab" data-bs-toggle="tab" href="#list" role="tab"
                            aria-controls="list" aria-selected="false"><i class="fas fa-list"></i> </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                        <x-purchases.grid.deck :purchases="$purchases" />
                    </div>
                    <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                        <x-purchases.table.list :purchases="$purchases" />
                    </div>
                </div>
            </div>


            {{ $purchases->onEachSide(1)->links() }}
        </div>
    </div>

    <x-filter :url="route('purchase.index')">
        <h6 class="mb-4">Search</h6>
        <div class="row g-1">
            <div class="col-md-4">
                <x-form.input type="select" name="search[column]" :value="@request()->search['column']" label="Field" :options="[
                    'supplier.name' => 'Name',
                    'invoice' => 'Invoice',
                    'batch_name' => 'Batch Name',
                    'product.status' => 'Status',
                    'purchased_at' => 'Purchased At',
                ]" />
            </div>
            <div class="col-md-8">
                <x-form.input type="text" name="search[query]" :value="@request()->search['query']" label="Search" />
            </div>
        </div>
        <hr>
        <h6 class="mb-4">Filter</h6>
        <div class="row row-cols-2 g-1">
            <x-form.input type="select" name="filter[status]" label="Status" :value="@request()->filter['status']" :options="['PAID' => 'Paid', 'DUE' => 'Due']"
                :show_empty_options="true" />
            <x-form.input type="date" name="date[created_at][from]" label="From" :value="@request()->date['created_at']['from']" />
            <x-form.input type="date" name="date[created_at][to]" label="To" :value="@request()->date['created_at']['to']" />
        </div>
        <hr>
        <h6 class="mb-4">Order By</h6>

        <div class="row row-cols-2">

            <x-form.input type="select" name="order[created_at]" label="Created At" :value="@request()->order['created_at']"
                :options="['asc' => 'Ascending', 'desc' => 'Descending']" :show_empty_options="true" />


        </div>

    </x-filter>
</x-layout>
