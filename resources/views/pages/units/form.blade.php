<div class="row row-cols-2">
    <x-form.input type="text" name="name" label="Name" value="{{ old('name', $unit->name) }}" />
    <x-form.input type="number" min="0" name="quantity" label="Quantity"
        value="{{ old('quantity', $unit->quantity) }}" />

</div>
<button class="btn btn-sm btn-primary">
    <i class="fa fa-save "></i> Save
</button>
