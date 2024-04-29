<?php

namespace App\Http\Requests\Api\V2\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ProjectManageRequest extends FormRequest
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
        return [
            'name' => 'required|string|min:3|max:255',
            'type_id' => 'required|integer|exists:predefined_values,id,deleted_at,NULL',
            'category_id' => 'required|integer|exists:categories,id',
            'website' => 'required|string',
            'establishment_date' => 'required|date',
            'country_id' => 'required|integer|exists:countries,id',
            'other_platform' => 'sometimes|required|string',
            'currency_id' => 'required|integer|exists:currencies,id',
            'yearly' => 'nullable|boolean',
            'incoming' => 'nullable|json',
            'cost' => 'nullable|json',
            'revenue' => 'nullable|json',
            'expenses' => 'required|json',
            'other_assets' => 'sometimes|required|string',
            'is_supported' => 'boolean',
            'support' => 'sometimes|required|string',
            'social_media' => 'required|json',
            'email_subscribers' => 'nullable|string',
            'other_social_media' => 'sometimes|required|string',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'video_url' => 'nullable|url',
            'price' => 'required|string',
            'package_id' => 'nullable|integer',
            'billing_info' => 'nullable|json',
            'revenue_sources' => 'required|array',
            'platforms' => 'required|array',
            'platforms.*' => 'required|integer|exists:platforms,id',
            'assets' => 'required|array',
            'assets.*' => 'required|integer|exists:assets,id',
            'image1' => 'image',
            'image2' => 'image',
            'image3' => 'image',
            'file1' => [File::types(['docx', 'pdf'])],
            'file2' => [File::types(['docx', 'pdf'])],
            'file3' => [File::types(['docx', 'pdf'])]
        ];
    }
}
