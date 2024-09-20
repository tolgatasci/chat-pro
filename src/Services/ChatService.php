<?php

namespace TolgaTasci\Chat\Services;

use TolgaTasci\Chat\Contracts\ChatInterface;
use TolgaTasci\Chat\Models\Conversation;
use TolgaTasci\Chat\Models\Message;
use TolgaTasci\Chat\Repositories\ConversationRepositoryInterface;
use TolgaTasci\Chat\Repositories\MessageRepositoryInterface;

class ChatService implements ChatInterface
{
    protected $conversationRepository;
    protected $messageRepository;

    public function __construct(
        ConversationRepositoryInterface $conversationRepository,
        MessageRepositoryInterface $messageRepository
    ) {
        $this->conversationRepository = $conversationRepository;
        $this->messageRepository = $messageRepository;
    }

    public function createConversation(array $participants, string $type = 'private', array $data = []): Conversation
    {
        return $this->conversationRepository->create($participants, $type, $data);
    }

    public function sendMessage(Conversation $conversation, $sender, string $content, string $type = 'text', array $data = []): Message
    {
        return $this->messageRepository->create($conversation, $sender, $content, $type, $data);
    }

    // Diğer metodlar...
}
