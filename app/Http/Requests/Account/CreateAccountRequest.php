<?php

namespace App\Http\Requests\Account;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'person_id' => 'required|integer|gte:1',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }
}
