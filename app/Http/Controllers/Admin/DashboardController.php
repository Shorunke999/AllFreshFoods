<?php

namespace App\Http\Controllers\Admin;

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
            'vendorsCount'  => User::where('role', UserRole::VENDOR)->count(),
            'productsCount' => Product::count(),
            'ordersCount'   => Order::count(),
        ]);
    }
}
