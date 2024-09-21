<?php

namespace TolgaTasci\Chat\Repositories;

use TolgaTasci\Chat\Models\Conversation;
use TolgaTasci\Chat\Models\Message;

interface MessageRepositoryInterface
{
    public function create(Conversation $conversation, $sender, string $content, string $type, array $data): Message;

    public function findById(int $id): ?Message;

    public function getMessages(Conversation $conversation, int $perPage = 25);

}
