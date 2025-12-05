<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('serviceOrder'));
    }

    public function rules(): array
    {
        return [
            'description' => 'string|nullable',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'order' => 'nullable|integer',
        ];
    }
}
