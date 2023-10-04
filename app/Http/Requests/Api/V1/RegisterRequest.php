<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:64',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|confirmed|min:6|max:100',
            'email'=>'required|string|max:100|unique:users,email',
            'type_id'=> Rule::in([1,2]),
        ];
    }
}
