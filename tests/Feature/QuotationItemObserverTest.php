<?php

namespace Tests\Feature;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\QuotationsStage;
use Tests\TestCase;

class QuotationItemObserverTest extends TestCase
{
    public function test_total_recalculates_on_item_create()
    {
        $quotation = Quotation::factory()->create(['total' => 0]);
        
        $item = $quotation->items()->create([
            'description' => 'Test item',
            'quantity' => 2,
            'unit_price' => 100,
        ]);

        $quotation->refresh();
        $this->assertEquals(200, $quotation->total);
    }

    public function test_total_recalculates_on_item_update()
    {
        $quotation = Quotation::factory()->create(['total' => 200]);
        $item = $quotation->items()->create([
            'description' => 'Test',
            'quantity' => 2,
            'unit_price' => 100,
        ]);

        $item->update(['unit_price' => 150]);

        $quotation->refresh();
        $this->assertEquals(300, $quotation->total);
    }

    public function test_total_recalculates_on_item_delete()
    {
        $quotation = Quotation::factory()->create(['total' => 200]);
        $item = $quotation->items()->create([
            'description' => 'Test',
            'quantity' => 2,
            'unit_price' => 100,
        ]);

        $item->delete();

        $quotation->refresh();
        $this->assertEquals(0, $quotation->total);
    }

    public function test_total_with_multiple_items()
    {
        $quotation = Quotation::factory()->create(['total' => 0]);
        
        $quotation->items()->create(['description' => 'Item 1', 'quantity' => 1, 'unit_price' => 100]);
        $quotation->items()->create(['description' => 'Item 2', 'quantity' => 2, 'unit_price' => 50]);

        $quotation->refresh();
        $this->assertEquals(200, $quotation->total);
    }
}
