<?php

namespace Tests\Feature;

use App\Enums\OrderItemStatus;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class OrderAggregationTest extends TestCase
{
    use RefreshDatabase;
   public function test_order_completes_when_all_items_completed()
    {
        $order = Order::factory()->create(['status' => OrderStatus::PENDING]);

        OrderItem::factory()->count(2)->create([
            'order_id' => $order->id,
            'status' => OrderItemStatus::FULFILLED,
        ]);

        app(OrderService::class)->sync($order->fresh());

        $this->assertEquals(OrderStatus::COMPLETED->value, $order->fresh()->status);
    }

}
