<x-layout>
    <div class="dashboard_content_inner" style="margin-bottom: 50px">
        <div class="dashboard_content ps-0 mt-2">
            <div class="dashboard_content_inner">
                <div class="mainData">

                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('customers.index') }}" class="btn btn-success"><i
                                    class="fa-solid fa-reply-all"></i>
                                All Customers</a>
                            <a href="{{ route('export-users-single',['from'=>request('from'),'to'=>request('to')]) }}" class="btn btn-success"><i
                                    class="fa-solid fa-download"></i>
                                Export</a>
                        </div>
                        <div class="row my-3 d-flex justify-content-between align-items-center">
                            <div class="col-10">
                                <form action="{{ route('customers.shifts', $customer->id) }}" method="GET" class="row">
                                    @csrf
                                    <div class="col-3">
                                        <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                                    </div>
                                    <div class="col-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa-solid fa-search"></i> Search
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-2 text-end">
                            {{-- <span>Total Duty: {{ Carbon\CarbonInterval::minutes()->cascade()->forHumans() }}</span> --}}
                            <span>Total Duty: {{ $shifts->map(fn($shift)=>$shift->durationInMin() )->sum() }} Hours</span>
                            </div>
                        </div>

                    </div>
                    <div class="tab-content">

                        <div class="tab-pane fade active show" id="list" role="tabpanel"
                            aria-labelledby="list-tab">
                            <table class="list_table all custom-fade-in">
                                <thead>
                                    <tr>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Clocked In</th>
                                        <th scope="col">Clocked Out</th>
                                        <th scope="col">Duration</th>
                                        {{-- <th scope="col">Actions</th> --}}

                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd($shifts) --}}
                                    @forelse ($shifts as $shift)
                                        <tr>
                                            <td>
                                                {{ $shift->user->name }}
                                            </td>
                                            <td>
                                                {{ $shift->clock_in }}
                                            </td>
                                            <td>
                                                {{ $shift->clock_out ?? 'Currently clocked in' }}
                                            </td>
                                            <td>
                                                {{ $shift->duration() }}
                                            </td>

                                            {{-- <td>
                                                @if (auth()->user()->role->hasPermissionTo('edit pre-discount'))
                                                    <a href="{{ route('pre-discounts.edit', $shift) }}"
                                                        class="btn btn-sm btn-warning h-auto"><svg
                                                            class="svg-inline--fa fa-edit fa-w-18" aria-hidden="true"
                                                            focusable="false" data-prefix="fa" data-icon="edit"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z">
                                                            </path>
                                                        </svg></a>
                                                @endif
                                                @if (auth()->user()->role->hasPermissionTo('delete pre-discount'))
                                                    <x-actions.delete :action="route('pre-discounts.destroy', $shift)" />
                                                @endif
                                            </td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <th class="text-center" scope="col" colspan="4">No Logs Yet</th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
