<?php

namespace TolgaTasci\Chat\Facades;

use Illuminate\Support\Facades\Facade;
use TolgaTasci\Chat\Contracts\ChatInterface;

/**
 * @method static \TolgaTasci\Chat\Models\Conversation createConversation(array $participants, string $type = 'private', array $data = [])
 * @method static \TolgaTasci\Chat\Models\Message sendMessage(\TolgaTasci\Chat\Models\Conversation $conversation, $sender, string $content, string $type = 'text', array $data = [])
 */
class Chat extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ChatInterface::class;
    }
}
