<?php

namespace TolgaTasci\Chat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('sendMessage', $this->route('conversation'));
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string',
            'type' => 'nullable|string',
            'data' => 'nullable|array',
        ];
    }
}
