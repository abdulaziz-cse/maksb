<?php

namespace App\Http\Requests\Api\V2\Buyer;

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
            'consultant_type_id' => 'nullable|integer|exists:predefined_values,id,deleted_at,NULL',
            'status_id' => 'nullable|integer|exists:predefined_values,id,deleted_at,NULL',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
    }
}