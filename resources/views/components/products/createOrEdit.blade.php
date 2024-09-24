<form action="{{ route('products.save', ['product' => $product]) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-8 mb-4">

                <div class="card">
                    <div class="card-body">
                        <h6 class="dash_head">Product Details</h6>

                        <div class="row row-cols-1">
                            <x-form.input name="name" wire:model="name" label="Title *" value="{{ $product?->name }}"
                                autofocus required />
                            {{-- <x-form.input name="strength" wire:model="strength" label="Strength"
                                value="{{ $product?->strength }}" /> --}}

                        </div>


                        <div class="row row-cols-1 tox-editor-container" wire:ignore>


                        </div>

                        <div class="row row-cols-2">

                            <x-form.input id="unit" name="unit" wire:model="unit" label="Unit"
                                value="{{ $product?->unit }}" />
                            <x-form.input id="price" name="price" wire:model="price" label="Unit Price (Tk) *"
                                value="{{ $product?->price }}" required />
                            {{-- <x-form.input id="trade_price" name="trade_price" wire:model="trade_price"
                                value="{{ $product?->trade_price }}" label="TP + Vat " />



                            <x-form.input name="strip_price" wire:model="strip_price" label="Strip Price (Tk)"
                                value="{{ $product?->strip_price }}" />


                            <x-form.input name="box_price" wire:model="box_price" label="Box Price (Tk)"
                                value="{{ $product?->box_price }}" />
                            @if ($product?->sku)
                                <x-form.input name="sku" wire:model="sku" label="Sku *"
                                    value="{{ $product?->sku }}" readonly />
                            @endif

                            <x-form.input name="box_size" wire:model="box_size" label="Box Pattern"
                                value="{{ $product?->box_size }}" /> --}}


                        </div>

                    </div>
                </div>

                <div class="card mt-4">

                    <div class="card-body">
                        <div class="row row-cols-2">
                            <x-form.input name="status" wire:model="status" value="{{ $product?->status }}"
                                type="select" label="Status" :options="[0 => 'False', 1 => 'True']" />
                            <x-form.input name="featured" wire:model="featured" value="{{ $product?->featured }}"
                                type="select" label="Featured" :options="[0 => 'False', 1 => 'True']" />
                            <x-form.input name="is_bonus" wire:model="is_bonus" value="{{ $product?->is_bonus }}"
                                type="select" label="Product Variation" :options="['Rate Product' => 'Rate Product', 'Bonus Product' => 'Bonus Product']" />
                            <x-form.input name="is_variable" value="{{ $product?->is_variable }}" type="select"
                                label="Is Variable" :options="[0 => 'False', 1 => 'True']" />

                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card ">
                    <div class="card-body">
                        <div class="row row-cols-1">
                            <x-form.input name="image" wire:model="image" value="{{ $product?->description }}"
                                type="file" label="Drag image to upload" style="padding:50px;" />

                            @if ($product?->image)
                                <img src="{{ $product?->image_url }}"
                                    style="height: 200px; width:200px;object-fit:cover" alt="">
                            @endif



                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body products-generic-card">
                        <div class="row row-cols-2">
                            <x-form.input name="category" wire:model="category" value="{{ $product?->category?->id }}"
                                type="select" label="Category" :options="$categories" />
                            {{-- <x-form.input name="generic" wire:model="generic" value="{{ $product?->generic?->id }}"
                                type="select" label="Generic" :options="$generics" />
                            <x-form.input name="supplier" value="{{ $product?->supplier?->id }}" type="select"
                                label="Supplier" :options="$suppliers" /> --}}

                            <x-form.input name="type" wire:model="type" value="{{ $product->type ?? '' }}"
                                type="select" label="type" :options="[
                                    'Tops' => 'Tops',
                                    'Bottoms' => 'Bottoms',
                                    'Dresses' => 'Dresses',
                                    'Outerwear' => 'Outerwear',
                                    'Activewear' => 'Activewear',
                                    'Underwear' => 'Underwear',
                                    'Swimwear' => 'Swimwear',
                                    'Footwear' => 'Footwear',
                                    'Accessories' => 'Accessories',
                                ]" />
                        </div>
                        <button class="btn btn-success" type="submit" style="float: right">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>

                </div>



            </div>




        </div>



</form>

