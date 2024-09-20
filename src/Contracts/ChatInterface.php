<?php

namespace TolgaTasci\Chat\Contracts;

use TolgaTasci\Chat\Models\Conversation;
use TolgaTasci\Chat\Models\Message;

interface ChatInterface
{
    public function createConversation(array $participants, string $type = 'private', array $data = []): Conversation;

    public function sendMessage(Conversation $conversation, $sender, string $content, string $type = 'text', array $data = []): Message;

    // Diğer metodlar...
}
