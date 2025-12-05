<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number' => 'string|nullable|unique:quotations,number',
            'customer_id' => 'nullable|exists:users,id',
            'title' => 'string|nullable',
            'notes' => 'string|nullable',
            'stage_id' => 'required|exists:quotations_stages,id',
            'position' => 'nullable|integer',
        ];
    }
}
