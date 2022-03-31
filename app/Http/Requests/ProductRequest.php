<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'price' => brl_to_dec($this->price),
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $permission = match ($this->method()) {
            'POST' => 'create products',
            'PUT', 'PATCH' => 'update products',
            default => false,
        };

        return $permission ? Auth::user()->can($permission, Product::class) : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['string', 'min:2', 'max:254'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,bmp', 'max:8092'],
            'price' => [
                'required',
                'numeric',
                'min:0.01',
                'max:999999999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'quantity' => ['required', 'integer', 'min:-9999', 'max: 9999'],
            'monitor_quantity' => ['boolean'],
            'quantity_low' => ['nullable', 'required_if:monitor_quantity,1', 'integer', 'min:0', 'max: 9999'],
        ];
    }
}
