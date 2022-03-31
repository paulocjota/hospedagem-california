<?php

namespace App\Http\Requests;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RoomChangePricePerAdditionalHourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('update-price rooms', Room::class);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'price_per_additional_hour' => brl_to_dec($this->price_per_additional_hour),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price_per_additional_hour' => ['required', 'numeric', 'min:1', 'max:999999999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }
}
