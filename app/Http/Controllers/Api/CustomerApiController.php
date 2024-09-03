<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SingleOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerApiController extends Controller
{
    public function customer()
    {
        return auth()->user();
    }
    public function update_profile(Request $request)
    {


        $request->validate([
            'name' => ['required', 'string'],
            'phone' => ['required', 'string', 'digits:11', Rule::unique('users')->ignore(auth()->id())],
            'email' => ['nullable', 'string','email'],
            'address' => ['required', 'string'],
        ]);

        $data =  [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        auth()->user()->update($data);
        $user = auth()->user();
        return response()->json([
            'Message' => 'Customer Edit Success!',
            'User' => $user,
        ]);
    }
    public function orders(Request $request)
    {
        $request->validate([
            'customer_id' => ['integer', 'required']
        ]);
        $orders = Order::where('customer_id', $request->customer_id)->latest()->get();
        return response()->json([
            'orders' => $orders
        ]);
    }

    public function orderSingle($order)
    {

        $singleOrder = Order::with('products')->findOrFail($order);
        return SingleOrderResource::make($singleOrder);
    }
    public function reports(Request $request)
    {
        $totalOrders = Order::where('customer_id', auth()->id())->count();
        $totalOrderAmount = Order::where('customer_id', auth()->id())->sum('total');
        $totalDueOrders = Order::where('customer_id', auth()->id())->where('due', '>', '0')->count();
        $totalOrderDueAmount = Order::where('customer_id', auth()->id())->sum('due');
        $data = [
            'total_orders' => $totalOrders,
            'total_order_amount' => $totalOrderAmount/100,
            'total_due_orders' => $totalDueOrders,
            'total_orders_due_amount' => $totalOrderDueAmount/100,
        ];
        return response()->json(['data' => $data]);
    }
}
