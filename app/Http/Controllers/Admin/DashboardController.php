<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'total_vendor'  => User::where('role', UserRole::VENDOR)->count(),
                'total_products' => Product::count(),
                'total_orders'   => Order::count(),
                'pending_orders' => Order::where('status', OrderStatus::PENDING)->count(),
            ],
            'recent_products' => Product::latest()
                ->take(5)
                ->get(),

        ]);
    }
}
