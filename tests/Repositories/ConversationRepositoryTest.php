<?php

namespace TolgaTasci\Chat\Tests\Repositories;

use TolgaTasci\Chat\Models\Conversation;
use TolgaTasci\Chat\Repositories\ConversationRepositoryInterface;
use TolgaTasci\Chat\Tests\TestCase;
use TolgaTasci\Chat\Tests\stubs\models\User;

class ConversationRepositoryTest extends TestCase
{
    protected ConversationRepositoryInterface $conversationRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->conversationRepository = $this->app->make(ConversationRepositoryInterface::class);
    }

    /** @test */
    public function it_can_create_conversation()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $conversation = $this->conversationRepository->create([$user1, $user2], 'private', []);

        $this->assertInstanceOf(Conversation::class, $conversation);
        $this->assertEquals('private', $conversation->type);
        $this->assertCount(2, $conversation->participants);
    }

    // Diğer testler...
}
