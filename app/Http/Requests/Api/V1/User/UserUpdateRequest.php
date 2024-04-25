<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @bodyParam password_confirmation string required Confirm password
 */
class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //auth()->check() && auth()->id() === (int) $this->route('id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->route('user.id', null);

        return [
            'name' => 'sometimes|required|string|min:3|max:64',
            'phone' => 'sometimes|required|string|max:20|unique:users,phone,' . $id . ',id',
            'email' => 'nullable|string|email|max:100|unique:users,email,' . $id . ',id',
            'password' => 'sometimes|required|confirmed|min:6|max:100',
            'oldpassword' => 'required_with:password|string|max:100',
            'photo' => 'nullable|image|max:10240',
            'verification_code' => 'sometimes|required|string|min:4|max:6',
            'type_id' => Rule::in([1, 2]),
            'about' => 'sometimes|required|min:6|max:300',
            'purchase_purpose' => 'sometimes|required|min:6|max:200',
            'budget' => 'sometimes|required|min:6|max:200',
            'favorite_value' => 'sometimes|required|min:3|max:200',
            'profession' => 'sometimes|required|min:6|max:200',
            'owner_of' => 'sometimes|required|min:6|max:200',
            'portfolio' => 'sometimes|required|min:6|max:200',
            'website' => 'sometimes|required|min:6|max:200',
        ];
    }
}
