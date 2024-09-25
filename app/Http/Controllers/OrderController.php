<?php

namespace App\Http\Controllers;

use App\Mail\DuePaidMail;
use App\Models\Order;
use App\Models\Transaction;
use App\Report\Earnings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->role->hasPermissionTo('view order')) {
            return abort(403, 'You do not have permission to access the Order view.');
        }
        $orders = Order::latest()->filter()->paginate(24)->withQueryString();
        $allOrderCount = Order::filter()->get();
        $paidOrderCount = Order::filter()->where('status', 'PAID')->get();
        $unpaidOrderCount = Order::filter()->where('status', 'UNPAID')->get();
        $dueOrderCount = Order::filter()->where('status', 'DUE')->get();

        $data = [
            'total' => [
                'count' => $allOrderCount->count(),
                'sum' => $allOrderCount->sum('total')
            ],
            'paid' => [
                'count' => $paidOrderCount->count(),
                'sum' => $paidOrderCount->sum('total')
            ],
            'unpaid' => [
                'count' => $unpaidOrderCount->count(),
                'sum' => $unpaidOrderCount->sum('total')
            ],
            'due' => [
                'count' => $dueOrderCount->count(),
                'sum' => $dueOrderCount->sum('total')
            ]
        ];

        return view('pages.orders.list', compact('orders', 'data'));
    }
    public function getChartData()
    {
        $eranings = Earnings::range(now()->subDays(15), now()->startOfDay())->graph();

        return response()->json(['data' => $eranings]);
    }

    public function getChartDataMonth()
    {
        $earnings = Earnings::range(now()->subMonths(12), now())->graph('Month');
        $data = [
            [
                'month' => 'January',
                'sales' => 0,
                'profit' => 0,
            ],
            [
                'month' => 'February',
                'sales' => 0,
                'profit' => 0,
            ],
            [
                'month' => 'March',
                'sales' => 0,
                'profit' => 0,
            ],
            [
                'month' => 'April',
                'sales' => 0,
                'profit' => 0,
            ],
            [
                'month' => 'May',
                'sales' => 0,
                'profit' => 0,
            ],
            [
                'month' => 'June',
                'sales' => 0,
                'profit' => 0,
            ],
            [
                'month' => 'July',
                'sales' => 0,
                'profit' => 0,
            ],
            [
                'month' => 'Augest',
                'sales' => 0,
                'profit' => 0,
            ],
            [
                'month' => 'September',
                'sales' => 0,
                'profit' => 0,
            ],
            [
                'month' => 'October',
                'sales' => 0,
                'profit' => 0,
            ],
            [
                'month' => 'November',
                'sales' => 0,
                'profit' => 0,
            ],
            [
                'month' => 'December',
                'sales' => 0,
                'profit' => 0,
            ],
        ];
        foreach ($earnings as $earning) {
            $month = $earning['month'];
            $sales = $earning['sales'] ?? 0;
            $profit = $earning['total_profit'] ?? 0;
            foreach ($data as $index => $monthData) {
                if ($monthData['month'] == $month) {
                    $data[$index]['sales'] = $sales;
                    $data[$index]['profit'] = $profit;
                    break;
                }
            }
        }

        return response()->json(['data' => ['sales' => array_map(fn($item) => $item['sales'], $data), 'profit' => array_map(fn($item) => $item['profit'], $data)]]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
    public function invoice(Order $order)
    {
        return view('pages.orders.invoice', compact('order'));
    }
    public function errorpage()
    {
        return view('pages.errorPage.404');
    }
    public function duepay(Request $request)
    {
        $amount = $request->amount;
        $order = Order::find($request->order_id);
        if ($order->due >= $request->amount) {
            Transaction::create([
                'order_id' => $order->id,
                'amount' => $request->amount,
            ]);
            $order->update([
                'paid' => $order->paid + $request->amount,
                'due' => $order->due - $request->amount,
            ]);
            if ($order->due == 0) {
                $order->update([
                    'status' => 'PAID',
                ]);
            }
            if ($order->customer_id && $order->customer->email) {
                $customerEmailTo = $order->customer->email;

                try {
                    Mail::to($customerEmailTo)->send(new DuePaidMail($order, $amount));
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Failed to send email to customer.']);
                }
            }
            // dd($order);
            return back()->with('success', 'Transaction create successfully');
        } else {
            return back()->withErrors('Transaction amount grater, then order due');
        }
    }
    public function mark_pay(Request $request)
    {
        // dd($request->orders);
        $amount = $request->amount;
        if ($request->orders == !null) {

            foreach ($request->orders as $item) {
                $order = Order::findOrFail($item);
                Transaction::create([
                    'order_id' => $order->id,
                    'amount' => $order->due,
                ]);
                $order->update([
                    'paid' => $order->paid + $order->due,
                    'due' => 0,
                    'status' => 'PAID',
                ]);
            }
            if ($order->customer_id && $order->customer->email) {
                $customerEmailTo = $order->customer->email;

                try {
                    Mail::to($customerEmailTo)->send(new DuePaidMail($order, $amount));
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Failed to send email to customer.']);
                }
            }
            return back()->with('success', 'Mark as paid successfuly complete');
        } else {
            return back()->withErrors('Please at least one item select');
        }
    }
    public function mark_delivered(Order $order)
    {
        $order->update([
            'delivered' => 1
        ]);
        return back()->with('success', 'Order marked as delivered successfully');
    }
}
