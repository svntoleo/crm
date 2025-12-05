<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceOrderItemRequest;
use App\Http\Requests\UpdateServiceOrderItemRequest;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderItem;
use Illuminate\Http\Request;

class ServiceOrderItemController extends Controller
{
    public function store(StoreServiceOrderItemRequest $request, ServiceOrder $serviceOrder)
    {
        $item = $serviceOrder->items()->create($request->validated());
        return response()->json($item, 201);
    }

    public function update(UpdateServiceOrderItemRequest $request, ServiceOrder $serviceOrder, ServiceOrderItem $item)
    {
        $item->update($request->validated());
        return response()->json($item);
    }

    public function destroy(Request $request, ServiceOrder $serviceOrder, ServiceOrderItem $item)
    {
        $this->authorize('update', $serviceOrder);
        $item->delete();
        return response()->json(null, 204);
    }
}
