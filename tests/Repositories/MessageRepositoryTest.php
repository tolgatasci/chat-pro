<?php

namespace TolgaTasci\Chat\Tests\Repositories;

use TolgaTasci\Chat\Models\Message;
use TolgaTasci\Chat\Repositories\MessageRepositoryInterface;
use TolgaTasci\Chat\Tests\TestCase;
use TolgaTasci\Chat\Tests\stubs\models\User;
use TolgaTasci\Chat\Models\Conversation;

class MessageRepositoryTest extends TestCase
{
    protected MessageRepositoryInterface $messageRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->messageRepository = $this->app->make(MessageRepositoryInterface::class);
    }

    /** @test */
    public function it_can_create_message()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $conversation = Conversation::create();
        $conversation->participants()->attach([$user1->id, $user2->id]);

        $messageContent = 'Test mesajı';
        $message = $this->messageRepository->create($conversation, $user1, $messageContent, 'text', []);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals($messageContent, $message->content);
        $this->assertEquals($user1->id, $message->sender_id);
    }

    // Diğer testler...
}
