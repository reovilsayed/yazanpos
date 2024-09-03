@push('styles')
    <style>
        .product-card {
            position: relative;
        }

        .delete-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            font-size: 12px;
            position: absolute;
            right: 1px;
            z-index: 10;
        }

        .generic-btn {
            font-size: 10px;
            position: absolute;
            bottom: -8px;
            right: 0;
            z-index: 10;
        }

        .custom-card {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            position: relative;
            cursor: pointer;
        }

        .product-selected {
            border: 2px solid #007bff;
        }

        .no-quantity {
            border: 2px solid #dc3545;
        }

        .badge {
            background-color: #007bff;
            position: absolute;
            top: 0;
            right: 0;
            color: #fff;
            padding: 4px 8px;
        }

        .card-header img {
            height: 120px;
            width: 100%;
            object-fit: cover;
        }

        .card-body {
            padding: 8px;
        }

        .card-body p {
            margin: 0;
            font-size: 16px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .card-body small {
            display: block;
            margin-top: 4px;
            font-size: 12px;
        }
    </style>
@endpush
<div class="product-card">
    @if (@$cart['products'][$product->id])
        <button class="delete-btn" style="height:20px;width:20px;border-radius:50%;top:-10px;left:-10px"
            wire:click.debounce.0ms="deleteCartItem({{ $cart['products'][$product->id]['product'] }})"><i
                class="fa fa-times"></i></button>
    @endif

    <div
        class="custom-card @if (@$cart['products'][$product->id]) product-selected @endif @if (!$product->hasQuantity()) no-quantity @endif">
        <span class="badge">{{ Settings::price($product->price) }}</span>

        <div class="card-header" wire:click.debounce.0ms="addToCart({{ $product }},0)">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
        </div>
        <div class="card-body position-relative">
            <p title="{{ $product->name }}" class="d-flex gap-2">{{ Str::limit($product->name, 15, '..') }} <small
                    class="text-secondary">( {{ $product->category?->name }} )</small></p>

            <small class="@if (in_array($product->generic_id, $genericsInput)) text-primary @else text-secondary @endif "
                wire:click.debounce.0ms="addGenericToFilter({{ $product->generic_id }})">{{ Str::limit($product->generic?->name, 30) }}</small>

            <button  wire:click.debounce.0ms="setProductDetails({{$product->id}})"
                class="btn btn-primary btn-sm position-absolute rounded-circle"
                style="font-size: 10px;right:5px;bottom:50px"><i class="fa fa-info"></i></button>
        </div>

    </div>
</div>
