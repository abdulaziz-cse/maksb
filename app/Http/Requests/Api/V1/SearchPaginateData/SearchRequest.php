<?php

namespace App\Http\Requests\Api\V1\SearchPaginateData;

use App\Traits\FormRequestNullableTrait;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    use FormRequestNullableTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public static function baseRules()
    {
        return [
            'search_keys' => 'nullable|string|regex:/^([^,]+,)*([^,]+)$/',
            'search_values' => 'nullable|string|regex:/^([^,]+,)*([^,]+)$/',
            'search_value' => 'nullable|string',
            'sort_by' => 'nullable|string',
            'sort_type' => 'nullable|in:asc,desc',
            'view' => 'nullable',
        ];
    }
}