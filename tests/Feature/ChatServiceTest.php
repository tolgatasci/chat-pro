<?php

namespace TolgaTasci\Chat\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use TolgaTasci\Chat\Contracts\ChatInterface;
use TolgaTasci\Chat\Models\Conversation;
use TolgaTasci\Chat\Tests\TestCase;
use TolgaTasci\Chat\Tests\stubs\models\User;

class ChatServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ChatInterface $chatService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->chatService = $this->app->make(ChatInterface::class);
    }

    public function test_create_conversation()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $conversation = $this->chatService->createConversation([$user1, $user2]);

        $this->assertInstanceOf(Conversation::class, $conversation);
        $this->assertCount(2, $conversation->participants);
    }

    // Diğer testler...
}
