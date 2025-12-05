<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $query = Quotation::with('items', 'customer', 'stage');
        if ($request->user()->isCustomer()) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_id', $request->user()->id)
                  ->orWhere('user_id', $request->user()->id);
            });
        }
        return response()->json($query->paginate(25));
    }

    public function show(Quotation $quotation)
    {
        $this->authorize('view', $quotation);
        $quotation->load('items', 'customer', 'stage');
        return response()->json($quotation);
    }

    public function store(StoreQuotationRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id ?? null;

        $quotation = Quotation::create($data);
        return response()->json($quotation, 201);
    }

    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
        $quotation->update($request->validated());
        return response()->json($quotation);
    }

    public function destroy(Request $request, Quotation $quotation)
    {
        $this->authorize('delete', $quotation);
        $quotation->delete();
        return response()->json(null, 204);
    }

    /**
     * Bulk move/mutate positions of quotations for kanban drag/drop.
     */
    public function move(Request $request)
    {
        $payload = $request->validate([
            'moves' => 'required|array',
            'moves.*.id' => 'required|integer|exists:quotations,id',
            'moves.*.stage_id' => 'required|integer|exists:quotations_stages,id',
            'moves.*.position' => 'required|integer',
        ]);

        DB::transaction(function () use ($payload, $request) {
            foreach ($payload['moves'] as $m) {
                $quotation = Quotation::find($m['id']);
                $this->authorize('update', $quotation);
                $quotation->update([
                    'stage_id' => $m['stage_id'],
                    'position' => $m['position'],
                ]);
            }
        });

        return response()->json(['ok' => true]);
    }
}
