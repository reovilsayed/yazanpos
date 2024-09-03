<x-layout>
    @push('styles')
        <style>
            .filter_row .srch_inner .srch_btn {
                width: inherit;
                background-color: transparent;
            }
        </style>
    @endpush
    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">

            <div class="head_row justify-content-between container">
                <div style="float">
                    @if (auth()->user()->role->hasPermissionTo('create supplier'))
                    <a href="{{ route('suppliers.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> New
                        Suppliers</a>
                    @endif
                </div>
                <form action="">
                    <div class="filter_row">

                        <div class="srch_inner">
                            <form action="{{ route('suppliers.index') }}">
                                <input type="text" placeholder="Search Here......"
                                    value="{{ request('search_supplier') }}" name="search_supplier" />
                                <button class="srch_btn">
                                    <span><img src={{ asset('images/search.svg') }} alt="" /></span>
                                </button>
                        </div>
                        {{-- <button type="submit" class="inline_btn" id="" value="search">Search</button> --}}
                        {{-- <a href="{{route('suppliers.create')}}" class="inline_btn">+</a> --}}
                    </div>
                </form>
            </div>


            <div class="view_box list_view_box active_view">
                <div class="all_tab_panel" data-tab-parent="tabgroup1">
                    <div class="tab_panel active">
                        <div class="panel_inner panel_inner_scrollable">
                            <table class="list_table all">
                                <thead>
                                    <tr>
                                        <th scope="col">Logo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Registration Number</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Action</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $supplier)
                                        <tr>
                                            <td><img class="img-rounded"
                                                    src="{{ $supplier->logo ? asset('storage/' . $supplier->logo) : asset('images/suplier.png') }}"
                                                    alt="">
                                            </td>
                                            <td>
                                                <h6>{{ $supplier->name }}</h6>
                                            </td>
                                            <td>
                                                <h6>{{ $supplier->registration_number }}</h6>
                                            </td>
                                            <td>
                                                <h6>{{ $supplier->compnay_phone }}</h6>
                                            </td>
                                            {{-- <td>
                                                @if (isset($supplier->contact_person))
                                                    <table class="bg-white">
                                                        <tbody>
                                                            @foreach (json_decode($supplier->contact_person) as $person)
                                                                <tr>

                                                                    <td>{{ $person->name }}</td>
                                                                    <td>{{ $person->phone }}</td>
                                                                    <td>{{ $person->email }}</td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                @endif
                                            </td> --}}
                                            <td>
                                                @if (auth()->user()->role->hasPermissionTo('edit supplier'))
                                                <a href="{{ route('suppliers.edit', $supplier) }}"
                                                    class="btn btn-sm btn-primary h-auto">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @endif
                                                @if (auth()->user()->role->hasPermissionTo('delete supplier'))
                                                <x-actions.delete :action="route('suppliers.destroy', $supplier)" />
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $suppliers->appends(request()->query())->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- @dd(session('success')) --}}
</x-layout>
