<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\OrderItemStatus;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $vendorId = auth()->user()->vendor->id;

        return view('vendor.dashboard', [
            'productsCount' => Product::where('vendor_id', $vendorId)->count(),
            'pendingOrders' => OrderItem::where('vendor_id', $vendorId)
                ->where('status', OrderItemStatus::PENDING)
                ->count(),
        ]);
    }
}
