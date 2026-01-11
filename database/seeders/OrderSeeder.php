<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', UserRole::CUSTOMER)->get();
        $products = Product::with('vendor')->get();

        foreach ($users as $user) {
            Order::factory()
                ->count(rand(1, 3))
                ->create([
                    'user_id' => $user->id,
                ])
                ->each(function ($order) use ($products) {

                    // Some orders have 1 item, some many
                    $items = $products->random(rand(1, 4));

                    foreach ($items as $product) {
                        OrderItem::factory()->create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'vendor_id' => $product->vendor_id,
                            'price' => $product->price,
                            'quantity' => rand(1, 3),
                        ]);
                    }

                    $order->update([
                        'total' => $order->items->sum(fn ($i) => $i->price * $i->quantity),
                    ]);
                });
        }
    }
}
