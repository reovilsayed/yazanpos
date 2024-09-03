<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\User;
use App\Models\Generic;
use App\Models\Order;
use App\Models\Priscription;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PointOfSale extends Component
{



    private const CACHE_DURATION = 60;

    public $categoriesInput = [], $genericsInput = [], $suppliersInput = [], $customer;
    public $products, $query, $cart, $customers;
    public $categories, $generics, $suppliers;
    public $productDetails;
    public $showSideCart = true;
    public $customDiscount = false;

    public $payment = [
        'received_amount' => 0,
        'change_amount' => 0,
        'due_amount' => 0,
        'status' => 'Unpaid',
        'type' => 'Cash',
    ];

    public function mount()
    {
        $this->customer = request()->customer;
        $this->initializeCart();
        $this->initializeData();
    }

    public function updatedCustomer()
    {
        $this->customDiscount = false;
        $this->calculateCart();
    }

    public function addToCart(Product $product, $quantity = 1)
    {
        $cartProduct = $this->cart['products'][$product->id] ?? null;
        if ($cartProduct) {
            $batch = $product->batches->find($cartProduct['batch']);
        } else {
            $batch = $product->batches->first();
        }

        if ($batch && $this->hasEnoughQuantity($batch, $cartProduct, $quantity)) {

            if (!$cartProduct) {
                $this->initializeCartProduct($product, $batch);
            }

            $this->updateCartProduct($product, $batch, $quantity);

            $this->dispatchSuccessAlert($product->name);
        } else {
            $this->dispatch('alert', type: 'warning', message: "No quantity left");
        }

        $this->calculateCart();
    }

    protected function hasEnoughQuantity($batch, $cartProduct, $quantity)
    {
        return $batch->pivot->remaining_quantity >= ($cartProduct['batches'][$batch->id]['quantity'] ?? 0) + $quantity;
    }

    protected function initializeCartProduct($product, $batch)
    {
        $this->cart['products'][$product->id]['product'] = $product;
        $this->cart['products'][$product->id]['batch'] = $batch->id;
    }

    protected function updateCartProduct($product, $batch, $quantity)
    {
        $this->cart['products'][$product->id]['batches'][$batch->id]['quantity'] = $quantity + (@$this->cart['products'][$product->id]['batches'][$batch->id]['quantity'] ? $this->cart['products'][$product->id]['batches'][$batch->id]['quantity'] : 0);
        $this->cart['products'][$product->id]['quantity'] = $quantity + (@$this->cart['products'][$product->id]['quantity'] ? $this->cart['products'][$product->id]['quantity'] : 0);
        $this->cart['products'][$product->id]['sub_total'] = $product->price * $this->cart['products'][$product->id]['quantity'];
    }

    protected function calculateProfit($product)
    {
        $productID = $product->id;
        $batches = $this->cart['products'][$productID]['batches'];

        // Iterate through batches
        $totalProfit = 0;
        foreach ($batches as $batchID => $batch) {

            // Find the purchase with the given batch ID
            $purchase = $product->batches->find($batchID);
            // Check if the purchase and its products are not null
            $total = optional($purchase->pivot)->total ?? 0;
            $purchaseQuantity = optional($purchase->pivot)->purchase_quantity ?? 1;

            // Calculate profit
            $profit = $product->price - number_format($total / $purchaseQuantity, 2);

            // Accumulate total profit
            $totalProfit += $profit * $batch['quantity'];
        }

        // Assign the calculated total profit to the cart
        $this->cart['products'][$productID]['profit'] = $totalProfit;
        return $this->cart;
    }


    protected function dispatchSuccessAlert($productName)
    {
        $this->dispatch('alert', type: 'success', message: $productName . " added to cart");
    }


    public function removeFromCart(Product $product, $quantity = 1)
    {

        if (@$this->cart['products'][$product->id]) {
            if ($this->cart['products'][$product->id]['quantity'] == 1) {
                $this->deleteCartItem($product);
            } else {
                $current_batch = $this->cart['products'][$product->id]['batch'];
                if (@$this->cart['products'][$product->id]['batches'][$current_batch] && $this->cart['products'][$product->id]['batches'][$current_batch]['quantity'] - $quantity >= 0) {
                    $this->cart['products'][$product->id]['batches'][$current_batch]['quantity'] = (@$this->cart['products'][$product->id]['batches'][$current_batch]['quantity'] ?? 0) - $quantity;
                    $this->cart['products'][$product->id]['quantity'] -= $quantity;
                    $this->cart['products'][$product->id]['sub_total'] = $product->price * $this->cart['products'][$product->id]['quantity'];
                    $this->calculateCart();
                } else {
                    $this->deleteCartItem($product);
                }
            }
        }
    }

    public function deleteCartItem($product)
    {

        $this->dispatch('alert', type: 'warning', message: $product['name'] . "removed from cart");
        unset($this->cart['products'][$product['id']]);

        $this->calculateCart();
    }


    protected function calculateCart()
    {
        if ($this->customDiscount == false) {
            $this->cart['discount'] = 0;
            $customer = User::find($this->customer);
            if ($customer && $customer->discount) {
                $this->cart['discount'] = number_format($this->cart['total'] * ($customer->discount / 100), 2);
            }
        }

        $this->dispatch('added');
        $this->cart['total_quantity'] = 0;
        $this->cart['total'] = 0;


        foreach ($this->cart['products'] as $item) {
            $this->cart['total_quantity'] += $item['quantity'];
            $this->cart['total'] += $item['sub_total'];
        }

        $this->cart['grand_total'] = $this->cart['total'] - (int) $this->cart['discount'];
        $this->payment['received_amount'] = $this->cart['grand_total'];
        $this->payment['status'] = "PAID";

        session()->put('cart', $this->cart);
    }

    public function resetCart()
    {
        $this->restore();
        $this->calculateCart();
    }
    public function updatedGenericsInput()
    {
        $this->fetchProducts();
    }
    public function updatedSuppliersInput()
    {
        $this->fetchProducts();
    }
    public function updatedCategoriesInput()
    {
        $this->fetchProducts();
    }
    public function updated($event)
    {


        if ($event == 'cart.products') {
            if (count($this->cart['products']) == 0) {
                $this->restore();
            }
        }
        if ($event == 'cart.discount') {

            if ($this->cart['discount'] <= -1) {
                $this->dispatch('alert', type: 'warning', message: "Discount amount can not be less then 0");
                $this->cart['discount'] = 0;
            }
            if ($this->cart['discount'] > $this->cart['total']) {
                $this->dispatch('alert', type: 'warning', message: "Discount amount exceed total amount");
                $this->cart['discount'] = 0;
            }

            $this->calculateCart();
        }
        if ($event == 'payment.received_amount' || $event == 'cart.discount') {
            if ($this->payment['received_amount'] <= -1) {
                $this->dispatch('alert', type: 'warning', message: "Received amount can not be less then 0");
                $this->payment['received_amount'] = 0;
            }
            if (is_numeric($this->payment['received_amount']) == false) {
                $this->dispatch('alert', type: 'warning', message: "Received amount must be a number");
                $this->payment['received_amount'] = 0;
            }
            if ($this->payment['received_amount'] >= $this->cart['grand_total']) {
                $this->payment['change_amount'] = $this->payment['received_amount'] - $this->cart['grand_total'];
                $this->payment['due_amount'] = 0;
                $this->payment['status'] = 'Paid';
            } else {
                $this->payment['change_amount'] = 0;
                $this->payment['due_amount'] =  $this->cart['grand_total'] - $this->payment['received_amount'];
                $this->payment['status'] = 'Due';
            }
        }
    }






    public function updatedQuery()
    {

        $this->fetchProducts();
    }

    public function setProductDetails(Product $product)
    {

        $this->productDetails = $product;
        $this->dispatch('showProductDetails');
    }

    protected function fetchProducts()
    {

        $this->products = Product::has('batches')->mostSold()
            ->when($this->categoriesInput, function ($query) {
                $query->whereIn('category_id', array_values($this->categoriesInput));
            })
            ->when($this->suppliersInput, function ($query) {
                $query->whereIn('supplier_id', array_values($this->suppliersInput));
            })
            ->when($this->genericsInput, function ($query) {
                $query->whereIn('generic_id', array_values($this->genericsInput));
            })
            ->when($this->query, function ($query) {
                $query->where('name', 'LIKE', '%' . $this->query . '%')->orWhere('sku', 'LIKE', '%' . $this->query . '%')
                    ->whereHas('generic', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->query . '%');
                    })
                    ->whereHas('supplier', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->query . '%');
                    })
                    ->whereHas('category', function ($query) {
                        $query->where('name', 'LIKE', '%' . $this->query . '%');
                    });
            })
            ->take(50)
            ->get();
    }

    protected function restore()
    {
        $this->payment = [
            'received_amount' => 0,
            'change_amount' => 0,
            'due_amount' => 0,
            'status' => 'Unpaid',
            'type' => 'Cash'
        ];
        $this->cart = [
            'products' => [],
            'discount' => 0,
            'profit' => 0,
            'total' => 0,
            'grand_total' => 0,
            'total_quantity' => 0,
        ];
        session()->forget('cart');
    }

    public function complete()
    {
        $data = [];

        foreach ($this->cart['products'] as $id => $product) {
            $this->calculateProfit($product['product']);
        }

        foreach ($this->cart['products'] as $id => $product) {

            $this->cart['profit'] += $product['profit'];
            $data[$id] = [
                'quantity' => $product['quantity'],
                'price' => $product['sub_total'],
                'profit' => $product['profit']
            ];
            $prod = $product['product'];
            $prod->increment('sold_unit', $product['quantity']);

            foreach ($product['batches'] as $batch => $item) {

                $purchase = $prod->batches->find($batch);

                $purchase->pivot->remaining_quantity -= $item['quantity'];
                $purchase->pivot->save();
            }
        }
        $order = Order::create([
            'customer_id' => $this->customer,
            'sub_total' => $this->cart['total'],
            'discount' => $this->cart['discount'],
            'total' => $this->cart['grand_total'],
            'payment_method' => $this->payment['type'],
            'paid' => $this->payment['received_amount'] - $this->payment['change_amount'],
            'due' => $this->payment['due_amount'],
            'status' => $this->payment['status'],
            'profit' => $this->cart['profit'],
            'created_at' => now()
        ]);


        $order->products()->sync($data);
        $this->restore();
        $this->dispatch('closeModal');
        $this->dispatch('alert', type: 'success', message: "Order created");
    }

    public function addGenericToFilter($generic)
    {
        if (!in_array($generic, $this->genericsInput)) {
            array_push($this->genericsInput, $generic);
        } else {
            unset($this->genericsInput[array_search($generic, $this->genericsInput)]);
        };
        $this->dispatch('genericAdded', $generic);
        $this->fetchProducts();
    }
    public function render()
    {
        return view('livewire.point-of-sale');
    }


    private function initializeCart()
    {


        $this->cart = session('cart', [
            'products' => [],
            'discount' => 0,
            'profit' => 0,
            'total' => 0,
            'grand_total' => 0,
            'total_quantity' => 0,
        ]);

        if (request()->filled('prescription')) {
            $prescription = Priscription::find(request()->prescription);
            if ($prescription) {
                $this->customer = $prescription->customer_id;
                foreach ($prescription->products as $product) {
                    $this->addToCart($product);
                }
            }
        }
    }

    private function initializeData()
    {
        $this->fetchProducts();

        $this->customers = Cache::remember('customers', self::CACHE_DURATION, function () {
            return User::all();
        });

        $this->categories = Cache::remember('categories', self::CACHE_DURATION, function () {
            return Category::pluck('name', 'id')->toArray();
        });

        $this->generics = Cache::remember('generics', self::CACHE_DURATION, function () {
            return Generic::pluck('name', 'id')->toArray();
        });

        $this->suppliers = Cache::remember('suppliers', self::CACHE_DURATION, function () {
            return Supplier::pluck('name', 'id')->toArray();
        });
    }
}
