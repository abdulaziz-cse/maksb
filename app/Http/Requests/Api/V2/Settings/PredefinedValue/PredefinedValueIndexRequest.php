<?php

namespace App\Http\Requests\Api\V2\Settings\PredefinedValue;

use App\Http\Requests\Api\V1\SearchPaginateData\SearchPaginateRequest;

class PredefinedValueIndexRequest extends SearchPaginateRequest
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
            'name' => 'nullable|string',
            'parent_id' => 'nullable|integer|exists:predefined_values,id,deleted_at,NULL',
            'use_parent' => 'nullable|boolean',
            'slug' => 'nullable|string',
        ]);
    }
}
