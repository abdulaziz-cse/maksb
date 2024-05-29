<?php

namespace App\Http\Requests\Api\V2\General\Inquiry;

use Illuminate\Foundation\Http\FormRequest;

class InquiryUpdateRequest extends FormRequest
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
            'status_id' => 'required|integer|exists:predefined_values,id,deleted_at,NULL',
        ];
    }
}