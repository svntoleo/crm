<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuotationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('quotation'));
    }

    public function rules(): array
    {
        $quotation = $this->route('quotation');
        return [
            'title' => 'string|nullable',
            'notes' => 'string|nullable',
            'stage_id' => 'nullable|exists:quotations_stages,id',
            'position' => 'nullable|integer',
        ];
    }
}
