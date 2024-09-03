<div class="">
    <form class="row" method="POST"
        action="{{ isset($supplier) ? route('suppliers.update', $supplier) : route('suppliers.store') }}"
        enctype="multipart/form-data">
        @csrf
        @if (isset($supplier))
            @method('PUT')
        @endif

        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="dash_head">Company Details</h6>
                    <div class="row row-cols-2">
                        <div class="form-group">
                            <label for="name" class="mb-2">Company Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name"
                                value="{{ old('name', isset($supplier) ? $supplier->name : '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="company_email" class="mb-2">Company Email</label>
                            <input type="email" class="form-control @error('company_email') is-invalid @enderror"
                                id="company_email" name="company_email"
                                value="{{ old('company_email', isset($supplier) ? $supplier->company_email : '') }}">
                            @error('company_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="company_phone" class="mb-2">Company Phone</label>
                            <input type="text" class="form-control @error('company_phone') is-invalid @enderror"
                                id="company_phone" name="company_phone"
                                value="{{ old('company_phone', isset($supplier) ? $supplier->company_phone : '') }}">
                            @error('company_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="registration_number" class="mb-2">Registration Number</label>
                            <input type="text"
                                class="form-control @error('registration_number') is-invalid @enderror"
                                id="registration_number" name="registration_number"
                                value="{{ old('registration_number', isset($supplier) ? $supplier->registration_number : '') }}">
                            @error('registration_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="vat_number" class="mb-2">VAT Number</label>
                            <input type="text" class="form-control @error('vat_number') is-invalid @enderror"
                                id="vat_number" name="vat_number"
                                value="{{ old('vat_number', isset($supplier) ? $supplier->vat_number : '') }}">
                            @error('vat_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group ">
                            <label for="country" class="mb-2">Country</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror"
                                id="country" name="country"
                                value="{{ old('country', isset($supplier) ? $supplier->country : '') }}">
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="city" class="mb-2">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                id="city" name="city"
                                value="{{ old('city', isset($supplier) ? $supplier->city : '') }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website" class="mb-2">Website</label>
                            <input type="text" class="form-control @error('website') is-invalid @enderror"
                                id="website" name="website"
                                value="{{ old('website', isset($supplier) ? $supplier->website : '') }}">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group col-md-12 col-sm-12">
                        <label for="address" class="mb-2">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ old('address', isset($supplier) ? $supplier->address : '') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            @if (isset($supplier))
                @php
                    $contact_persons = json_decode($supplier->contact_person);

                @endphp
                <div class="card">
                    <div class="card-body">
                        <h6 class="dash_head">Person Details</h6>
                        <div class="row justify-content-end ms-3" id="contactPersonNew">
                            @if (count((array) $contact_persons))
                                @foreach ($contact_persons as $key => $person)
                                    <div class=" ms-5 row align-items-center justify-content-center contactPerson card my-3 mx-2"
                                        style="flex-direction: row">
                                        <div class="col-md-10">
                                            <div class="row my-3">
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label for="contact_person" class="mb-2">Contact Person *</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $person->name }}"
                                                        name="contact_person[{{ $key }}][name]">
                                                </div>

                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label for="contact_person_phone" class="mb-2">Contact Person
                                                        Phone *</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $person->phone }}"
                                                        name="contact_person[{{ $key }}][phone]">
                                                </div>

                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label for="contact_person_email" class="mb-2">Contact Person
                                                        Email</label>
                                                    <input type="email" class="form-control"
                                                        value="{{ $person->email }}"
                                                        name="contact_person[{{ $key }}][email]">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger removeContactPerson"
                                                data-row-index="{{ $key }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <div class="col-md-10">
                                <p>Another Contact person</p>
                            </div>
                            <div class="col-md-2">

                                <button type="button" class="btn btn-outline-primary w-100" id="addColumnButton"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div id="contactPersonNew">


                        </div>
                    </div>


                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <h6 class="dash_head">Person Details</h6>

                        <div class="row justify-content-end">
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="contact_person" class="mb-2">Contact Person *</label>
                                    <input type="text"
                                        class="form-control @error('contact_person') is-invalid @enderror"
                                        id="contact_person" name="contact_person[0][name]">

                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>




                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="contact_person_phone" class="mb-2">Contact Person Phone
                                        *<s></s></label>
                                    <input type="text"
                                        class="form-control @error('contact_person_phone') is-invalid @enderror"
                                        id="contact_person_phone" name="contact_person[0][phone]" required>
                                    @error('contact_person_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="contact_person_email" class="mb-2">Contact Person Email</label>
                                    <input type="email"
                                        class="form-control @error('contact_person_email') is-invalid @enderror"
                                        id="contact_person_email" name="contact_person[0][email]">
                                    @error('contact_person_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-10">
                                <p>Another Contact person</p>
                            </div>
                            <div class="col-md-2">

                                <button type="button" class="btn btn-outline-primary w-100" id="addColumnButton"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div id="contactPersonNew">


                        </div>
                    </div>


                </div>
            @endif
            <div class="card mt-3">
                <div class="card-body">
                    <div class="form-group">
                        <label for="logo" class="mb-2">Logo</label>
                        <input type="file" class="form-control @error('logo') is-invalid @enderror"
                            id="logo" name="logo" accept="image/*">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if (isset($supplier) && $supplier->logo)
                            <div>Current Logo: <img src="{{ asset('storage/' . $supplier->logo) }}"
                                    alt="Current Logo" style="max-width: 100px;"></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer mt-2" style="border-radius: 10px;">
                <div class="d-grid">

                    <button type="submit"
                        class="btn btn-primary">{{ isset($supplier) ? 'Update' : 'Submit' }}</button>

                </div>
            </div>


        </div>

    </form>
</div>
@push('script')
    @if (isset($supplier))
        <script>
            $(document).ready(function() {
                $('#addColumnButton').on('click', function() {
                    // Get the current row count

                    var rowCount = {{ count((array) json_decode($supplier->contact_person)) }};
                    rowCount = rowCount + $('#contactPersonNew .contactPerson').length + 1;
                    console.log(rowCount);


                    $('#contactPersonNew').append(`
                <div class="row align-items-center justify-content-center contactPerson card my-3 mx-2"
                    style="flex-direction: row">
                    <div class="col-md-10">
                        <div class="row my-3">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="contact_person" class="mb-2">Contact Person *</label>
                                <input type="text" class="form-control" name="contact_person[${rowCount}][name]">
                            </div>

                            <div class="form-group col-md-12 col-sm-12">
                                <label for="contact_person_phone" class="mb-2">Contact Person Phone *</label>
                                <input type="text" class="form-control" name="contact_person[${rowCount}][phone]">
                            </div>

                            <div class="form-group col-md-12 col-sm-12">
                                <label for="contact_person_email" class="mb-2">Contact Person Email</label>
                                <input type="email" class="form-control" name="contact_person[${rowCount}][email]">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger removeContactPerson" data-row-index="${rowCount}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `);
                });

                // Event delegation for dynamically added remove buttons
                console.log('clicked');

                $('#contactPersonNew').on('click', '.removeContactPerson', function() {
                    var rowIndex = $(this).data('row-index');

                    // Assuming $supplier->contact_person is a JSON string
                    var newContactItem = @json(json_decode($supplier->contact_person));

                    // Assuming the structure is an array
                    delete newContactItem[rowIndex];

                    // Assuming the structure is an object
                    // delete newContactItem[rowIndex.toString()];

                    $(this).closest('.contactPerson').remove();
                });
            });
        </script>
    @else
        <script>
            $(document).ready(function() {
                $('#addColumnButton').on('click', function() {



                    var rowCount = $('#contactPersonNew .contactPerson').length + 1;


                    $('#contactPersonNew').append(`
                <div class="row align-items-center justify-content-center contactPerson card my-3 mx-2"
                    style="flex-direction: row">
                    <div class="col-md-10">
                        <div class="row my-3">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="contact_person" class="mb-2">Contact Person *</label>
                                <input type="text" class="form-control" name="contact_person[${rowCount}][name]">
                            </div>

                            <div class="form-group col-md-12 col-sm-12">
                                <label for="contact_person_phone" class="mb-2">Contact Person Phone *</label>
                                <input type="text" class="form-control" name="contact_person[${rowCount}][phone]">
                            </div>

                            <div class="form-group col-md-12 col-sm-12">
                                <label for="contact_person_email" class="mb-2">Contact Person Email</label>
                                <input type="email" class="form-control" name="contact_person[${rowCount}][email]">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger removeContactPerson" data-row-index="${rowCount}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `);
                });

                // Event delegation for dynamically added remove buttons
                $('#contactPersonNew').on('click', '.removeContactPerson', function() {
                    var rowIndex = $(this).data('row-index');
                    console.log('Remove clicked for row index:', rowIndex);
                    $(this).closest('.contactPerson').remove();
                });
            });
        </script>
    @endif

@endpush
