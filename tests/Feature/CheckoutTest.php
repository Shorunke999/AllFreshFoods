<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;
    public function test_checkout_creates_order_and_items()
    {
        $user = User::factory()->create([
            'role' => UserRole::CUSTOMER
        ]);
        $product = Product::factory()->create(['price' => 25]);

        $this->actingAs($user)
            ->post(route('cart.add', $product), ['quantity' => 2]);

        $this->actingAs($user)
            ->post(route('orders.store'));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total' => 50,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

}
