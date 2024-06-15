<?php

namespace App\Http\Requests\Api\V2\Buyer;

use Illuminate\Foundation\Http\FormRequest;

class BuyerManageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'offer' => 'required|string|min:3|max:255',
            'message' => 'required|string|min:3|max:255',
            'law' => 'required|string',
            'nda' => 'required|boolean',
            'consultant_type_id' => 'nullable|integer|exists:predefined_values,id,deleted_at,NULL',
            'project_id' => 'required|integer|exists:projects,id,deleted_at,NULL',
            'file' => 'required|file|max:2048|mimes:pdf,docx',
        ];
    }
}
