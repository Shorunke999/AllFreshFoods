<?php

namespace App\Services;

use App\Enums\OrderItemStatus;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderService
{
    public function checkout(User $user, array $cart): Order
    {
        try{
            return DB::transaction(function () use ($user, $cart) {

                $order = Order::create([
                    'user_id' => $user->id,
                    'total' => collect($cart)->sum(fn ($i) => intval($i['price']) * $i['quantity']),
                    'status' => OrderStatus::PENDING,
                ]);

                foreach ($cart as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'vendor_id' => $item['vendor_id'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'status' => OrderItemStatus::PENDING
                    ]);

                    Product::whereId($item['product_id'])
                        ->decrement('stock', $item['quantity']);
                }

                return $order;
            });
        }catch (Throwable $e) {
            report($e);
            throw new \RuntimeException('Unable to Checkout.');
        }
    }

    public function normalizeOrder($order, $user)
    {
         // Admin & Customer: see full order
        if ($user->id === $order->user_id) {
            $order->load([
                'items.product',
                'items.vendor',
            ]);
        }

        if($user->isAdmin())
        {
            $order->load([
                'user:id,name,email',
                'items.product',
                'items.vendor',
            ]);
        }

        // Vendor: see ONLY their items
        if ($user->isVendor()) {
            $order->load([
                'items' => fn ($q) =>
                    $q->where('vendor_id', $user->vendor->id)
                    ->with('product'),
            ]);
        }
        return $order;
    }

    public static function sync(Order $order): void
    {
        if ($order->items()
            ->where('status', '!=', OrderItemStatus::FULFILLED)
            ->exists()
        ) {
            $order->update(['status' => OrderStatus::PENDING]);
        } else {
            $order->update(['status' => OrderStatus::COMPLETED]);
        }
    }
}
