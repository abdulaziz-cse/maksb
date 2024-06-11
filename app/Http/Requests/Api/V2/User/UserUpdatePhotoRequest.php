<?php

namespace App\Http\Requests\Api\V2\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdatePhotoRequest extends FormRequest
{
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
    public function rules()
    {
        return [
            'photo' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
        ];
    }
}