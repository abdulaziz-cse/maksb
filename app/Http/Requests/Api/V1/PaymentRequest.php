<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payment_type' => 'nullable|string|in:product',
            'gateway' => 'required|string|in:paypal,moyasar,cash',
            'method' => 'required|string|in:creditcard,sadad,cash',
            'card_name' => 'required_if:method,creditcard|string|max:150',
            'card_number' => 'required_if:method,creditcard|numeric',
            'card_cvc' => 'required_if:method,creditcard|numeric',
            'card_month' => 'required_if:method,creditcard|numeric',
            'card_year' => 'required_if:method,creditcard|numeric',
            'sadad_username' => 'required_if:method,sadad',
            'products' => 'required|array|min:1',
            'products.*' => 'required|array|size:2',
            'products.*.id' => 'required|integer|exists:ads,id',
            'products.*.quantity' => 'required|integer|min:1|max:100',
        ];
    }
}
