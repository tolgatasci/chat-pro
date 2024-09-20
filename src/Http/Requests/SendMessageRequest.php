<?php

namespace TolgaTasci\Chat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function validated(): array
    {
        $validatedData = parent::validated();

        // Mesaj içeriği XSS saldırılarına karşı temizleniyor
        $validatedData['content'] = htmlspecialchars($validatedData['content'], ENT_QUOTES, 'UTF-8');

        return $validatedData;
    }
    public function authorize(): bool
    {
        return $this->user()->can('sendMessage', $this->route('conversation'));
    }

    public function rules(): array
    {
        return [
            'content' => 'required_without:attachment|string',
            'type' => 'nullable|string',
            'data' => 'nullable|array',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048', // Dosya formatı ve boyut kontrolü
        ];
    }
}
