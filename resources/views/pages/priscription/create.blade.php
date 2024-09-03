<x-layout>
    @push('script')
        <script>
            const addRow = () => {
                const index = $('#priscription-products').children().length
                const row = `<tr  class="table-row">
                                <td style="width:300px">
                                    <x-select.productSelect name="product[${index}][id]" />
                                </td>
                                <td class="w-auto">
                                    <div class="row row-cols-3 gap-2 justify-content-center">
                                        <div class="d-flex gap-3 align-items-center w-auto">
                                            <label for="">Morning :</label>
                                            <input type="number" step=".5" class="form-control" style="width: 100px"
                                                name="product[${index}][scheduled][morning]" value="0">

                                        </div>
                                        <div class="d-flex gap-3 align-items-center w-auto">
                                            <label for="">Noon :</label>
                                            <input type="number" step=".5" class="form-control" style="width: 100px"
                                                name="product[${index}][scheduled][noon]" value="0">

                                        </div>
                                        <div class="d-flex gap-3 align-items-center w-auto">
                                            <label for="">Night :</label>
                                            <input type="number" step=".5" class="form-control" style="width: 100px"
                                                name="product[${index}][scheduled][night]" value="0">

                                        </div>
                                    </div>

                                </td>

                                <td>
                                    <div class="row row-cols-2 mt-2">
                                        <div class="text-center">
                                            <input class="me-1 dose" type="checkbox" value="before" id="dose_before_${index}"
                                                name="product[${index}][dose]">
                                            <label for="dose_before_${index}">Before Eating</label>
                                        </div>
                                        <div class="text-center">
                                            <input class="me-1 dose" value="after" type="checkbox"
                                                id="dose_after_${index}" name="product[${index}][dose]">
                                            <label for="dose_after_${index}">After Eating</label>
                                        </div>
                                        <div class="w-100">
                                            <label for="comment_${index}">Comments</label>
                                            <input class="me-1 comment form-control"  type="text"
                                                id="comment_${index}" name="product[${index}][comment]">
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <button type="button"
                                        class="btn btn-danger btn-sm h-auto remove-row" onclick="removeRow(this)"> <i
                                            class="fa fa-trash"></i></button>
                                </td>
                            </tr>`;
                $('#priscription-products').append(row)
                const baseUrl = "{{ env('VITE_API_URI', 'https://pos.sohojware.com') }}";
                const addHeaders = function(xhr) {
                    xhr.setRequestHeader('x-secret-key', "{{ env('PASSWORD') }}");
                };
                $('.products-ajax').select2({
                    ajax: {
                        url:  `${baseUrl}/api/products`,

                        processResults: function(data) {
                            // Transforms the top-level key of the response object from 'items' to 'results'
                            return {
                                results: data
                            }
                        },
                        beforeSend: addHeaders
                    }
                });
            }

            const removeRow = (el) => {
                el.closest('tr').remove();
            }
        </script>
    @endpush
    <form action="{{ route('priscription.store') }}" method="POST">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-md-8 mt-4">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="dash_head">Doctor Prescription Form</h6>

                            <div class="row row-cols">
                                <x-form.input name="name" label="PATIENT NAME *" value="{{ $priscription->name }}"
                                    autofocus required
                                    class="@error('name')
                                   is-invalid 
                                @enderror" />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row row-cols">
                                <x-form.input name="symptoms" label="SYMPTOMS *" value="" style="height: 186px"
                                    type="textarea" id="test" autofocus required
                                    class="@error('symptoms')
                                        is-invalid
    
                                    @enderror" />
                                @error('symptoms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <x-form.input type="number" name="age" label="AGE *" value="" autofocus
                                    required />
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <h6>Gender</h6>
                            <div class="row row-cols-3">
                                <div class="d-flex mb-0">
                                    <x-form.input class="mb-0" id="male" name="gender" type="radio"
                                        value="Male" autofocus required />
                                    <label for="male" class=" ms-1 mb-0">Male</label>
                                </div>
                                <div class="d-flex mb-0">
                                    <x-form.input class="mb-0" id="female" name="gender" type="radio"
                                        value="Female" autofocus required />
                                    <label for="female" class="ms-1 mb-0">Female</label>
                                </div>
                                <div class="d-flex mb-0">
                                    <x-form.input class="mb-0" id="other" name="gender" type="radio"
                                        value="other" autofocus required />
                                    <label for="other" class="ms-1 mb-0">Other</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <h6>Customer</h6>
                            <div class="row-cols">
                                <x-select.customerSelect name="customer_id" required/>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card mt-4 mb-2">
                <div class="card-body">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    Medicine *
                                </th>

                                <th class="text-center w-auto">
                                    Scheduled *
                                </th>
                                <th class="text-center">
                                    Dose
                                </th>
                                <th class="text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id="priscription-products">
                            {{-- @foreach ($priscriptions as $priscription) --}}



                            {{-- @endforeach --}}

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="10" class="text-end">
                                    <button onclick="addRow()" type="button"
                                        class="btn btn-primary btn-sm h-auto add-row"> <i
                                            class="fa fa-plus"></i></button>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" style="float: right">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>

        </div>
    </form>



</x-layout>
