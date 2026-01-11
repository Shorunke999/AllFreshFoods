<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Mail\OrderPlacedMail;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    use AuthorizesRequests;

    protected $cart;
    protected $orderService;

    public function  __construct()
    {
        $this->cart = new CartService();
        $this->orderService = new OrderService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Order::class);

        $orders = Order::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
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
    public function store(StoreOrderRequest $request)
    {
        $this->authorize('create', Order::class);
        try {
            $order = $this->orderService->checkout(auth()->user(),session('cart', []));

            $this->cart->clear();

            Mail::to(auth()->user())->send(new OrderPlacedMail($order));

            return redirect()->route('orders.show', $order)->with('success', 'Checkout successfully');
        } catch (\RuntimeException $e) {
            return back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order = $this->orderService->normalizeOrder($order,auth()->user());
        return view('orders.show', compact('order'));
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
    public function update(UpdateOrderRequest $request, Order $order)
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
}
