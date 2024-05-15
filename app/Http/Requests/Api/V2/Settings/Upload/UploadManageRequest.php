<?php

namespace App\Http\Requests\Api\V2\Settings\Upload;

use Illuminate\Foundation\Http\FormRequest;

class UploadManageRequest extends FormRequest
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
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
            'file' => 'required|file|max:2048|mimes:pdf,docx',
        ];
    }
}
