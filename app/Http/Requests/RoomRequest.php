<?php

namespace App\Http\Requests;

use App\Models\Room;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $permission = match ($this->method()) {
            'POST' => 'create rooms',
            'PUT', 'PATCH' => 'update rooms',
            default => false,
        };

        return $permission ? Auth::user()->can($permission, Room::class) : false;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'price' => brl_to_dec($this->price),
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
            'number' => [
                'required',
                Rule::unique('rooms', 'number')->ignore($this->route('room.id', 0)),
            ],
            'price' => [
                'required',
                'numeric',
                'min:0.01',
                'max:999999999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'price_per_additional_hour' => [
                'required',
                'numeric',
                'min:0.01',
                'max:999999999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
        ];
    }
}
