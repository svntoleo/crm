<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('serviceOrder'));
    }

    public function rules(): array
    {
        return [
            'title' => 'string|nullable',
            'notes' => 'string|nullable',
            'stage_id' => 'nullable|exists:service_orders_stages,id',
            'position' => 'nullable|integer',
            'scheduled_datetime' => 'nullable|date',
        ];
    }
}
