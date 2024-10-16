<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
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
            'complaint_type' => ['required', 'in:online,offline'],

            // Online fields (only required when complaint_type is 'online')
            'complainant_name' => ['nullable', 'string', 'max:255'],
            'complainant_email' => ['nullable', 'email'],
            'platform' => ['nullable', 'in:WhatsApp,Facebook,Email,Others'],

            // Offline fields (only required when complaint_type is 'offline')
            'complainant_name_offline' => ['nullable', 'string', 'max:255'],
            'complainant_nic_offline' => ['nullable', 'string', 'max:20'],

            // Shared fields
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string']
        ];
    }
}
