<?php

namespace App\Http\Requests;

use App\Rules\HaveEnoughStock;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'customerName' => 'required',
            'products' => ['required','array', new HaveEnoughStock()],
            'products.*.id' => ['required'],
            'products.*.quantity' => ['required']
        ];
    }
}
