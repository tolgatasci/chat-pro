<?php

namespace TolgaTasci\Chat\Traits;

use TolgaTasci\Chat\Models\Conversation;

trait Messageable
{
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user', 'user_id', 'conversation_id');
    }

    public function messages()
    {
        return $this->hasManyThrough(Message::class, Conversation::class);
    }

    public function sendMessageTo($recipient, $messageContent)
    {
        // İki kullanıcı arasında mevcut bir konuşma var mı kontrol et
        $conversation = Conversation::between($this, $recipient);

        if (!$conversation) {
            $conversation = Conversation::createConversation([$this, $recipient]);
        }

        return $conversation->sendMessage($this, $messageContent);
    }

    // Ek fonksiyonlar ekleyebilirsiniz
}
