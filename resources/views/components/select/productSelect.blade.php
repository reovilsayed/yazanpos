@props(['product' => null])
<select {{ $attributes }} class="products-ajax">
    @if ($product)
        <option value="{{ $product->id }}" selected>{{ $product->name }}</option>
    @endif
</select>
