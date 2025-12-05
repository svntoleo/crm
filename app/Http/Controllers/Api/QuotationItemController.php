<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuotationItemRequest;
use App\Http\Requests\UpdateQuotationItemRequest;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;

class QuotationItemController extends Controller
{
    public function store(StoreQuotationItemRequest $request, Quotation $quotation)
    {
        $item = $quotation->items()->create($request->validated());
        return response()->json($item, 201);
    }

    public function update(UpdateQuotationItemRequest $request, Quotation $quotation, QuotationItem $item)
    {
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy(Request $request, Quotation $quotation, QuotationItem $item)
    {
        $this->authorize('update', $quotation);
        $item->delete();
        return response()->json(null, 204);
    }
}
