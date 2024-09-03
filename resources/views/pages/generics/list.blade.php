<x-layout>
    @push('styles')
        <style>
            .filter_row .srch_inner .srch_btn {
                width: inherit;
                background-color: transparent;
            }

            .filter_row .srch_inner .srch_btn:hover {
                background-color: transparent;
            }

            button:hover {
                background-color: transparent;
            }

            .srch_inner input[type="text"] {
                padding: 12px 20px 12px 75px;
            }
        </style>
    @endpush
    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
            <div class="d-flex justify-content-between mt-1 mb-4">
                @if (auth()->user()->role->hasPermissionTo('create generic'))
                    <div style="float">
                        <a href="{{ route('generics.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add new
                            generic</a>
                    </div>
                @endif
                <div class="srch_inner">
                    {{-- <form action="">
                        <input style="height: auto;" type="search" placeholder="Search Here......Name Or Url"
                            value="{{ $search }}" name="search" />
                        <button class="btn btn-primary btn-sm h-auto"> Search</button>
                        <a href="{{ url('/generics') }}"><button class="btn btn-primary btn-sm h-auto" type="button">
                                Reset</button></a>
                        <span class="srch_btn"><img src={{ asset('images/search.svg') }} alt="" /></span>
                    </form> --}}

                </div>
            </div>
            {{-- @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif --}}

            <div class="view_box list_view_box active_view">
                <div class="all_tab_panel" data-tab-parent="tabgroup1">
                    <div class="tab_panel active">
                        <div class="panel_inner panel_inner_scrollable">
                            <table class="list_table all">
                                <thead>
                                    <tr>

                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($generics as $generic)
                                        <tr>

                                            <td>
                                                <h6>{{ $generic->name }}</h6>
                                            </td>

                                            <td class="d-flex">
                                                @if (auth()->user()->role->hasPermissionTo('edit generic'))
                                                    <a class="btn btn-sm btn-primary me-2"
                                                        href="{{ route('generics.edit', $generic) }}"><i
                                                            class="fa fa-edit"></i></a>
                                                @endif
                                                @if (auth()->user()->role->hasPermissionTo('delete generic'))
                                                <x-actions.delete :action="route('generics.destroy', $generic)" />
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $generics->onEachSide(1)->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-filter :url="route('generics.index')">
        <h6 class="mb-4">Search</h6>
        <div class="row g-1">
            <div class="col-md-4">
                <x-form.input type="select" name="search[column]" :value="@request()->search['column']" label="Field" :options="[
                    'name' => 'Name',
                    'url' => 'Url',
                    'description' => 'Description',
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
</x-layout>
