<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicesCreateRequest extends FormRequest
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
        $rules = [
            'service_code' => ['required', 'max:255','unique:services,code'],
            'name' => ['required', 'max:255'],
            'branch_id' => ['required_if:has_subservices,1'], // required if has_subservices is 1
            'unit_id' => ['required_if:has_subservices,1'],   // required if has_subservices is 1
            'fees_type' => ['required_if:has_subservices,1', 'max:255', 'in:free,paid'], // required if has_subservices is 1
            'amount' => [
                'required_if:fees_type,paid',
                function ($attribute, $value, $fail) {
                    if ($this->fees_type == 'free' && $value !== 'Free') {
                        $fail('The amount must be "Free" for free services.');
                    } elseif ($this->fees_type == 'paid' && !is_numeric($value)) {
                        $fail('The amount must be a number for paid services.');
                    }
                }
            ],
            'r_time' => ['required_if:has_subservices,1', 'integer'], // required if has_subservices is 1
        ];

        // Optional logic if 'has_subservices' is 0, where some fields are nullable
        if ($this->input('has_subservices') == 0) {
            $rules['branch_id'] = ['nullable'];
            $rules['unit_id'] = ['nullable'];
            $rules['fees_type'] = ['nullable'];
            $rules['amount'] = ['nullable'];
            $rules['r_time'] = ['nullable'];
        }

        return $rules;
    }
}
