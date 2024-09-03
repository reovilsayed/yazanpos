<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Report\Earnings;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $sevendaysEarning = Earnings::range(now()->subDays(7), now()->endOfDay())->totalEarning();
        $sevensSale = Earnings::range(now()->subDays(7), now()->endOfDay())->totalSale();
        $todayEarning = Earnings::range(now()->startOfDay(), now()->endOfDay())->totalEarning();
        $todaysSale = Earnings::range(now()->startOfDay(), now()->endOfDay())->totalSale();

        $orders = Order::whereDate('created_at', today())->count();
        $paidToday = Order::where('status', 'PAID')->whereDate('created_at', today())->count();
        $dueToday = Order::where(function ($query) {
            $query->where('status', 'DUE')
                ->orWhere('status', 'UNPAID');
        })
            ->whereDate('created_at', today())
            ->count();


        return view('pages.dashboard', compact('sevendaysEarning', 'todaysSale', 'todayEarning', 'sevensSale', 'paidToday', 'dueToday', 'orders'));
    }
}
