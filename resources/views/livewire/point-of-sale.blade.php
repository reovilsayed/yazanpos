<div>
    <div class="row my-2 g-2">

        <div class="col-md-12">

            <input type="text" wire:model.live="query" placeholder="Search products ....." class="form-control">

        </div>

    </div>
    <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"
        class="btn btn-dark btn-lg position-fixed " style="bottom:20px;right:20px ;z-index: 100">
        <i class="fa fa-shopping-bag"></i><sup> {{ count($cart['products']) }}</sup>
    </button>



    <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"
        class="btn  btn-primary btn-lg position-fixed" data-fullscreen="true" id="fullscreen"
        style="bottom:20px;right:100px ;z-index: 100"><i class="fa fa-filter"></i>
        <sup>{{ count([...$categoriesInput, ...$genericsInput, ...$suppliersInput]) }}</sup></button>

    <button style="bottom:20px;right:190px ;z-index: 100" class="btn  btn-warning btn-lg position-fixed"
        data-fullscreen="true" id="fullscreen"><i class="fa fa-expand"></i></button>
    <div class="row  overflow-scroll ">

        <div class="col-md-12">



            <div class=" overflow-scroll overflow-x-none" style="max-height:90vh">
                <div class="p-2">

                    <div class="row g-3" wire:target="products" wire:loading.remove>
                        @foreach ($products as $product)
                            <div class="col-lg-2 col-md-4 col-6">
                                @include('layouts.pos.product', $product)
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

    </div>


    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="add-customer" tabindex="-1" data-bs-backdrop="false" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Add new customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('customer.store') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="row row-cols-2">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" id="phone" name="phone" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" id="form-control" name="address" class="form-control">
                            </div>


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="pay" wire:ignore.self tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Make Payment</h5>
                    <button type="button" id="close" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">


                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="">Recived Amount</label>
                                                <input type="number" wire:model.blur="payment.received_amount"
                                                    class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="">Paying Amount</label>
                                                <input readonly type="number" class="form-control"
                                                    value="{{ $cart['grand_total'] }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="">Change Return</label>
                                                <input readonly wire:model="payment.change_amount" type="number"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label for="">Due Amount</label>

                                                <div class="input-group">
                                                    <input readonly wire:model="payment.due_amount" type="number"
                                                        class="form-control">
                                                    <span class="input-group-text bg-light">Tk</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="">Payment Type</label>
                                                <select wire:model="payment.type" name="" class="form-control"
                                                    id="">
                                                    <option value="Cash">Cash</option>
                                                    <option value="Bkash">Bkash</option>
                                                    <option value="Nagad">Nagad</option>
                                                    <option value="Card">Card</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Payment Status</label>
                                                <select name="" class="form-control" id=""
                                                    wire:model="payment.status">
                                                    <option value="Paid">Paid</option>
                                                    <option value="Due">Due</option>
                                                    <option value="Unpaid">Unpaid</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Notes</label>
                                                <textarea name="" id="" class="form-control" cols="30" rows="10"
                                                    placeholder="Enter notes"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive" style="height: 300px">

                                        <table class="table">
                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>
                                                    Product
                                                </th>
                                                <th>
                                                    Qty
                                                </th>
                                                <th>
                                                    Sub Total
                                                </th>
                                            </tr>
                                            @foreach ($cart['products'] as $product)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        {{ $product['product']->name }}
                                                    </td>
                                                    <td>
                                                        {{ $product['quantity'] }}
                                                    </td>
                                                    <td>
                                                        {{ Settings::price($product['sub_total']) }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </table>

                                    </div>
                                    <table class="table table-primary">



                                        <tr>
                                            <th>
                                                Total
                                            </th>

                                            <th class="text-end">
                                                {{ Settings::price($cart['total']) }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Discount
                                            </th>

                                            <th class="text-end">
                                                {{ Settings::price($cart['discount']) }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Grand Total
                                            </th>

                                            <th class="text-end">
                                                {{ Settings::price($cart['grand_total']) }}
                                            </th>
                                        </tr>
                                    </table>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if ($payment['due_amount'] > 0 && $customer == null)
                        <button type="button" disabled class="btn btn-secondary">Walkin Customer Can't Keep
                            Due</button>
                    @else
                        <button type="button" wire:click="complete" class="btn btn-primary">Complete</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="offcanvas offcanvas-end cart" data-bs-backdrop="false" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Product List </h5>
            <button type="button" id="offcanvas-close" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="card p-0">
                <div class="card-header" >

                    <div class="input-group" wire:ignore>

                        <select  class="form-control" id="customers">
                            <option value="">Walkin Customer</option>
                            @foreach ($customers as $cus)
                            <option value="{{$cus->id}}" @if($cus->id == $customer) selected @endif>{{$cus->phone}} - {{$cus->name}}</option>
                                
                            @endforeach
                        </select>
                        <button class="btn btn-primary btn-sm h-auto" type="button" id="button-addon1"
                            data-bs-toggle="modal" data-bs-target="#add-customer" data-bs-dismiss="offcanvas"
                            aria-label="Close"><i class="fa fa-user-plus"></i></button>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive" style="height: 300px">
                    @foreach ($cart['products'] as $item)
                        @php
                            $productModel = $item['product'];

                        @endphp
                        <div class="row border-bottom border-primary p-2 mb-2">
                            <div class="col-md-2 col-3">
                                <img src="{{ $item['product']->image_url }}"
                                    style="width: 100px;height:100%;object-fit:cover" alt="">
                            </div>
                            <div class="col-md-10 col-9">
                                <div class="d-flex justify-content-between">

                                    <h6 class="m-0 pb-2">
                                        {{ $item['product']->name }} -
                                        <small>{{ Settings::price($item['product']->price) }}</small>
                                    </h6>
                                    <button wire:click.debounce.0ms="deleteCartItem({{ $item['product'] }})"
                                        class="btn btn-danger btn-sm h-auto"><i class="fa fa-trash"></i></button>
                                </div>
                                <h5 class="p-0 mb-1">
                                    {{ Settings::price($item['sub_total']) }}
                                </h5>
                                <select wire:model.live="cart.products.{{ $productModel->id }}.batch"
                                    class="form-control p-1 " style="font-size: 12px">
                                    @foreach ($productModel->batches as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->pivot->batch_name }}
                                            ({{ $batch->pivot->remaining_quantity - @$item['batches'][$batch->id]['quantity'] ?? 0 }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="mt-2 d-flex gap-1">
                                    <div style="transform:scale(.9)" class="d-flex gap-2">
                                        <button class="btn btn-outline-danger btn-sm p-1 h-auto"
                                            wire:click.debounce.0ms="removeFromCart({{ $item['product'] }},10)">-10</button>
                                        <button class="btn btn-outline-danger btn-sm p-1 h-auto"
                                            wire:click.debounce.0ms="removeFromCart({{ $item['product'] }},5)">-5</button>
                                        <button class="btn btn-outline-danger btn-sm p-1 px-2 h-auto"
                                            wire:click.debounce.0ms="removeFromCart({{ $item['product'] }},1)">-</button>
                                    </div>
                                    <p class="h6 d-flex justify-content-center align-items-center">
                                        {{ $item['quantity'] }}
                                    </p>
                                    <div style="transform:scale(.9)" class="d-flex gap-2">
                                        <button class="btn btn-outline-dark btn-sm p-1 px-2 h-auto"
                                            wire:click.debounce.0ms="addToCart({{ $item['product'] }})">+</button>
                                        <button class="btn btn-outline-dark btn-sm p-1 h-auto"
                                            wire:click.debounce.0ms="addToCart({{ $item['product'] }},5)">+5</button>
                                        <button class="btn btn-outline-dark btn-sm p-1 h-auto"
                                            wire:click.debounce.0ms="addToCart({{ $item['product'] }},10)">+10</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    @endforeach


                </div>
                <div class="card-footer bg-light">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th>
                                Total Quantity :
                            </th>
                            <td>
                                {{ $cart['total_quantity'] }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Total :
                            </th>
                            <td>
                                {{ Settings::price($cart['total']) }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Discount :
                            </th>
                            <td>
                                {{ Settings::price($cart['discount']) }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Grand Total :
                            </th>
                            <td>
                                {{ Settings::price($cart['grand_total']) }}
                            </td>
                        </tr>
                    </table>
                    <div>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">Discount</span>
                            <input wire:model.blur="cart.discount" onclick="@this.set('customDiscount', true)" type="number" min="0" max="100"
                                class="form-control" aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text bg-light">Tk</span>
                        </div>
                    </div>

                    <div class="d-flex gap-1 justify-content-end">

                        <button wire:click="resetCart" class="btn btn-sm p-2 h-auto btn-danger">
                            Reset &nbsp; <i class="fa fa-undo"></i>
                        </button>
                        <button data-bs-dismiss="offcanvas" aria-label="Close"
                            class="btn btn-sm p-2 h-auto btn-success" @if ($cart['grand_total'] == 0) disabled @endif
                            data-bs-toggle="modal" data-bs-target="#pay">
                            Pay Now &nbsp; <i class="fa fa-cash-register"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore class="offcanvas offcanvas-end " data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
        id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasBottomLabel">Filter </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body small">
            <div class="row row-cols-1 row-cols-md-1 ">
                <x-form.input type="select" id="generics" multiple="true" value=""
                    wire:model.live="genericsInput" name="generics" :options="$this->generics" label="Generic" />
                <x-form.input type="select" id="suppliers" multiple="true" wire:model.live="suppliersInput"
                    name="suppliers" :options="$this->suppliers" label="Supplier" />
                <x-form.input type="select" id="categories" multiple="true" wire:model.live="categoriesInput"
                    name="categories" :options="$this->categories" label="Category" />
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="productDetails" tabindex="-1"
        aria-labelledby="productDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-center  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailsLabel">{{ @$productDetails->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    {!! @$productDetails->generic->description !!}
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->



@push('script')
    <script>
        $(document).ready(function() {
            $('#generics').select2();
            $('#suppliers').select2();
            $('#categories').select2();
            $('#customers').select2();

            $('#generics').on('change', function(e) {
                var data = $('#generics').select2("val");
                @this.set('genericsInput', data);
            });
            $('#suppliers').on('change', function(e) {
                var data = $('#suppliers').select2("val");
                @this.set('suppliersInput', data);
            });
            $('#customers').on('change', function(e) {

                var data = $('#customers').select2("val");

                @this.set('customer', data);
            });
            $('#categories').on('change', function(e) {
                var data = $('#categories').select2("val");
                @this.set('categoriesInput', data);
            });
        });
    </script>
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
            @this.on('closeModal', (event) => {
                document.getElementById('close').click()
                document.getElementById('close').click()
            })

            @this.on('genericAdded', (event) => {
                $('#generics').val(@this.get('genericsInput'))
                $('#generics').trigger('change');
            })

            @this.on('showProductDetails', (event) => {
                var myModal = new bootstrap.Modal(document.getElementById('productDetails'), {
                    keyboard: false
                })

                myModal.show();


            })
        });
    </script>
@endpush
