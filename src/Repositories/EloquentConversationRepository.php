<?php

namespace TolgaTasci\Chat\Repositories;

use TolgaTasci\Chat\Models\Conversation;

class EloquentConversationRepository implements ConversationRepositoryInterface
{
    public function create(array $participants, string $type, array $data): Conversation
    {
        $conversation = Conversation::create([
            'type' => $type,
            'data' => $data,
        ]);

        $participantIds = array_map(function ($participant) {
            return $participant->id;
        }, $participants);

        $conversation->participants()->sync($participantIds);

        return $conversation;
    }

    public function findById(int $id): ?Conversation
    {
        return Conversation::find($id);
    }

    // Diğer metodlar...
}
