<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'payer_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id|different:payer_id',
            'colocation_id' => 'required|exists:colocations,id',
            'amount' => 'required|numeric|min:0.01',
        ];
    }
}
