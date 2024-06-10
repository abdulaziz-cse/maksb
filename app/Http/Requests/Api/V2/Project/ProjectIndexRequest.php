<?php

namespace App\Http\Requests\Api\V2\Project;

use App\Http\Requests\Api\V1\SearchPaginateData\SearchPaginateRequest;

class ProjectIndexRequest extends SearchPaginateRequest
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
            'name' => 'nullable|string|min:3|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
    }
}
