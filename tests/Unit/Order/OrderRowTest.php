<?php

namespace Tests\Unit\Order;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Room;
use App\Models\Entry;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderRow;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderRowTest extends TestCase
{
    use RefreshDatabase;

    private function createOrderRow()
    {
        $room = Room::create([
            'number' => 101,
            'price' => 20,
            'price_per_additional_hour' => 15,
        ]);

        $entry = Entry::create([
            'room_id' => $room->id,
            'license_plate' => 'ABC1234',
            'entry_time' => '2022-03-08 08:00:00',
            'overnight' => false,
            'finished' => false,
        ]);

        $order = Order::create([
            'entry_id' => $entry->id,
        ]);

        $product = Product::create([
            'name' => 'Refrigerante 600ML',
            'price' => 6.25,
            'quantity' => 15,
            'monitor_quantity' => false,
        ]);

        $orderRow = OrderRow::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 4,
        ]);

        return $orderRow;
    }

    /** @test */
    public function when_create_order_row_remove_from_product_quantity_in_stock()
    {
        $orderRow = $this->createOrderRow();
        $this->assertEquals(11, $orderRow->product->quantity);
    }

    /** @test */
    public function when_remove_order_row_add_back_in_product_quantity_in_stock()
    {
        $orderRow = $this->createOrderRow();
        $this->assertEquals(11, $orderRow->product->quantity);
    }

    /** @test */
    public function order_row_should_have_the_current_price_of_product_when_created()
    {
        $orderRow = $this->createOrderRow();
        $this->assertEquals(6.25, $orderRow->price);
    }
}
