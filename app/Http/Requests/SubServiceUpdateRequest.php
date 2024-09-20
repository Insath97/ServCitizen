<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubServiceUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('sub_service');
        return [
            'service_type' => 'required',
            'service_code' => 'required',
            'subservice_code' => [
                'required',
                'string',
                'max:255',
                'unique:sub_services,code,'.$id
            ],
            'subservice_name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'unit_id' => 'required|exists:units,id',
            'fees_type' => [
                'required',
                'in:free,paid'
            ],
            'amount' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($this->fees_type === 'free' && $value !== 'Free') {
                        $fail('The amount must be "Free" for free services.');
                    } elseif ($this->fees_type === 'paid') {
                        if (!is_numeric($value) || $value <= 0) {
                            $fail('The amount must be a positive number for paid services.');
                        }
                    }
                }
            ],
            'r_time' => 'required|numeric|min:0',
            'r_time_type' => 'required|in:minutes,hours,days',
        ];
    }
}
