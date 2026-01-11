<?php

namespace Tests\Feature;

use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VendorOrderTest extends TestCase
{
    use RefreshDatabase;
    public function test_vendor_sees_only_their_order_items()
    {
        $vendor = User::factory()->vendor()->create();
        $otherVendor = User::factory()->vendor()->create();

        $itemA = OrderItem::factory()->create([
            'vendor_id' => $vendor->vendor->id,
        ]);

        $itemB = OrderItem::factory()->create([
            'vendor_id' => $otherVendor->vendor->id,
        ]);

        $response = $this->actingAs($vendor)
            ->get(route('vendor.orderItems.index'));

        $response->assertSee($itemA->product->name);
        $response->assertDontSee($itemB->product->name);
    }

}
