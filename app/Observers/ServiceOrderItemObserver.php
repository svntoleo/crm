<?php

namespace App\Observers;

use App\Models\ServiceOrderItem;

class ServiceOrderItemObserver
{
    public function created(ServiceOrderItem $item): void
    {
        $this->recalculate($item);
    }

    public function updated(ServiceOrderItem $item): void
    {
        $this->recalculate($item);
    }

    public function deleted(ServiceOrderItem $item): void
    {
        $this->recalculate($item);
    }

    protected function recalculate(ServiceOrderItem $item): void
    {
        $order = $item->serviceOrder()->with('items')->first();
        if (! $order) {
            return;
        }

        $total = $order->items->sum(function ($i) {
            return ($i->quantity ?? 0) * (float)($i->unit_price ?? 0);
        });

        $order->total = $total;
        $order->saveQuietly();
    }
}
