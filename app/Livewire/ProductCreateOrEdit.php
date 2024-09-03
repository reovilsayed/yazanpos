<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Generic;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProductCreateOrEdit extends Component
{
    use WithFileUploads;
    public $generics;
    public $categories;
    public $errors = [];
    public $suppliers;
    public $units;
    public $product;



    #[Validate]
    public $variations;
    public $name;
    public $image;
    public $unit;
    public $price;
    public $strip_price;
    public $box_price;
    public $status;
    public $featured;
    public $category;
    public $generic;
    public $supplier;
    public $description;
    public $barcode;
    public $edit;
    public $unit_id;
    public $trade_price;
    public $is_bonus;
    public $box_size;
    public $strength;
    public $type;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'image' => 'nullable|image|max:1024',
            'unit' => 'nullable|string',
            'price' => 'required|min:1',
            'strip_price' => 'nullable|min:1',
            'box_price' => 'nullable|min:1',
            'status' => 'nullable',
            'featured' => 'nullable',
            'category' => 'nullable|exists:categories,id',
            'generic' => 'nullable|exists:generics,id',
            'supplier' => 'nullable|exists:suppliers,id',
            'description' => 'nullable',
            'trade_price' => 'nullable',
            'is_bonus' => 'nullable',
            'box_size' => 'nullable',
            'strength' => 'nullable',
            'type' => 'nullable',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $this->product->name = $this->name;
        // $this->product->sku = $this->sku;
        if ($this->image) {
            if ($this->edit && $this->product->image && Storage::exists($this->product->image)) {
                Storage::delete($this->product->image);
            }

            $this->product->image = $this->image->store('product');
        }
        $this->product->barcode = $this->barcode;
        $this->product->price = $this->price;
        $this->product->strip_price = $this->strip_price;
        $this->product->box_price = $this->box_price;
        $this->product->status = $this->status;
        $this->product->featured = $this->featured;
        $this->product->category_id = $this->category;
        $this->product->generic_id = $this->generic;
        $this->product->supplier_id = $this->supplier;
        $this->product->description = $this->description;
        $this->product->trade_price = $this->price * .88;
        $this->product->is_bonus = $this->is_bonus;
        $this->product->box_size = $this->box_size;
        $this->product->strength = $this->strength;
        $this->product->type = $this->type;
        $this->product->unit = $this->unit;




        $this->product->save();

        session()->flash('success',  'Product updated successfully');
        return redirect()->back();
    }

    public function mount()
    {
        $this->variations = session()->get('variation_array') ?? [];
        $this->generics = Generic::all()->pluck('name', 'id')->toArray();
        $this->categories = Category::all()->pluck('name', 'id')->toArray();
        $this->suppliers = Supplier::all()->pluck('name', 'id')->toArray();
        $this->units = Unit::all()->pluck('name', 'id')->toArray();

        $this->name = $this->product->name ?? old('name');
        $this->unit = $this->product->unit ?? old('unit');
        $this->price = $this->product->price ?? old('price');
        $this->strip_price = $this->product->strip_price ?? old('strip_price');
        $this->box_price = $this->product->box_price ?? old('box_price');
        $this->status = $this->product->status ?? old('status');
        $this->featured = $this->product->featured ?? old('featured');
        $this->category = $this->product->category_id ?? old('category_id');
        $this->generic = $this->product->generic_id ?? old('generic_id');
        $this->supplier = $this->product->supplier_id ?? old('supplier_id');
        $this->description = $this->product->description ?? old('description');
        $this->barcode = $this->product->barcode ?? old('barcode');
        $this->unit_id = $this->product->unit_id ?? old('unit_id');
        $this->trade_price = $this->product->trade_price ?? old('trade_price');
        $this->is_bonus = $this->product->is_bonus ?? old('is_bonus');
        $this->box_size = $this->product->box_size ?? old('box_size');
        $this->strength = $this->product->strength ?? old('strength');
        $this->type = $this->product->type ?? old('type');
    }


    public function render()
    {
        return view('livewire.product-create-or-edit');
    }
}
