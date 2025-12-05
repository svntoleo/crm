<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceOrderRequest;
use App\Http\Requests\UpdateServiceOrderRequest;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceOrder::with('items', 'customer', 'stage');
        if ($request->user()->isCustomer()) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_id', $request->user()->id)
                  ->orWhere('user_id', $request->user()->id);
            });
        }
        return response()->json($query->paginate(25));
    }

    public function show(ServiceOrder $serviceOrder)
    {
        $this->authorize('view', $serviceOrder);
        $serviceOrder->load('items', 'customer', 'stage');
        return response()->json($serviceOrder);
    }

    public function store(StoreServiceOrderRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id ?? null;

        $order = ServiceOrder::create($data);
        return response()->json($order, 201);
    }

    public function update(UpdateServiceOrderRequest $request, ServiceOrder $serviceOrder)
    {
        $serviceOrder->update($request->validated());
        return response()->json($serviceOrder);
    }

    public function destroy(Request $request, ServiceOrder $serviceOrder)
    {
        $this->authorize('delete', $serviceOrder);
        $serviceOrder->delete();
        return response()->json(null, 204);
    }

    public function move(Request $request)
    {
        $payload = $request->validate([
            'moves' => 'required|array',
            'moves.*.id' => 'required|integer|exists:service_orders,id',
            'moves.*.stage_id' => 'required|integer|exists:service_orders_stages,id',
            'moves.*.position' => 'required|integer',
        ]);

        DB::transaction(function () use ($payload, $request) {
            foreach ($payload['moves'] as $m) {
                $order = ServiceOrder::find($m['id']);
                $this->authorize('update', $order);
                $order->update([
                    'stage_id' => $m['stage_id'],
                    'position' => $m['position'],
                ]);
            }
        });

        return response()->json(['ok' => true]);
    }
}
