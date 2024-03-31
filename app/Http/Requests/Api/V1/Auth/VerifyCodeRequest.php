<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Enums\VerificationAction;
use Illuminate\Foundation\Http\FormRequest;

class VerifyCodeRequest extends FormRequest
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
        $verificationActions = array_column(VerificationAction::cases(), 'value');
        $verificationActionsStr = implode(',', $verificationActions);

        return [
            'phone' => 'required|string|max:20',
            'code' => 'required|string|min:6|max:6',
            'action' => 'required|string|in:' . $verificationActionsStr,
        ];
    }
}
