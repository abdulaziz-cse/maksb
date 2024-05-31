<?php

namespace App\Http\Requests\Api\V2\Auth;

use App\Enums\Auth\VerificationAction;
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

    public function rules(): array
    {
        $verificationActions = array_column(VerificationAction::cases(), 'value');
        $verificationActionsStr = implode(',', $verificationActions);

        return [
            'phone' => 'required|string|exists:verification_codes,phone|max:20',
            'code' => 'required|string|min:6|max:6',
            'action' => 'required|string|in:' . $verificationActionsStr,
        ];
    }
}
