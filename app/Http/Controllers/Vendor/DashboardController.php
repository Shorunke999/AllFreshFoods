<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\OrderItemStatus;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $vendorId = auth()->user()->vendor->id;
        return view('vendor.dashboard', [
             'stats' => [
                'products_count' => Product::where('vendor_id', $vendorId)->count(),
                'pending_orders' => OrderItem::where('vendor_id', $vendorId)
                    ->where('status', OrderItemStatus::PENDING)
                    ->count(),
                'recent_products' => Product::where('vendor_id', $vendorId)
                    ->latest()
                    ->take(5)
                    ->get(),
                'revenue' => OrderItem::where('vendor_id', $vendorId)
                ->where('status', OrderItemStatus::FULFILLED)->sum(DB::raw('price * quantity')),
            ]
        ]);
    }
}

