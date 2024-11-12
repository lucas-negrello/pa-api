<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShoppingListRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
        ];

        if($this->method() === 'PUT'){
            $rules['user_id'] = ['required', 'exists:users,id'];
        }

        if($this->method() === 'PATCH') {
            $rules = array_map(fn($rule) => str_replace('required', 'sometimes', $rule), $rules);
        }

        return $rules;
    }
}
