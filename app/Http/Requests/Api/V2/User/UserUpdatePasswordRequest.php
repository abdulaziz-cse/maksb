<?php

namespace App\Http\Requests\Api\V2\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdatePasswordRequest extends FormRequest
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
            'old_password' => 'required|string|min:8|max:100',
            'new_password' => 'required|string|min:8|max:100|confirmed',
        ];
    }
}