<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductAuthorizationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_vendor_cannot_edit_other_vendor_product()
    {
        $vendorA = User::factory()->vendor()->create();
        $vendorB = User::factory()->vendor()->create();

        $product = Product::factory()->create([
            'vendor_id' => $vendorB->vendor->id,
        ]);

        $this->actingAs($vendorA)
            ->put(route('vendor.products.update', $product), [
                'name' => 'Hacked',
                'category_id' => $product->category_id,
                'price' =>  $product->price,
                'stock' => $product->stock
            ])
            ->assertForbidden();
    }

}
