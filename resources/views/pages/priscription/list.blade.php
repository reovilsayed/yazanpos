<x-layout>
    <style>
        .remove {
            position: absolute;
            z-index: 10;
            font-size: 16px;
            line-height: 38px;
            right: 13px;
            top: 0;
            color: var(--bs-secondary-color);
        }
    </style>
    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
            <div class="head_row justify-content-between">
                <div style="float">
                    <a href="{{ route('priscription.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> new
                        prescriptions</a>
                </div>
                <div class="">
                    <form action="{{ route('priscription.index') }}" method="GET"
                        class="app-search d-none d-lg-block pt-0 me-3">
                        <div class="position-relative d-flex">
                            <input type="text" class="form-control" name="customer" placeholder="Search..."
                                value="{{ request('customer') }}">
                            <span class="bx bx-search-alt"></span>
                            @if (request()->has('customer'))
                                <!-- Show the "Remove" button when there is a search request -->
                                <a class=" remove" onclick="removeSearch()"><i class="fa fa-times" style="color: red"
                                        aria-hidden="true"></i></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>


            <div class="view_box list_view_box active_view">
                <div class="all_tab_panel" data-tab-parent="tabgroup1">
                    <div class="tab_panel active">
                        <div class="panel_inner panel_inner_scrollable">
                            @if ($priscriptions->count() > 0)

                                <table class="list_table all">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th scope="col">PATIENT NAME *</th>
                                            <th scope="col">SYMPTOMS *</th>
                                            <th scope="col">Gender *</th>
                                            <th scope="col">Actions *</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($priscriptions as $priscription)
                                            <tr>
                                                <td>
                                                    {{ $loop->index + 1 }}
                                                </td>
                                                <td>
                                                    {{ $priscription->name }}
                                                </td>
                                                <td>
                                                    {{ $priscription->symptoms }}
                                                </td>
                                                <td>
                                                    {{ $priscription->gender }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('pos', ['prescription' => $priscription->id]) }}"
                                                        class="btn btn-dark btn-sm"> <i class="fa fa-cash-register">
                                                        </i></a>
                                                    <a href="{{ route('priscription.show', $priscription) }}"
                                                        class="btn btn-sm btn-primary h-auto"><i
                                                            class="fa fa-eye"></i></a>
                                                    <a href="{{ route('priscription.edit', $priscription) }}"
                                                        class="btn btn-sm btn-warning h-auto"><i
                                                            class="fa fa-edit"></i></a>

                                                    <x-actions.delete :action="route('priscription.destroy', $priscription)" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h4 class="text-center text-danger">No Items Found</h4>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            {{ $priscriptions->onEachSide(1)->links() }}
        </div>
    </div>


    <x-filter :url="route('priscription.index')">
        <h6 class="mb-4">Search</h6>
        <div class="row g-1">
            <div class="col-md-4">
                <x-form.input type="select" name="search[column]" :value="@request()->search['column']" label="Field" :options="[
                    'name' => 'PATIENT NAME',
                    'symptoms' => 'SYMPTOMS ',
                ]" />
            </div>
            <div class="col-md-8">
                <x-form.input type="text" name="search[query]" :value="@request()->search['query']" label="Search" />
            </div>
        </div>
        <hr>
        <h6 class="mb-4">Filter</h6>
        <div class="row row-cols-2 g-1">

            <x-form.input type="date" name="date[created_at][from]" label="From" :value="@request()->date['created_at']['from']" />
            <x-form.input type="date" name="date[created_at][to]" label="To" :value="@request()->date['created_at']['to']" />
        </div>
        <hr>
        <h6 class="mb-4">Order By</h6>

        <div class="row row-cols-2">

            <x-form.input type="select" name="order[created_at]" label="Created At" :value="@request()->order['created_at']" :options="['asc' => 'Ascending', 'desc' => 'Descending']"
                :show_empty_options="true" />


        </div>

    </x-filter>

    <script>
        function removeSearch() {
            // Redirect to the same route without the search parameter
            window.location.href = "{{ route('priscription.index') }}";
        }
    </script>
</x-layout>
