<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGoalRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'due_date' => 'nullable|date',
            'progress' =>
                [
                    'nullable',
                    'numeric',
                    function ($attribute, $value, $fail) {
                        if($this->input('total') !== null && $value > $this->input('total')) {
                            $fail('Progress cannot be greater than total');
                        }
                    }
                ],
            'total' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) {
                    if($this->input('progress') !== null && $value < $this->input('progress')) {
                        $fail('Total should be greater than progress');
                    }
                }
            ],
            'measure' => 'nullable|string',
        ];
    }
}
