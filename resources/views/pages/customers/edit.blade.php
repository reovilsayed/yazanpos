<x-layout>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <form action="{{ route('customers.update', $customer) }}" method="post">
            @csrf
            @method('put')
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-8 mb-4">

                        <div class="card">
                            <div class="card-body">
                                <h6 class="dash_head">Customer Details</h6>

                                <div class="row row-cols-2">
                                    <x-form.input name="name" label="Name *" value="{{ $customer->name }}"
                                        required />

                                    <x-form.input name="email" label="Email" value="{{ $customer->email }}" />
                                    <x-form.input name="phone" label="Phone *" value="{{ $customer->phone }}" />
                                    <x-form.input name="address" label="Address" value="{{ $customer->address }}" />
                                    <x-form.input name="gender" value="{{ $customer->gender }}" type="select"
                                        label="Gender *" :options="['male' => 'Male', 'female' => 'Female']" />
                                    <x-form.input name="password" label="Password" type="password" />

                                    <x-form.input name="role" value="{{ $customer->role_id }}" type="select"
                                    label="Role"  :options="$roles" />
                                </div>
                                <button class="btn btn-success" type="submit" style="float: right">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="row row-cols">
                                    <x-form.input name="discount" type="number" min="0" max="12"
                                        label="Discount *" value="{{ $customer->discount ?? 0 }}" />
                                </div>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <div class="card-footer">
                                <div class="d-grid">
                                    <button class="btn btn-success" type="submit" style="float: right">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
        </form>
    </div>
</x-layout>
