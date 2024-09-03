<div>


    <form wire:submit="save">
        <div class="card mt-3">
            <div class="card-header">
                <div class=" d-flex justify-content-between align-items-center">
                    <span class="h4">New Purchase Request</span>
                    <div class="form-check form-switch  ">
                        <input wire:model.blur="active" style="transform: scale(2)" class="form-check-input" type="checkbox"
                            role="switch" id="flexSwitchCheckDefault">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row row-cols-2">
                    <div>
                        <div class="form-group" wire:ignore.slef>
                            <label for="supplier_name" class="mb-2">Supplier Name *</label>
                            <select class="suppliers-ajax" id="supplier">
                                <option value="{{$supplierI}}">{{ App\Models\Supplier::first()->name }}</option>
                            </select>
                        </div>
                        <x-form.input wire:model="invoice_no" type='text' name='invoice_no' label='Invoice No' />

                    </div>
                    <div>
                        <x-form.input wire:model="purchase_date" type='date' name='purchase_date'
                            label='Purchase Date *' />
                        <x-form.input type='select' wire:model="payment_method" name='payment_method'
                            label='Payment Method' :options="['Cash' => 'Cash', 'Bank' => 'Bank']" />


                    </div>

                </div>
                <div class="row row-cols-1">
                    <x-form.input wire:model="details" type='textarea' name='details' label='Details' />

                </div>

            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <td>
                                #
                            </td>
                            <th>
                                Batch
                            </th>
                            <th>
                                Medicine *
                            </th>

                            <th>
                                Manufacture Date
                            </th>
                            <th>
                                Expiry Date
                            </th>

                            <th>
                                Box Pattern *
                            </th>
                            <th>
                                Box Qty *
                            </th>
                            <th>
                                Qty
                            </th>

                            <th>
                                Supplier Rate *
                            </th>


                            <th colspan="2">
                                Total Purchase Price
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productList as $key => $list)
                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        wire:model.blur="productList.{{ $key }}.batch_name">
                                </td>
                                <td>

                                    <select @if ($loop->last) onchange="@this.addProductToList()" @endif
                                        wire:model.live="productList.{{ $key }}.medicine_id"
                                        class="form-control  @error("productList.$key.medicine_id") is-invalid @enderror">
                                        <option value="">-- Select an option --</option>
                                        @foreach ($products as $id => $name)
                                            <option value="{{ $id }}"> {{ $name }}</option>
                                        @endforeach
                                    </select>

                                </td>

                                <td>
                                    <input @if (!@$productList[$key]['medicine_id']) disabled @endif
                                        wire:model="productList.{{ $key }}.manufacture_date" type="date"
                                        class="form-control @error("productList.$key.manufacture_date") is-invalid @enderror">
                                </td>
                                <td>
                                    <input @if (!@$productList[$key]['medicine_id']) disabled @endif
                                        wire:model="productList.{{ $key }}.expiry_date" type="date"
                                        class="form-control @error("productList.$key.expiry_date") is-invalid @enderror">
                                </td>

                                <td>

                                    <select @if (!@$productList[$key]['medicine_id']) disabled @endif
                                        wire:model.live="productList.{{ $key }}.unit_id" name=""
                                        class="form-control @error("productList.$key.unit_id") is-invalid @enderror"
                                        id="">

                                        <option value="">-- Select an option --</option>
                                        @foreach ($units as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach

                                    </select>

                                </td>
                                <td>
                                    <input @if (@$productList[$key]['medicine_id'] && @$productList[$key]['unit_id']) @else disabled @endif
                                        wire:model.blur="productList.{{ $key }}.unit_qty" type="text"
                                        class="form-control @error("productList.$key.unit_qty") is-invalid @enderror">
                                </td>
                                <td>
                                    <input readonly wire:model.blur="productList.{{ $key }}.qty"
                                        type="text"
                                        class="form-control @error("productList.$key.qty") is-invalid @enderror">
                                </td>
                                <td>
                                    <input @if (@$productList[$key]['medicine_id'] && @$productList[$key]['unit_id'] && @$productList[$key]['unit_qty']) @else disabled @endif
                                        wire:model.blur="productList.{{ $key }}.unit_supplier_rate"
                                        type="text"
                                        class="form-control @error("productList.$key.unit_supplier_rate") is-invalid @enderror">
                                </td>


                                <td colspan="2" style="position: relative">
                                    <input readonly wire:model="productList.{{ $key }}.total_purchase_price"
                                        type="text"
                                        class="form-control @error("productList.$key.total_purchase_price") is-invalid @enderror">
                                    @if (count($productList) > 1)
                                        <button type="button" class="btn btn-danger rounded-circle btn-sm h-auto "
                                            style="position: absolute;top:-10px;right:-10px;"
                                            wire:click="removeProductFromList('{{ $key }}')"> <i
                                                class="fa fa-times"></i></button>
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>
                                <button type="button" wire:click="addProductToList" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                            </th>
                            <th colspan="9" class="text-end">
                                Sub Total :
                            </th>
                            <th>
                                <input readonly wire:model="cart.sub_total" readonly type="text"
                                    class="form-control @error('cart.sub_total') is-invalid @enderror">
                            </th>

                        </tr>
                        <tr>
                            <th colspan="10" class="text-end">
                                VAT :
                            </th>
                            <th>
                                <input wire:model.blur="cart.vat" type="text"
                                    class="form-control @error('cart.vat') is-invalid @enderror">
                            </th>

                        </tr>
                        <tr>
                            <th colspan="10" class="text-end">
                                Discount :
                            </th>
                            <th>
                                <input wire:model.blur="cart.discount" type="text"
                                    class="form-control @error('cart.discount') is-invalid @enderror">
                            </th>

                        </tr>
                        <tr>
                            <th colspan="10" class="text-end">
                                Grand Total :
                            </th>
                            <th>
                                <input readonly wire:model="cart.grand_total" type="text"
                                    class="form-control @error('cart.grand_total') is-invalid @enderror">
                            </th>

                        </tr>
                        <tr>
                            <th colspan="10" class="text-end">
                                Paid Amount :
                            </th>
                            <th>
                                <input wire:model.blur="cart.paid_amount" type="text"
                                    class="form-control @error('cart.paid_amount') is-invalid @enderror">
                            </th>

                        </tr>
                        <tr>
                            <th colspan="10" class="text-end">
                                Due Amount :
                            </th>
                            <th>
                                <input wire:model="cart.due_amount" readonly type="text"
                                    class="form-control @error('cart.due_amount') is-invalid @enderror">
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
    </form>


</div>

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            @this.on('added', () => {
                new Audio("{{ url('sounds/effect1.mp3') }}").play();
            })
        });
        document.addEventListener("DOMContentLoaded", (event) => {
            @this.on('alert', (event) => {

                switch (event.type) {
                    case 'warning':
                        toastr.warning(event.message)
                        break;
                    default:
                        toastr.success(event.message)
                        break;
                }

            })
        });
        $(document).ready(function(param) {
            $('#supplier').on('change', function() {
                var data = $('#supplier').select2("val");
                @this.set('supplierI', data);
            });
        });
    </script>
@endpush
