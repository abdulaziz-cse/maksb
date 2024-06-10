<?php

namespace App\Http\Requests\Api\V2\Buyer;

use Illuminate\Foundation\Http\FormRequest;

class BuyerUpdateRequest extends FormRequest
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
            'offer' => 'nullable|string|min:3|max:255',
            'message' => 'nullable|string|min:3|max:255',
            'law' => 'nullable|string',
            'nda' => 'nullable|boolean',
            'consultant_type_id' => 'nullable|integer|exists:predefined_values,id,deleted_at,NULL',
            'project_ids' => 'nullable|array',
            'project_ids.*' => 'nullable|integer|exists:projects,id,deleted_at,NULL',
        ];
    }
}
