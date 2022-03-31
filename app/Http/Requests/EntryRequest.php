<?php

namespace App\Http\Requests;

use App\Models\Entry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class EntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $permission = match ($this->method()) {
            'POST' => 'create entries',
            'PUT', 'PATCH' => 'update entries',
            default => false,
        };

        return $permission ? Auth::user()->can($permission, Entry::class) : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'room_id' => ['required', 'exists:rooms,id'],
            'license_plate' => ['nullable', 'string', 'min:6', 'max:8'],
        ];

        if (!$this?->entry?->id) {
            $rules['overnight'] = ['required', 'boolean'];
        }

        return $rules;
    }
}
