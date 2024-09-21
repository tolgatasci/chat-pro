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

    public function sendMessage(Conversation $conversation, $sender, string $content, string $type = 'text', array $data = [], $file = null): Message
    {
        // Dosya varsa yükle ve yolunu sakla
        if ($file) {
            $filePath = $file->store('uploads/chat_files');
            $data['attachment'] = $filePath;
        }

        // Mesajı oluştur
        $message = $conversation->messages()->create([
            'sender_id' => $sender->id,
            'content' => $content,
            'type' => $type,
            'data' => $data,
            'attachment' => $file ? $filePath : null, // Eklenen dosya veya resim yolu
        ]);

        // Mesaj gönderim event'ini tetikle
        event(new \TolgaTasci\Chat\Events\MessageSent($message));

        return $message;
    }
    public function getMessages(Conversation $conversation, int $perPage = 25)
    {
        return $this->messageRepository->getMessages($conversation, $perPage);
    }
}
