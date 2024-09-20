<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicesUpdateRequest extends FormRequest
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
        $service = $this->route('service');
        return [
            'name' => ['required', 'max:255', 'unique:services,code,'.$service],
            'branch_id' => ['required'],
            'unit_id' => ['required'],
            'fees_type' => ['required', 'max:255', 'in:free,paid'],
            'amount' => [
                'required',
                'required_if:fees_type,paid',
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($this->fees_type == 'free' && $value !== 'Free') {
                        $fail('The amount must be "Free" for free services.');
                    } elseif ($this->fees_type == 'paid' && !is_numeric($value)) {
                        $fail('The amount must be a number for paid services.');
                    }
                }
            ],
            'r_time' => ['required', 'integer']
        ];
    }
}
