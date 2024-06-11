<?php

namespace App\Http\Requests\Api\V2\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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

    public function rules()
    {
        $id = $this->route('user.id', null);

        return [
            'name' => 'nullable|string|min:3|max:64',
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $id . ',id',
            'email' => 'nullable|string|email|max:100|unique:users,email,' . $id . ',id',
            'type_id' => 'required|integer|exists:predefined_values,id,deleted_at,NULL',
            'about' => 'nullable|min:6|max:300',
            'purchase_purpose' => 'nullable|min:6|max:200',
            'budget' => 'nullable|min:6|max:200',
            'favorite_value' => 'nullable|min:3|max:200',
            'profession' => 'nullable|min:6|max:200',
            'owner_of' => 'nullable|min:6|max:200',
            'portfolio' => 'nullable|url',
            'website' => 'nullable|url',
        ];
    }
}