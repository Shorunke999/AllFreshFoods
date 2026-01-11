<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Services\OrderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderItemController extends Controller
{
    use AuthorizesRequests;
    protected $orderService;

    public function  __construct()
    {
        $this->orderService = new OrderService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderItems = OrderItem::where('vendor_id', auth()->user()->vendor->id)
            ->with(['product', 'order.user'])
            ->latest()
            ->paginate(15);

        return view('vendor.orders.index', compact('orderItems'));
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
    public function store(StoreOrderItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {

        $this->authorize('update', $orderItem);

        $orderItem->update([
            'status' => $request->status,
        ]);

        $this->orderService->sync($orderItem->order);

        return back()->with('success', 'Order status updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
