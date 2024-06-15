<?php

namespace App\Http\Requests\Api\V2\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
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
            'name' => 'nullable|string|min:3|max:255',
            'type_id' => 'nullable|integer|exists:predefined_values,id,deleted_at,NULL',
            'category_id' => 'nullable|integer|exists:categories,id',
            'website' => 'nullable|string',
            'establishment_date' => 'nullable|date',
            'country_id' => 'nullable|integer|exists:regions,id',
            'other_platform' => 'nullable|string',
            'currency_id' => 'nullable|integer|exists:currencies,id',
            'yearly' => 'nullable|boolean',
            'other_assets' => 'nullable|string',
            'is_supported' => 'nullable|boolean',
            'support' => 'nullable|string',
            'email_subscribers' => 'nullable|string',
            'other_social_media' => 'nullable|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'price' => 'nullable|numeric',
            'package_id' => 'nullable|integer|exists:packages,id',
            'revenue_sources' => 'nullable|array',
            'platforms' => 'nullable|array',
            'platforms.*' => 'nullable|integer|exists:platforms,id',
            'assets' => 'nullable|array',
            'assets.*' => 'nullable|integer|exists:assets,id',
        ];
    }
}
