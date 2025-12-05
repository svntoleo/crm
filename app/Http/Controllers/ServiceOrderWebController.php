<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceOrderItemRequest;
use App\Http\Requests\StoreServiceOrderRequest;
use App\Http\Requests\UpdateServiceOrderItemRequest;
use App\Http\Requests\UpdateServiceOrderRequest;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderItem;
use App\Models\ServiceOrdersStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ServiceOrderWebController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceOrder::with('stage', 'customer')->orderBy('stage_id')->orderBy('position');
        
        if ($request->user()->isCustomer()) {
            $query->where('customer_id', $request->user()->id);
        }
        
        $orders = $query->paginate(50)->withQueryString();
        $stages = ServiceOrdersStage::orderBy('order')->get();
        
        return Inertia::render('service-orders/Index', [
            'service_orders' => $orders,
            'stages' => $stages,
            'urls' => [
                'create' => route('service_orders.create'),
                'store' => route('service_orders.store'),
                'move' => route('service_orders.move'),
                'show' => fn($id) => route('service_orders.show', $id),
                'edit' => fn($id) => route('service_orders.edit', $id),
                'destroy' => fn($id) => route('service_orders.destroy', $id),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('service-orders/Form', [
            'serviceOrder' => null,
            'urls' => [
                'store' => route('service_orders.store'),
                'index' => route('service_orders.index'),
                'storeItem' => fn($id) => route('service_orders.items.store', $id),
            ],
        ]);
    }

    public function store(StoreServiceOrderRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $order = ServiceOrder::create($data);

        return redirect()->route('service_orders.edit', $order)
            ->with('success', 'Service order created successfully.');
    }

    public function edit(ServiceOrder $serviceOrder)
    {
        $this->authorize('update', $serviceOrder);
        
        $serviceOrder->load('items', 'customer', 'stage');
        return Inertia::render('service-orders/Form', [
            'serviceOrder' => $serviceOrder,
            'urls' => [
                'update' => route('service_orders.update', $serviceOrder),
                'index' => route('service_orders.index'),
                'storeItem' => route('service_orders.items.store', $serviceOrder),
                'destroyItem' => fn($itemId) => route('service_orders.items.destroy', [$serviceOrder->id, $itemId]),
            ],
        ]);
    }

    public function update(UpdateServiceOrderRequest $request, ServiceOrder $serviceOrder)
    {
        $serviceOrder->update($request->validated());

        return redirect()->route('service_orders.edit', $serviceOrder)
            ->with('success', 'Service order updated successfully.');
    }

    public function destroy(Request $request, ServiceOrder $serviceOrder)
    {
        $this->authorize('delete', $serviceOrder);
        
        $serviceOrder->delete();

        return redirect()->route('service_orders.index')
            ->with('success', 'Service order deleted successfully.');
    }

    public function show(ServiceOrder $serviceOrder)
    {
        $this->authorize('view', $serviceOrder);
        
        $serviceOrder->load('items', 'customer', 'stage');
        return Inertia::render('service-orders/Show', [
            'serviceOrder' => $serviceOrder,
            'urls' => [
                'edit' => route('service_orders.edit', $serviceOrder),
                'index' => route('service_orders.index'),
            ],
        ]);
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

        return response()->json(['success' => true, 'message' => 'Service order moved successfully.']);
    }

    public function storeItem(StoreServiceOrderItemRequest $request, ServiceOrder $serviceOrder)
    {
        $serviceOrder->items()->create($request->validated());

        return back()->with('success', 'Item added successfully.');
    }

    public function updateItem(UpdateServiceOrderItemRequest $request, ServiceOrder $serviceOrder, ServiceOrderItem $item)
    {
        $item->update($request->validated());

        return back()->with('success', 'Item updated successfully.');
    }

    public function destroyItem(Request $request, ServiceOrder $serviceOrder, ServiceOrderItem $item)
    {
        $this->authorize('update', $serviceOrder);
        
        $item->delete();

        return back()->with('success', 'Item deleted successfully.');
    }
}
