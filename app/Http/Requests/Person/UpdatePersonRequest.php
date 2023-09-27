<?php

namespace App\Http\Requests\Person;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
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
            'fio' => 'required|string|max:255',
            'id' => 'required|integer',
            'sex' => 'required|string|max:255',
            'birthday' => 'required',
            'phone' => 'required',
        ];
    }
}
