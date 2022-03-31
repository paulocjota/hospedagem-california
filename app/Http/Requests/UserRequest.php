<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $permission = match ($this->method()) {
            'POST' => 'create users',
            'PUT', 'PATCH' => 'update users',
            default => false,
        };

        return $permission ? Auth::user()->can($permission, User::class) : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $passwordRule = match ($this->method()) {
            'POST' => ['required', 'string', 'min:8', 'confirmed'],
            'PUT', 'PATCH' => ['nullable', 'string', 'min:8', 'confirmed'],
            default => false,
        };

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->route('user.id', 0))
            ],
            'password' => $passwordRule,
            'roles_ids' => ['sometimes', 'array', 'max:200'],
            'roles_ids.*' => ['nullable', 'exists:roles,id'],
        ];
    }
}
