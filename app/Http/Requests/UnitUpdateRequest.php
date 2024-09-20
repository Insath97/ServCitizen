<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitUpdateRequest extends FormRequest
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
        $unit_route_id = $this->route('unit');
        return [
            'unit_name_update' => ['required', 'max:255', 'unique:units,unit_name,'.$unit_route_id],
            'branch_id_update' => ['required']
        ];
    }
}
