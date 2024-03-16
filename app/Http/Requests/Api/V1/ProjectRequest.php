<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ProjectRequest extends FormRequest
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
            'name' => 'string|required|min:3|max:255',
//            'user_id' => 'required|integer',
            'type_id' => 'required|integer',
            'category_id' => 'required|integer',
            'website' => 'required|string',
            'establishment_date' => 'required|date',
            'country_id' => 'required|integer',
            'other_platform' => 'sometimes|required|string',
            'currency_id' => 'required|integer',
            'yearly' => 'required|boolean',
            'incoming' => 'required|json',
            'cost' => 'required|json',
            'revenue' => 'required|json',
            'expenses' => 'required|json',
            'other_assets' => 'sometimes|required|string',
            'is_supported' => 'boolean',
            'support' => 'sometimes|required|string',
            'social_media' => 'required|json',
            'email_subscribers' => 'string',
            'other_social_media' => 'sometimes|required|string',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'video_url' => 'url',
            'price' => 'required|string',
            'package_id' => 'required|integer',
            'billing_info' => 'required|json',
            'revenue_sources' => 'required|array',
            'platforms' => 'required|array',
            'assets' => 'required|array',
            'image1' => 'image',
            'image2' =>'image',
            'image3' =>'image',
            'file1' => [File::types(['docx', 'pdf'])],
            'file2' => [File::types(['docx', 'pdf'])],
            'file3' => [File::types(['docx', 'pdf'])]

        ];
    }
}
