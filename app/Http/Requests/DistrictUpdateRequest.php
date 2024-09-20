<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistrictUpdateRequest extends FormRequest
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
        $did = $this->route('district');
        return [
            'province_update' => ['required'],
            'district_code_update' => ['required'],
            'district_update' => ['required', 'string', 'max:255','unique:districts,district,'.$did]
        ];
    }
}
