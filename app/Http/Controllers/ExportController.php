<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeShiftSingleExport;
use App\Exports\InventoryExport;
use App\Exports\OrdersExport;
use App\Models\EmployeeShift;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportShiftSingle(Request $request)
    {
        $shifts = EmployeeShift::with('user');
        if ($request->from) {
            $shifts = $shifts->whereDate('clock_in', '>=', $request->from);
        }
        if ($request->to) {
            $shifts = $shifts->whereDate('clock_in', '<=', $request->to);
        }
        $totalHours = 0;
        $data = $shifts->get()
            ->map(function ($shift) use (&$totalHours) {
                $elapsedHours = Carbon::parse($shift->clock_in)->diffInHours(Carbon::parse($shift->clock_out));
                $totalHours += $elapsedHours;
                return [
                    'Employee ID' => $shift->user->id,
                    'Employee Name' => $shift->user->name,
                    'Clock In Date' => Carbon::parse($shift->clock_in)->format('Y-m-d'),
                    'Clock In Time' => Carbon::parse($shift->clock_in)->format('H:i:s'),
                    'Clock Out Date' => Carbon::parse($shift->clock_out)->format('Y-m-d'),
                    'Clock Out Time' => Carbon::parse($shift->clock_out)->format('H:i:s'),
                    'Elapsed Hours' => $elapsedHours > 0 ? $elapsedHours : '0',
                ];
            });

        $data->push([
            'Employee ID' => '',
            'Employee Name' => 'Total',
            'Clock In Date' => '',
            'Clock In Time' => '',
            'Clock Out Date' => '',
            'Clock Out Time' => '',
            'Elapsed Hours' => $totalHours . ' ' . 'Hour',
        ]);

        $firstUserName = $data->first()['Employee Name'];
        return Excel::download(new EmployeeShiftSingleExport($data), $firstUserName . '_shift.xlsx');
    }

    public function exportOrders(Request $request)
    {
        $eventName = $request->event_name;
        $data = Order::with(['customer', 'products'])
            ->get()
            ->map(function ($order) use ($eventName) {
                $totalTax = $order->products->sum(function ($product) {
                    return $product->pivot->tax * $product->pivot->quantity;
                });
                return [
                    'Order Date' => $order->created_at->format('Y-m-d'),
                    'Order ID' => $order->id,
                    'Invoice Number' => $order->id,
                    'Order Number' => $order->id,
                    // 'Order Type'=>'',
                    'Order Employee ID' => $order->customer->id,
                    'Order Employee Name' => $order->customer->name,
                    // 'Order Employee Custom ID'=>'',
                    'Note' => $order->notes,
                    'Currency' => 'USD',
                    'Tax Amount' => $totalTax,
                    // 'Tip'=>'',
                    // 'Service Charge'=>'',
                    'Discount' => $order->discount,
                    'Order Total' => $order->total,
                    'Payments Total' => $order->total,
                    // 'Payment Note'=>'',
                    // 'Refunds Total'=>'',
                    // 'Manual Refunds Total'=>'',
                    // 'Tender'=>'',
                    // 'Credit Card Auth Code'=>'',
                    // 'Credit Card Transaction ID'=>'',
                    // 'Order Payment State'=>'',
                ];
            });

        return Excel::download(new OrdersExport($data), 'Orders.xlsx');
    }

    public function exportInventory(Request $request)
    {
        $eventName = $request->event_name;
        $data = Product::with('generic')
            ->get()
            ->map(function ($product) use ($eventName) {
                return [
                    'ID' => $product->id,
                    'Name' => $product->name,
                    // 'Alternate Name'=>$product->,
                    'Price' => $product->price,
                    // 'Price Type'=>$product->,
                    'Price Unit' => $product->unit,
                    'Tax Rates' => $product->tax,
                    // 'Cost'=>$product->,
                    // 'Product Code'=>$product->,
                    'SKU' => $product->sku,
                    // 'Modifier Groups'=>$product->,
                    'Quantity' => $product->quantity,
                    // 'Printer Labels'=>$product->,
                    // 'Hidden'=>$product->,
                    // 'Non-revenue item'=>$product->,
                    // 'Discountable'=>$product->,
                    // 'Max Discount Allowed'=>$product->,
                    // 'Tags'=>$product->,
                ];
            });
        return Excel::download(new InventoryExport($data), 'Inventory.xlsx');
    }
}
