<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Mail\PurchasesMailForShopOwner;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Generic;
use App\Models\Order;
use App\Models\Priscription;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Settings;

class ApiController extends Controller
{


    public function pos(Request $request)
    {
        $products = Product::with('attributes')->whereNull('parent_id')->when(Settings::option('manageStock') == 1, function ($query) {
            return $query->has('batches');
        })->mostSold()
            ->when($request->categoriesInput, function ($query) use ($request) {
                $categories = is_array($request->categoriesInput) ? $request->categoriesInput : explode(',', $request->categoriesInput);
                $query->whereIn('category_id', $categories);
            })
            ->when($request->suppliersInput, function ($query) use ($request) {
                $suppliers = is_array($request->suppliersInput) ? $request->suppliersInput : explode(',', $request->suppliersInput);
                $query->whereIn('supplier_id', $suppliers);
            })
            ->when($request->genericsInput, function ($query) use ($request) {
                $generics = is_array($request->genericsInput) ? $request->genericsInput : explode(',', $request->genericsInput);
                $query->whereIn('generic_id', $generics);
            })

            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', "%$request->search%")
                    ->orWhere('sku', 'LIKE', "%$request->search%")
                    ->where(function ($query) use ($request) {
                        $query->whereHas('generic', function ($query) use ($request) {
                            $query->where('name', 'LIKE', "%$request->search%");
                        })
                            ->orWhereHas('supplier', function ($query) use ($request) {
                                $query->where('name', 'LIKE', "%$request->search%");
                            })
                            ->orWhereHas('category', function ($query) use ($request) {
                                $query->where('name', 'LIKE', "%$request->search%");
                            });
                    })->orderByRaw("CASE WHEN name = '$request->search' THEN 1 ELSE 2 END");
            })
            ->paginate(24);
        return response()->json($products);
    }
    public function products(Request $request)
    {
        $request->validate(['q' => 'required']);

        $query = Product::where('name', 'LIKE', '%' . $request->input('q') . '%');

        if (Settings::option('manageStock') == 1) {
            $query->has('batches');
        }

        $products = $query->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'text' => $product->name . ' ' . $product->strength . ' ' . $product->category->name
            ];
        });

        return response()->json($products);
    }
    public function customers(Request $request)
    {
        $customers = User::where('name', 'LIKE', '%' . $request->input('q') . '%')->orWhere('phone', 'LIKE', '%' . $request->input('q') . '%')->get()->map(function ($customer) {
            return [
                'id' => $customer->id,
                'text' => $customer->phone . ' (' . $customer->name . ')' . ' (' . $customer->address . ')',
            ];
        })->toArray();


        return response()->json($customers);
    }

    public function singleCustomer(Request $request)
    {
        $request->validate(['id' => 'required']);
        $customer = User::where('id', $request->id)->firstOrFail();
        return response()->json($customer);
    }
    public function suppliers(Request $request)
    {
        return Supplier::where('name', 'LIKE', '%' . $request->input('q') . '%')->get()->map(function ($supplier) {
            return [
                'id' => $supplier->id,
                'text' => $supplier->name
            ];
        });
    }
    public function generics(Request $request)
    {
        return Generic::where('name', 'LIKE', '%' . $request->input('q') . '%')->get()->map(function ($generic) {

            return [
                'id' => $generic->id,
                'text' => $generic->name
            ];
        });
    }
    public function categories(Request $request)
    {
        return Category::where('name', 'LIKE', '%' . $request->input('q') . '%')->get()->map(function ($category) {

            return [
                'id' => $category->id,
                'text' => $category->name
            ];
        });
    }
    public function orderCreate(Request $request)
    {
        $emailTo = Settings::option('email');
        $customProducts = [];
        $data = [];
        foreach ($request->cartInfo['products'] as $id => $product) {
            if (Str::startsWith($product['id'], 'custom-')) {
                $customProducts[] = [
                    'name' => $product['name'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'profit' => 0,
                ];
            } else {
                $data[$id] = [
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'profit' => 0,
                ];
            }
        }

        if ($request->cartInfo['discount'] > $request->cartInfo['sub_total'] * .12) {
            $discount = $request->cartInfo['sub_total'] * .10;
        } else {
            $discount = $request->cartInfo['discount'];
        }
        $subTotal = $request->cartInfo['sub_total'];
        $total = $subTotal - ($discount ?? 0);

        $paid = $request->paymentInfo['received_amount'] - $request->paymentInfo['change_amount'];
        $due = $total - $paid;
        $orderData = [
            'sub_total' => $request->cartInfo['sub_total'],
            'discount' => $discount,
            'total' => $total,
            'paid' => $paid,
            'due' => $due,
            'notes' => $request->paymentInfo['notes'],
            'status' => $request->paymentInfo['status'],
            'profit' => 0,
            'split_payment' => json_encode($request->paymentInfo['split_payment'])
        ];

        if (isset($request->paymentInfo['customer_id'])) {
            $orderData['customer_id'] = $request->paymentInfo['customer_id'];
        } else {
            if ($due > 0) {
                $errorMessage = "Walk in customers cannot keep due.";
                return response()->json(['error' => $errorMessage], 400);
            }
        }

        $order = Order::create($orderData);

        foreach ($customProducts as $product) {
            if (auth()->user()->role->hasPermissionTo('create product')) {
                $newProduct = Product::create([
                    'name' => $product['name'],
                    'price' => $product['price'],
                ]);
                $data[] = [
                    'product_id' => $newProduct->id,
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'profit' => 0,
                ];
            } else {
                DB::table('order_product')->insert([
                    'order_id' => $order->id,
                    'name' => $product['name'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'profit' => 0,
                ]);
            }
        }
        $order->products()->sync($data);
        $profit = 0;
        foreach ($order->products as $product) {
            $profit += ($product->pivot->price - $product->trade_price) * $product->pivot->quantity;
            $product->sold_unit = $product->sold_unit + $product->pivot->quantity;
            $product->save();
        }
        $profit -= $order->discount;

        $order->profit = $profit;
        $order->save();

        try {
            Mail::to($emailTo)->send(new PurchasesMailForShopOwner($order));
            if (isset($request->cartInfo['order_from'])) {
                $order->order_from = $request->cartInfo['order_from'];
                $order->delivered = 0;
                $order->save();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email.']);
        }
        if ($order->customer_id && $order->customer->email) {
            $customerEmailTo = $order->customer->email;

            try {
                Mail::to($customerEmailTo)->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to send email to customer.']);
            }
        }
        return response()->json(['success' => 'Order created successfully ' . $order->id]);
    }
    public function customerCreate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'phone' => ['required', 'string', 'digits:11', Rule::unique('users')->ignore(auth()->id())],
            'email' => ['nullable', 'string', 'email'],
            'address' => ['required', 'string'],
        ]);
        $data = $request->only('name', 'email', 'phone', 'address', 'discount');
        $data['role_id'] = 2;
        User::create($data);
        return response()->json([
            $message = 'Customer created successfully'
        ]);
    }

    public function prescription(Request $request)
    {
        $prescription = Priscription::with('products', 'customer')->find($request->prescription);

        return $prescription;
    }
    public function reports(Request $request)
    {
        $orders = Order::filterByDate()->get();
        $due_orders = Order::filterByDate()->where('due', '>', 0)->get();
        $customers = User::where('role_id', 2)->get();
        $generics = Generic::get();
        $categories = Category::get();
        $suppliers = Supplier::get();

        $top_customers = User::where('role_id', 2)->with(['orders' => function ($query) {
            $query->filterByDate();
        }])
            ->get()
            ->sortByDesc(function ($customer) {
                return $customer->orders->sum('total');
            })
            ->take(10);

        $top_products = Product::with(['orders' => function ($query) {
            $query->filterByDate('orders.created_at');
        }])
            ->get()
            ->sortByDesc(function ($product) {
                return $product->orders->sum('pivot.price');
            })
            ->take(10);

        $topSuppliers = Supplier::with(['products.orders' => function ($query) {
            $query->filterByDate('orders.created_at');
        }])
            ->get()
            ->sortByDesc(function ($supplier) {
                return $supplier->products->sum(function ($product) {
                    return $product->orders->sum('pivot.price');
                });
            })
            ->take(10);

        $topDueCustomers = User::where('role_id', 2)->with(['orders' => function ($query) {
            $query->where('due', '>', 0)->filterByDate();
        }])
            ->get()
            ->sortByDesc(function ($customer) {
                return $customer->orders->sum('due');
            })
            ->take(10);

        $mapCustomer = function ($customer) {
            return [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'total_order_amount' => $customer->orders->sum('total'),
            ];
        };

        $mapProduct = function ($product) {
            return [
                'product_id' => $product->id,
                'product_name' => $product->name,
                // 'product_strenght' => $product->strenght,
                'product_category' => $product->category->name ?? '',
                'total_price' => $product->orders->sum('pivot.price'),
            ];
        };

        $mapSupplier = function ($supplier) {
            return [
                'supplier_id' => $supplier->id,
                'supplier_name' => $supplier->name,
                'total_amount' => $supplier->products->sum(function ($product) {
                    return $product->orders->sum('pivot.price');
                }),
            ];
        };

        return response()->json([
            'total_orders' => $orders->count(),
            'total_amount' => $orders->sum('total'),
            'due_orders' => $due_orders->count(),
            'due_total' => $due_orders->sum('due'),
            'total_revenue' => $orders->sum('profit'),
            'total_customers' => $customers->count(),
            'total_generics' => $generics->count(),
            'total_categories' => $categories->count(),
            'total_suppliers' => $suppliers->count(),
            'top_customers' => $top_customers->map($mapCustomer)->values(),
            'top_selling_products' => $top_products->map($mapProduct)->values(),
            'top_suppliers' => $topSuppliers->map($mapSupplier)->values(),
            'top_due_customers' => $topDueCustomers->map($mapCustomer)->values(),
        ]);
    }

    function getVariationPrice(Request $request)
    {
        $request->validate([
            'parent_id' => 'required',
            'variation' => 'required',
        ]);

        $parentId = $request->input('parent_id');
        $variation = $request->input('variation');

        $product = Product::where('parent_id', $parentId)
            ->whereJsonContains('variation', $variation)
            ->first();

        if ($product) {
            return response()->json(['price' => $product->price], 200);
        } else {
            $product = Product::where('id', $parentId)->firstOrFail();
            if ($product) {
                return response()->json(['price' => $product->price], 200);
            } else {
                return response()->json(['message' => 'Product not found'], 404);
            }
        }
    }
}
