<?php

namespace App\Http\Requests\Api\V2\General\Inquiry;

use App\Http\Requests\Api\V1\SearchPaginateData\SearchPaginateRequest;

class InquiryIndexRequest extends SearchPaginateRequest
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
        return array_merge(parent::baseRules(), [
            'status_id' => 'nullable|integer|exists:predefined_values,id,deleted_at,NULL',
        ]);
    }
}