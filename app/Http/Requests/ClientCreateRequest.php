<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientCreateRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'nic' => ['required', 'string', 'unique:clients', 'regex:/^([0-9]{9}[Vv]|[0-9]{12})$/'],
            'gender' => ['required', 'in:Male,Female'],
            'dob' => ['required', 'date'],
            'street' => ['required', 'string', 'max:255'],
            'province_id' => ['required', 'exists:provinces,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'ds_id' => ['required', 'exists:divisions,id'],
            'division_id' => ['required', 'exists:g_n_divisions,id'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:clients,email'],
            'mobile' => ['nullable', 'regex:/^(?:\+94|0)?7[0-9]{8}$/'],
            'tel' => ['nullable', 'regex:/^(?:\+94|0)?(?:11|21|23|24|25|26|27|28|31|32|33|34|35|36|37|38|41|45|47|51|52|54|55|57|58|63|65|66|67|81|91|92)[0-9]{7}$/'],
        ];
    }
}
