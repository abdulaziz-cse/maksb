<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ChatMessage;

/**
 * @bodyParam ad_id int Ad id, required if `conversation_id` is absent
 * @bodyParam conversation_id int Conversation id, required if `ad_id` is absent
 * @bodyParam message string required The message can be a string, image or an array of images.
 */
class MessageRequest extends FormRequest
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
            'project_id' => 'required_without:conversation_id|integer|exists:projects,id',
            'message' => ['required', new ChatMessage()],
            'conversation_id' => 'required_without:project_id|integer|exists:conversations,id',
        ];
    }

    public function messages()
    {
        return [
            'project_id.required_without' => 'Please provide project id or conversation id',
            'conversation_id.required_without' => 'Please provide project id or conversation id',
        ];
    }
}
