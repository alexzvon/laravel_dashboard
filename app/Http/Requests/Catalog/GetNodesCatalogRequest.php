<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GetNodesCatalogRequest extends FormRequest
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
            'id' => 'required|integer',
            'parent_id' => 'required|integer',
            'level' => 'required|integer|gte:0',
            'name' => 'required|string|max:255',
            'section' => 'required|boolean',
            'sort' => 'required|integer|gt:0'
        ];
    }
}
