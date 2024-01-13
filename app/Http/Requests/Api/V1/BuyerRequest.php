<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class BuyerRequest extends FormRequest
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
            'offer' => 'string|required|min:3|max:255',
            'message' => 'string|required|min:3|max:255',
            'law' => 'string|required',
            'nda' => 'boolean|required',
            'consultant_type' => 'required|integer',
            'status_id' => 'required|integer',
            'project_id' => 'required|integer',
            'file' => [File::types(['docx', 'pdf']),'required'],


        ];
    }
}
