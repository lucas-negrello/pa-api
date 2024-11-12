<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShoppingListItemRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
        ];

        if($this->method() === 'PUT'){
            $rules['shopping_list_id'] = ['required', 'exists:shopping_lists,id'];
        }

        if($this->method() === 'PATCH'){
            $rules = array_map(fn($rule) => str_replace('required', 'sometimes', $rule), $rules);
        }

        return $rules;
    }
}
