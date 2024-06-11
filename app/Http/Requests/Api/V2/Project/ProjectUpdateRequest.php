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
            'name' => 'required|string|min:3|max:255',
            'type_id' => 'required|integer|exists:predefined_values,id,deleted_at,NULL',
            'category_id' => 'required|integer|exists:categories,id',
            'website' => 'required|string',
            'establishment_date' => 'required|date',
            'country_id' => 'required|integer|exists:regions,id',
            'other_platform' => 'sometimes|required|string',
            'currency_id' => 'required|integer|exists:currencies,id',
            'yearly' => 'nullable|boolean',
            'other_assets' => 'nullable|string',
            'is_supported' => 'nullable|boolean',
            'support' => 'nullable|string',
            'email_subscribers' => 'nullable|string',
            'other_social_media' => 'nullable|string',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'video_url' => 'nullable|url',
            'price' => 'required|numeric',
            'package_id' => 'nullable|integer|exists:packages,id',
            'revenue_sources' => 'required|array',
            'platforms' => 'required|array',
            'platforms.*' => 'required|integer|exists:platforms,id',
            'assets' => 'required|array',
            'assets.*' => 'required|integer|exists:assets,id',
        ];
    }
}