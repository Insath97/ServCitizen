<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GNDivisionCreateRequest extends FormRequest
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
            'gn_code' => ['required'],
            'ds_name' => ['required'],
            'gn_name' => ['required','string','max:255']
        ];
    }
}
