<?php

namespace App\Http\Requests\Api\V1\Buyer;

use App\Http\Requests\Api\V1\SearchPaginateData\SearchPaginateRequest;

class BuyerIndexRequest extends SearchPaginateRequest
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
        return array_merge(parent::baseRules(), [
            'offer' => 'string|nullable|min:3|max:255',
            'law' => 'string|nullable',
            'nda' => 'boolean|nullable',
            'consultant_type' => 'nullable|integer',
            'status_id' => 'nullable|integer|exists:buyers_status,id',
            'project_id' => 'nullable|integer|exists:projects,id',
            'user' => 'nullable|integer|exists:projects,id',
        ]);
    }
}
