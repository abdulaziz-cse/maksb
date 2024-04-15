<?php

namespace App\Http\Requests\Api\V1\Favourite;

use App\Http\Requests\Api\V1\SearchPaginateData\SearchPaginateRequest;

class FavouriteIndexRequest extends SearchPaginateRequest
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
            'project_id' => 'nullable|integer|exists:projects,id',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
    }
}