<x-layout>
    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
            <div class="head_row justify-content-between">
                <div style="col-md-2">
                    <a class="btn btn-primary" href="{{ route('units.create') }}"><i class="fa fa-plus"></i> Add Box
                        Pattern</a>
                </div>



            </div>


            <div class="view_box list_view_box active_view">
                <div class="all_tab_panel" data-tab-parent="tabgroup1">
                    <div class="tab_panel active">
                        <div class="panel_inner panel_inner_scrollable">
                            <table class="list_table all">
                                <thead>
                                    <tr>
                                        <th scope="col">name</th>
                                        <th scope="col">quantity</th>
                                        <th>
                                            Actions
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($units as $unit)
                                        <tr>

                                            <td>
                                                {{ $unit->name }}
                                            </td>
                                            <td>
                                                {{ $unit->quantity }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ route('units.edit', $unit) }}"><i
                                                            class="fa fa-edit"></i></a>
                                                    <x-actions.delete :action="route('units.destroy', $unit)" />
                                                </div>
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $units->onEachSide(1)->links() }}
                </div>
            </div>

        </div>
    </div>

    <x-filter :url="route('units.index')">
        <h6 class="mb-4">Search</h6>
        <div class="row g-1">
            <div class="col-md-4">
                <x-form.input type="select" name="search[column]" :value="@request()->search['column']" label="Field" :options="[
                    'name' => 'Name',
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
