<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_add_product_to_cart()
    {
        $product = Product::factory()->create([
            'price' => 50,
            'stock' => 10,
        ]);

        $this->post(route('cart.add', $product), [
            'quantity' => 2,
        ]);

        $this->get('/cart')
            ->assertSee('100.00');
    }

}
