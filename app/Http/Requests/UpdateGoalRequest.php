<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGoalRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'due_date' => 'nullable|date',
            'measure' => 'nullable|string',
        ];

        if ($this->method() === 'PUT') {
            $rules['user_id'] = 'required|exists:users,id';
            $rules['progress'] = 'required|numeric|max:'.$this->total;
            $rules['total'] = 'required|numeric|min:'.$this->progress;
        }

        if ($this->method() === 'PATCH') {
            $rules = array_map(fn($rule) => str_replace('required', 'sometimes', $rule), $rules);
        }

        return $rules;
    }

    /**
     *
     *
     * @return array
     */
    public function messages()
    {
        return [
            'progress.required' => 'Progress is required on PUT method',
            'total.required' => 'Total is required on PUT method',
            'progress.max' => 'Progress cannot be greater than total value',
            'total.min' =>  'Total cannot be lesser than progress value',
        ];
    }
}
