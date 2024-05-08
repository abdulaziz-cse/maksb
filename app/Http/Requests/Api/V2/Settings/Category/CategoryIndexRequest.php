<?php

namespace App\Http\Requests\Api\V2\Settings\Category;

use App\Http\Requests\Api\V1\SearchPaginateData\SearchPaginateRequest;

class CategoryIndexRequest extends SearchPaginateRequest
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
            'name' => 'nullable|string|min:3|max:255|exists:regions,name,deleted_at,NULL',
            'parent_id' => 'nullable|integer|exists:regions,id,deleted_at,NULL',
        ]);
    }
}