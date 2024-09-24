<x-layout>
    @push('styles')
        <style>
            .filter-btns {
                margin-top: 28px
            }

            @media screen and (max-width:780px) {
                .filter-btns {
                    margin-top: 0px
                }

                .img-rounded {
                    height: 40px;
                }
            }

            .position-card {
                position: absolute;
                bottom: 0
            }

            .box {
                border: 1px solid blue;
                padding: 5px;
                font-size: 11px;
                text-align: center
            }

            p {
                margin-bottom: 5px;
            }

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


            <div class="view_box list_view_box active_view">
                <div class="all_tab_panel" data-tab-parent="tabgroup1">
                    <div class="tab_panel active">
                        <div class="panel_inner panel_inner_scrollable">
                            <div class="row justify-content-between mb-3 align-items-center">
                                <div class="col-md-5 col-6">
                                    @if (auth()->user()->role->hasPermissionTo('create product'))
                                        <a class="btn btn-primary mb-1" href="{{ route('products.createOrEdit') }}"><i
                                                class="fa fa-plus"></i>
                                            New
                                            product</a>
                                    @endif
                                    @foreach (['Tops', 'Bottoms', 'Dresses', 'Outerwear', 'Activewear', 'Underwear', 'Swimwear', 'Footwear', 'Accessories'] as $item)
                                        <a class="btn btn-info mb-1"
                                            href="{{ route('products.index', ['search[column]' => 'type', 'search[query]' => $item]) }}">{{ $item }}</a>
                                    @endforeach

                                </div>
                                <div class="col-md-5 col-6">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-1">
                                            <div class="widget">
                                                <p>Total Products: {{ $allProductCount }}</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 mb-1">
                                            <div class="widget">
                                                <p>Active Product: {{ $activeProductCount }}</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                            <div class="widget">
                                                <p>Inactive Product: {{ $allProductCount - $activeProductCount }}</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <!-- Bootstrap Tab -->
                                    <ul class="nav nav-tabs" id="viewTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="grid-tab" data-bs-toggle="tab"
                                                href="#gridView" role="tab" aria-controls="gridView"
                                                aria-selected="true"><i class="fas fa-th"></i></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="list-tab" data-bs-toggle="tab" href="#listView"
                                                role="tab" aria-controls="listView" aria-selected="false"><i
                                                    class="fas fa-th-list"></i> </a>
                                        </li>
                                    </ul>
                                    <!-- Bootstrap Tab Content -->

                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="gridView" role="tabpanel"
                                    aria-labelledby="grid-tab">
                                    <!-- Grid View Component -->
                                    <x-products.grid.deck :products="$products" />
                                </div>
                                <div class="tab-pane fade" id="listView" role="tabpanel" aria-labelledby="list-tab">
                                    <!-- List View Component -->
                                    <x-products.table.list :products="$products" />
                                </div>
                            </div>
                            {{-- <x-products.grid.deck :products="$products" />
                            <x-products.table.list :products="$products" /> --}}
                        </div>
                    </div>

                </div>
            </div>
            {{ $products->onEachSide(1)->links() }}

        </div>
    </div>
    <x-filter :url="route('products.index')">
        <div class="row">
            <div class="col-md-4">
                <x-form.input type="select" name="search[column]" :value="@request()->search['column']" label="Field" :options="['name' => 'Name', 'supplier.name' => 'Supplier']" />
            </div>
            <div class="col-md-8">
                <x-form.input type="text" name="search[query]" :value="@request()->search['query']" label="Search" />
            </div>
        </div>
        <x-form.input type="select" name="filter[supplier_id]" label="Supplier" :value="@request()->filter['supplier_id']" :options="$suppliers"
            :show_empty_options="true" />
        <x-form.input type="select" id="generic-input" name="filter[generic_id]" label="Generic" :value="@request()->filter['generic_id']"
            :options="$generics" :show_empty_options="true" />
        <x-form.input type="select" name="filter[category_id]" label="Category" :value="@request()->filter['category_id']" :options="$categories"
            :show_empty_options="true" />
        <x-form.input type="select" name="filter[featured]" label="Featured" :value="@request()->filter['featured']" :options="[1 => 'Yes', 0 => 'No']"
            :show_empty_options="true" />

        <h5>Order By</h5>
        <div class="row row-cols-2">
            <x-form.input type="select" name="order[price]" label="Price Order" :value="@request()->order['price']" :options="['asc' => 'Ascending', 'desc' => 'Descending']"
                :show_empty_options="true" />
            <x-form.input type="select" name="order[sold_unit]" label="Sales Order" :value="@request()->order['sold_unit']"
                :options="['asc' => 'Ascending', 'desc' => 'Descending']" :show_empty_options="true" />

        </div>

    </x-filter>
    @push('script')
        <script>
            $(document).ready(function() {
                $('#generic-input').select2();
            });

            function duplicateProduct(productId) {

                var csrf_token = "{{ csrf_token() }}";
                $.ajax({
                    url: "{{ route('products.duplicate') }}",
                    method: "POST",
                    data: {
                        productId: productId,
                        _token: csrf_token

                    },
                    success: function(response) {
                        window.location.href = "{{ route('products.createOrEdit', '') }}/" + response.newProductId;
                    },
                    error: function(error) {
                        alert('Error duplicating product!');
                    }
                });
            }
        </script>
    @endpush
</x-layout>
