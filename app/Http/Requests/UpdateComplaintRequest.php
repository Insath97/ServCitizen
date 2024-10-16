<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComplaintRequest extends FormRequest
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
            'complainant_name' => [
                $this->input('complaint_type') == 'online' ? 'required' : 'nullable',
                'string',
                'max:255'
            ],
            'complainant_email' => [
                $this->input('complaint_type') == 'online' ? 'required_if:complaint_type,online' : 'nullable',
                'email'
            ],
            'platform' => [
                $this->input('complaint_type') == 'online' ? 'required_if:complaint_type,online' : 'nullable',
                'in:WhatsApp,Facebook,Email,Others'
            ],

            // Offline fields (only required when complaint_type is 'offline')
            'complainant_name_offline' => [
                $this->input('complaint_type') == 'offline' ? 'required' : 'nullable',
                'string',
                'max:255'
            ],
            'complainant_nic_offline' => [
                $this->input('complaint_type') == 'offline' ? 'required_if:complaint_type,offline' : 'nullable',
                'string',
                'max:20'
            ],

            // Shared fields
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string']
        ];
    }
}
