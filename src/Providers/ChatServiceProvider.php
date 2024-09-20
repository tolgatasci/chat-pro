<?php

namespace TolgaTasci\Chat\Providers;

use Illuminate\Support\ServiceProvider;
use TolgaTasci\Chat\Contracts\ChatInterface;
use TolgaTasci\Chat\Repositories\ConversationRepositoryInterface;
use TolgaTasci\Chat\Repositories\EloquentConversationRepository;
use TolgaTasci\Chat\Repositories\MessageRepositoryInterface;
use TolgaTasci\Chat\Repositories\EloquentMessageRepository;
use TolgaTasci\Chat\Services\ChatService;

class ChatServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bağımlılık Enjeksiyonu
        $this->app->singleton(ConversationRepositoryInterface::class, EloquentConversationRepository::class);
        $this->app->singleton(MessageRepositoryInterface::class, EloquentMessageRepository::class);

        $this->app->singleton(ChatInterface::class, function ($app) {
            return new ChatService(
                $app->make(ConversationRepositoryInterface::class),
                $app->make(MessageRepositoryInterface::class)
            );
        });

        // Konfigürasyon Dosyasını Birleştirme
        $this->mergeConfigFrom(__DIR__ . '/../../config/chat.php', 'chat');
    }

    public function boot()
    {
        // Migration'ları Yükleme
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Yayınlanabilir Dosyalar
        $this->publishes([
            __DIR__ . '/../../config/chat.php' => config_path('chat.php'),
        ], 'config');
    }
}
