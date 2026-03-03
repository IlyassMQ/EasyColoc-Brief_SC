<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'colocation_id' => 'required|exists:colocations,id',
            'category_id' => 'nullable|exists:category,id',
            'new_category' => 'nullable|string|min:2|max:255',
            'title' => 'required|string|min:3|max:255',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
        ];
    }
}
