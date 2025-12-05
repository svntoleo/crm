<?php

namespace App\Observers;

use App\Models\QuotationItem;
use Illuminate\Support\Facades\Log;

class QuotationItemObserver
{
    public function created(QuotationItem $item): void
    {
        $this->recalculate($item);
    }

    public function updated(QuotationItem $item): void
    {
        $this->recalculate($item);
    }

    public function deleted(QuotationItem $item): void
    {
        $this->recalculate($item);
    }

    protected function recalculate(QuotationItem $item): void
    {
        $quotation = $item->quotation()->with('items')->first();
        if (! $quotation) {
            return;
        }

        $total = $quotation->items->sum(function ($i) {
            return ($i->quantity ?? 0) * (float)($i->unit_price ?? 0);
        });

        $quotation->total = $total;
        $quotation->saveQuietly();
    }
}
