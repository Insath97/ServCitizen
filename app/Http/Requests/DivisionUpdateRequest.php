<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DivisionUpdateRequest extends FormRequest
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
        $dsid = $this->route('division');
        return [
            'district_update' => ['required'],
            'ds_code_update' => ['required'],
            'ds_name_update' => ['required','string','max:255','unique:divisions,name,'.$dsid]
        ];
    }
}
