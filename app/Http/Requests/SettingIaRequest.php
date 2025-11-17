<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\SettingIA;

class SettingIaRequest extends FormRequest
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
            'system_instruction' => 'required|string|max:10000',
            'model' => 'required|string',
            'temperature' => 'required|numeric'
        ];

        if (SettingIA::where('id', 1)->exists()) {
            $rules['key'] = 'nullable|string|min:20|max:50';
        } else {
            $rules['key'] = 'required|string|min:20|max:50';
        }

        return $rules;
    }
}
