<?php

namespace TolgaTasci\Chat\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use TolgaTasci\Chat\Contracts\ChatInterface;
use TolgaTasci\Chat\Models\Conversation;
use TolgaTasci\Chat\Tests\Stubs\Models\User;
use Illuminate\Support\Facades\Event;
use TolgaTasci\Chat\Events\MessageSent;

class ChatServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ChatInterface $chatService;
    protected function setUp(): void
    {
        parent::setUp();

        $this->chatService = $this->app->make(ChatInterface::class);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }


    /** @test */
    public function it_can_create_a_conversation()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $conversation = $this->chatService->createConversation([$user1, $user2]);

        $this->assertInstanceOf(Conversation::class, $conversation);
        $this->assertCount(2, $conversation->participants);
    }

    /** @test */
    public function it_can_create()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $conversation = $this->chatService->createConversation([$user1, $user2]);

        $this->assertInstanceOf(Conversation::class, $conversation);
        $this->assertCount(2, $conversation->participants);
    }

    /** @test */
    public function it_can_send_a_message()
    {
        Event::fake();

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $conversation = $this->chatService->createConversation([$user1, $user2]);

        $messageContent = 'Merhaba, bu bir test mesajıdır.';
        $message = $this->chatService->sendMessage($conversation, $user1, $messageContent);

        $this->assertEquals($messageContent, $message->content);

        Event::assertDispatched(MessageSent::class, function ($event) use ($message) {
            return $event->message->id === $message->id;
        });
    }

    // Diğer test metotları...
}