<div id="attribute_variation"></div>
@if ($product?->is_variable && $product->id)
    <div class="card p-4">
        <div class="tabset">
            <!-- Attribute Tab -->
            <input type="radio" name="tabset" id="attribute-tab" aria-controls="attribute-panel"
                {{ session()->get('target') == 'attribute' ? 'checked' : '' }}>
            <label for="attribute-tab">Attributes</label>
            <!-- Variation Tab -->
            <input type="radio" name="tabset" id="variation-tab" aria-controls="variation-panel"
                {{ session()->get('target') == 'variation' ? 'checked' : '' }}>
            <label for="variation-tab">Variations</label>

            <div class="tab-panels">
                <!-- Attribute Panel -->
                <section id="attribute-panel" class="tab-panel">
                    <form action="{{ route('store.attribute') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="form-group">
                            <input type="text" class="form-control mb-2" name="attr_name"
                                placeholder="Color, Size etc" required>
                            <input type="text" class="form-control mt-2 mb-2" name="attr_value"
                                data-role="tagsinput"
                                placeholder="Attribute value comma separated (e.g., red, yellow, white)" required>
                            <button type="submit" class="btn btn-primary " title="save"><i
                                    class="fa fa-save"></i></button>
                        </div>
                    </form>
                    @foreach ($productAttributes as $product_attribute)
                        <?php $attribute_value = implode(',', $product_attribute->value); ?>
                        <form action="{{ route('update.attribute') }}" method="post">
                            @csrf
                            <div class="form-group mt-3">
                                <input type="text" class="form-control mb-2" name="attr_name"
                                    placeholder="Color, Size etc" required
                                    value="{{ str_replace('_', ' ', $product_attribute->name) }}">
                                <input type="hidden" value="{{ $product_attribute->id }}" name="attr_id">
                                <input class="form-control" name="attr_value" data-role="tagsinput"
                                    placeholder="Attribute value comma separated (e.g., red, yellow, white)"
                                    value="{{ str_replace('_', ' ', $attribute_value) }}" required>
                                <br>
                                <button type="submit" class="btn btn-primary"><i
                                        class="fas fa-check-circle"></i></button>
                                <a href="{{ route('delete.product.attribute', $product_attribute->id) }}"
                                    class="remove_button btn btn-danger bg-danger text-white" onclick="cskDelete()"><i
                                        class="fas fa-times-circle"></i></a>
                            </div>
                        </form>
                    @endforeach
                </section>

                <!-- Variation Panel -->
                <section id="variation-panel" class="tab-panel">
                    <a href="{{ route('create.all.variation', $product->id) }}" class="btn btn-primary btn-sm"
                        title="">Add All Variations
                    </a>
                    <a href="{{ route('new.variation', $product->id) }}" class="btn btn-primary btn-sm"
                        title="Add New">
                        <svg height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>


                    </a>

                    <a href="{{ route('delete.all.child', $product->id) }}"
                        class="btn btn-danger bg-danger text-white btn-sm" title="Delete All"><i
                            class="fas fa-ban"></i></a>
                    <section>
                        <div class="container">
                            <div id="accordion">
                                @if ($product->subproducts)
                                    @foreach ($product->subproducts as $variable_product)
                                        <div class="accordion-item" id="question{{ $variable_product->id }}">
                                            <a class="accordion-link" href="#question{{ $variable_product->id }}">

                                                <i class="icon ion-md-arrow-forward"></i>
                                                <i class="icon ion-md-arrow-down"></i>
                                            </a>
                                            <div class="answer">
                                                <form action="{{ route('update.variation', $variable_product->id) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="card-body row">
                                                        @foreach ($productAttributes as $product_attribute)
                                                            <?php
                                                            $name = $product_attribute->name;
                                                            $csk = $variable_product->variation->$name ?? false;
                                                            
                                                            ?>
                                                            <div class="form-group col-md-4">
                                                                <label
                                                                    for="variation[{{ $name }}]">{{ ucfirst($name) }}</label>
                                                                <select class="form-select py-1 px-2"
                                                                    name="variation[{{ $name }}]">
                                                                    @foreach ($product_attribute->value as $value)
                                                                        <option value="{{ $value }}"
                                                                            {{ $value == $csk ? 'selected' : '' }}>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @endforeach

                                                        <div class="form-group col-md-4">
                                                            <label for="variable_price">Price</label>
                                                            <input type="number" min="1" max="50000"
                                                                step="any" class="form-control"
                                                                name="variable_price" placeholder="Price"
                                                                value="{{ $variable_product->price }}" required>
                                                        </div>
                                                        {{-- <div class="form-group col-md-4">
                                                            <label for="sale_price">Sale Price</label>
                                                            <input type="number" min="1" max="50000"
                                                                step="any" class="form-control" name="sale_price"
                                                                placeholder="Sale Price"
                                                                value="{{ $variable_product->sale_price }}">
                                                        </div> --}}
                                                        <div class="form-group col-md-4">
                                                            <label for="variable_stock">In Stock</label>
                                                            <input type="number" min="1" max="50000"
                                                                step="any" class="form-control"
                                                                name="variable_stock" placeholder="Stock"
                                                                value="{{ $variable_product->quantity }}">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="variable_sku">SKU</label>
                                                            <input type="text" class="form-control"
                                                                name="variable_sku" placeholder="SKU"
                                                                value="{{ $variable_product->sku }}">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="image">Image</label>
                                                            <input type="file" class="form-control"
                                                                name="image">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <img src="{{ $variable_product->image }}"
                                                                style="width:100px">
                                                        </div>
                                                        <div class="form-group col-md-12 mt-2">
                                                            <button class="btn btn-outline-primary" type="submit"><i
                                                                    class="far fa-plus-square"></i></button>
                                                            <a href="{{ route('delete.product.meta', $variable_product->id) }}"
                                                                class="btn  btn-danger" onclick="cskDelete()"><i
                                                                    class="fas fa-minus-circle"></i></a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </section>

                </section>
            </div>
        </div>
    </div>

@endif
