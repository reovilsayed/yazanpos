<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PurchaseRequestCreateOrEdit extends Component
{
    public $products;
    public $suppliers;
    public $units;

    public $purchase;
    public $edit = false;


    #[Validate]

    public $productList = [
        [
            'batch_name' => '',
            'medicine_id' => '',
            'manufacture_date' => '',
            'expiry_date' => '',
            'unit_id' => '',
            'unit_qty' => 0,
            'qty' => 0,
            'unit_supplier_rate' => 0,
            'total_purchase_price' => 0,
        ]
    ];

    public $cart = [
        'sub_total' => 0,
        'vat' => 0,
        'discount' => 0,
        'grand_total' => 0,
        'paid_amount' => 0,
        'due_amount' => 0,
    ];

    public $supplierI;
    public $active = false;
    public $purchase_date;
    public $details;
    public $batch_name;
    public $payment_method = 'Cash';
    public $invoice_no;

    public function rules()
    {
        // after_or_equal:productList.*.manufacture_date'
        return [
            'productList' => 'required',
            'productList.*.batch_name' => 'nullable',
            'productList.*.medicine_id' => 'nullable|exists:products,id',
            'productList.*.manufacture_date' => 'nullable|date',
            'productList.*.expiry_date' => 'nullable|date',
            'productList.*.unit_id' => 'nullable',
            'productList.*.unit_qty' => 'nullable|integer',
            'productList.*.qty' => 'nullable|integer',
            'productList.*.unit_supplier_rate' => 'nullable|numeric',
            'productList.*.total_purchase_price' => 'nullable|numeric',
            'cart' => 'required',
            'cart.sub_total' => 'required',
            'cart.vat' => 'required',
            'cart.discount' => 'required',
            'cart.grand_total' => 'required',
            'cart.paid_amount' => 'required',
            'cart.due_amount' => 'required',
            'supplierI' => 'required|exists:suppliers,id',
            'purchase_date' => 'required',
            'details' => 'nullable',
            'payment_method' => 'required',
            'invoice_no' => 'nullable',
            'active' => 'required'

        ];
    }

    public function save()
    {


        $this->validate();
        DB::beginTransaction();
        $this->productList = array_filter($this->productList, function ($product) {

            if (empty($product['medicine_id'])) {

                return false;
            } else {
                return true;
            }
        });
        $data = array_map(function ($product) {

            return [
                'batch_name' => $product['batch_name'],
                'product_id' => $product['medicine_id'],
                'manufacture_date' => empty($product['manufacture_date']) ? null : $product['manufacture_date'],
                'expiry_date' => empty($product['expiry_date']) ? null : $product['expiry_date'],
                'purchased_unit' => $product['unit_id'],
                'purchase_unit_quantity' => $product['unit_qty'],
                'purchase_quantity' => $product['qty'],
                'remaining_quantity' => $product['qty'],
                'supplier_rate' => $product['unit_supplier_rate'],
                'total' => $product['total_purchase_price'],

            ];
        }, $this->productList);


        $purchaseRequest = $this->purchase;

        $purchaseRequest->supplier_id = $this->supplierI;
        $purchaseRequest->active = $this->active;
        $purchaseRequest->invoice = $this->invoice_no;
        $purchaseRequest->payment_type = $this->payment_method;
        $purchaseRequest->purcahsed_at = $this->purchase_date;
        $purchaseRequest->details = $this->details;
        $purchaseRequest->subtotal = $this->cart['sub_total'];
        $purchaseRequest->vat = $this->cart['vat'];
        $purchaseRequest->discount = $this->cart['discount'];
        $purchaseRequest->grand_total = $this->cart['grand_total'];
        $purchaseRequest->paid_amount = $this->cart['paid_amount'];
        $purchaseRequest->due_amount = $this->cart['due_amount'];

        if ($this->cart['due_amount'] > 0 || $this->cart['grand_total'] == 0) {
            $purchaseRequest->status = 'DUE';
        } else {
            $purchaseRequest->status = 'PAID';
        }
        $purchaseRequest->save();
        $purchaseRequest->products()->sync($data);
        DB::commit();
        session()->forget('purchase_cart');
        session()->forget('productList');
        $this->dispatch('alert', type: 'success', message: $this->edit ? 'Purchase updated' : 'Purchase Created');
        if (!$this->edit) {
            $this->restore();
        }
        if ($this->edit) {
            return redirect()->route('purchase.index')->with('success', 'Purchase Request Updated');
        }
    }
    public function addProductToList()
    {
        array_push($this->productList, [
            'batch_name' => '',
            'medicine_id' => '',
            'manufacture_date' => '',
            'expiry_date' => '',
            'unit_id' => '',
            'unit_qty' => 0,
            'qty' => 0,
            'unit_supplier_rate' => 0,
            'total_purchase_price' => 0,
        ]);
    }

    public function removeProductFromList($key)
    {
        $clone = $this->productList;

        unset($clone[$key]);

        $this->productList = [];
        foreach ($clone as $item) {
            array_push($this->productList, $item);
        }
        $this->calculate();
    }

    public function mount()
    {
        $this->supplierI = $this->purchase->supplier_id ?? Supplier::first()->id;

        $this->suppliers = Supplier::select('name', 'id')->get()->pluck('name', 'id')->toArray();
        $this->units = Unit::select('name', 'id')->get()->pluck('name', 'id')->toArray();
        $this->products = Product::select('id', 'name')->where('supplier_id', $this->supplierI)->get()->pluck('name', 'id')->toArray();


        $this->payment_method = 'Cash';
        $this->purchase_date = now()->format('Y-m-d');
        if ($this->edit) {
            $this->purchase_date = $this->purchase->purcahsed_at->format('Y-m-d');
            $this->details = $this->purchase->details;
            $this->batch_name = $this->purchase->batch_name;
            $this->payment_method = $this->purchase->payment_type;
            $this->invoice_no =  $this->purchase->invoice;
        }

        $this->cart = [
            'sub_total' => $this->purchase->subtotal ?? 0,
            'vat' => $this->purchase->vat ?? 0,
            'discount' => $this->purchase->discount ?? 0,
            'grand_total' => $this->purchase->grand_total ?? 0,
            'paid_amount' => $this->purchase->paid_amount ?? 0,
            'due_amount' => $this->purchase->due_amount ?? 0,
        ];

        if (session()->has('purchase_cart')) {
            $this->cart = session()->get('purchase_cart');
        }


        if ($this->purchase->products->count()) {

            $this->productList =  $this->purchase->products->map(function ($product) {
                return [
                    'batch_name' => $product->pivot->batch_name,
                    'medicine_id' => $product->id,
                    'manufacture_date' => $product->pivot->manufacture_date,
                    'expiry_date' => $product->pivot->expiry_date,
                    'unit_id' => $product->pivot->purchased_unit,
                    'unit_qty' => $product->pivot->purchase_unit_quantity,
                    'qty' => $product->pivot->remaining_quantity,
                    'unit_supplier_rate' => $product->pivot->supplier_rate,
                    'total_purchase_price' => $product->pivot->total,

                ];
            })->toArray();
        }
    }

    public function updatedSupplierI()
    {
        $this->products = Product::select('id', 'name')->where('supplier_id', $this->supplierI)->get()->pluck('name', 'id')->toArray();
    }

    public function updatedProductList($event, $key)
    {
        $index = explode('.', $key)[0];
        @$key =  explode('.', $key)[1];

        if (in_array($key, ['unit_qty', 'unit_supplier_rate'])) {
            if (!is_numeric($event)) {
                $this->productList[$index][$key] = 0;
            }
            $this->calculate();
        }
        if ($key == 'unit_id') {
            if (!$event) {
                $this->productList[$index]['unit_qty'] = 0;
                $this->productList[$index]['qty'] = 0;
                $this->productList[$index]['unit_supplier_rate'] = 0;
                $this->productList[$index]['total_purchase_price'] = 0;
            }
        }
        if (in_array($key, [
            'medicine_id',
            'expiry_date',
            'unit_id',
            'unit_qty',
            'unit_supplier_rate',
            'total_purchase_price',
        ]) && $this->productList[$index]['unit_id'] && $this->productList[$index]['unit_qty']) {
            $product = Product::find($this->productList[$index]['medicine_id']);
            $this->productList[$index]['qty'] =  $this->productList[$index]['unit_qty'] * Unit::find($this->productList[$index]['unit_id'])->quantity;
            $this->productList[$index]['total_purchase_price'] =  $this->productList[$index]['unit_supplier_rate'] * $this->productList[$index]['qty'];
        }
        $this->calculate();
    }

    public function restore()
    {

        $this->productList = [
            [
                'medicine_id' => '',
                'manufacture_date' => '',
                'expiry_date' => '',
                'unit_id' => '',
                'unit_qty' => 0,
                'qty' => 0,
                'unit_supplier_rate' => 0,
                'total_purchase_price' => 0,
            ]
        ];

        $this->cart = [
            'sub_total' => 0,
            'vat' => 0,
            'discount' => 0,
            'grand_total' => 0,
            'paid_amount' => 0,
            'due_amount' => 0,
        ];

        $this->supplierI = null;
        $this->purchase_date = null;
        $this->details = null;
        $this->batch_name = null;
        $this->payment_method = null;
        $this->invoice_no = null;
    }
    public function updatedCart($value, $key)
    {
        if (!is_numeric($value)) {
            $this->cart[$key] = 0;
        }
        if ($key == 'paid_amount' && $value > $this->cart['grand_total']) {
            $this->cart['paid_amount'] =  $this->cart['grand_total'];
        }
        $this->calculate();
    }

    protected function calculate()
    {
        $this->cart['sub_total'] = 0;
        foreach ($this->productList as $list) {
            $this->cart['sub_total'] += $list['total_purchase_price'];
        }

        $this->cart['grand_total'] = ($this->cart['sub_total'] + $this->cart['vat']) - $this->cart['discount'];
        $this->cart['due_amount'] = $this->cart['grand_total'] - $this->cart['paid_amount'];

        session()->put('purchase_cart', $this->cart);
    }

    public function updated($key, $value)
    {
        if (explode('.', $key)[0] == 'productList') {
            if (explode('.', $key)[2] == 'medicine_id') {
                $product = Product::find($value);
                if ($product->box_size != null) {
                    $unit = Unit::where('name', $product->box_size)->first();
                } else {
                    $unit = Unit::where('name', '1 X 1')->first();
                }

                $this->productList[explode('.', $key)[1]]['unit_id'] = $unit->id;
                $this->productList[explode('.', $key)[1]]['unit_supplier_rate'] = $product->trade_price;
            }
        }
    }

    public function render()
    {
        return view('livewire.purchase-request-create-or-edit');
    }
}
