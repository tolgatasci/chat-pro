<?php

namespace TolgaTasci\Chat\Repositories;

use TolgaTasci\Chat\Models\Conversation;
use TolgaTasci\Chat\Models\Message;

class EloquentMessageRepository implements MessageRepositoryInterface
{
    public function create(Conversation $conversation, $sender, string $content, string $type, array $data): Message
    {
        $message = $conversation->messages()->create([
            'sender_id' => $sender->id,
            'content' => $content,
            'type' => $type,
            'data' => $data,
        ]);

        event(new \TolgaTasci\Chat\Events\MessageSent($message));

        return $message;
    }

    public function findById(int $id): ?Message
    {
        return Message::find($id);
    }

    // Diğer metodlar...
}
