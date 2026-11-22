<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'revenue' => Order::where('status', '!=', OrderStatus::Cancelled)->sum('total'),
                'orders' => Order::count(),
                'pending' => Order::status(OrderStatus::Pending)->count(),
                'products' => Product::count(),
                'customers' => User::count(),
                'outOfStock' => Product::where('quantity', 0)->count(),
            ],
            'latestOrders' => Order::with('user')->latest()->take(8)->get(),
        ]);
    }
}
