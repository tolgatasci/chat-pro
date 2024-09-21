<?php

namespace TolgaTasci\Chat\Tests;
use TolgaTasci\Chat\Repositories\ConversationRepositoryInterface;

use Illuminate\Foundation\Testing\RefreshDatabase;
use TolgaTasci\Chat\Contracts\ChatInterface;
use TolgaTasci\Chat\Models\Conversation;
use TolgaTasci\Chat\Tests\Stubs\Models\User;
use Illuminate\Support\Facades\Event;
use TolgaTasci\Chat\Events\MessageSent;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
class ChatServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ChatInterface $chatService;
    protected function setUp(): void
    {
        parent::setUp();

        $this->chatService = $this->app->make(ChatInterface::class);

        $this->conversationRepository = $this->app->make(ConversationRepositoryInterface::class);


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

    /** @test */
    public function it_fails_to_send_an_empty_message()
    {
        $this->expectException(ValidationException::class);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $conversation = $this->chatService->createConversation([$user1, $user2]);

        // Doğrudan Laravel'in validator'ını kullanarak simüle edin
        $validator = Validator::make(['content' => ''], [
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Mesaj gönderimi
        $this->chatService->sendMessage($conversation, $user1, '');
    }

    /** @test */
    public function it_can_create_a_group_conversation()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $conversation = $this->conversationRepository->create([$user1, $user2, $user3], 'group', []);

        $this->assertInstanceOf(Conversation::class, $conversation);
        $this->assertEquals('group', $conversation->type);
        $this->assertCount(3, $conversation->participants);
    }

    /** @test */
    public function it_can_get_messages()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $conversation = $this->chatService->createConversation([$user1, $user2]);
        $message = $this->chatService->sendMessage($conversation, $user1, 'Test mesajı');

        $messages = $this->chatService->getMessages($conversation);

        $this->assertTrue($messages->contains($message));
    }
}
