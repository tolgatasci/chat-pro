<?php

namespace TolgaTasci\Chat\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use TolgaTasci\Chat\Providers\ChatServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ChatServiceProvider::class,
        ];
    }
    protected function setUp(): void
    {
        parent::setUp();

        // Laravel'in varsayılan migration'larını yükleyin (users tablosu için)
        $this->loadLaravelMigrations(['--database' => 'testbench']);

        // Paketinizin migration'larını yükleyin
        $this->loadMigrationsFrom([
            '--database' => 'testbench',
            '--path' => realpath(__DIR__ . '/../database/migrations'),
        ]);

        // Migration'ları çalıştırın
        $this->artisan('migrate', ['--database' => 'testbench'])->run();
    }
    protected function getEnvironmentSetUp($app)
    {
        // Kullanıcı modelini testlerdeki User modeli olarak ayarlayın
        $app['config']->set('auth.providers.users.model', \TolgaTasci\Chat\Tests\Stubs\Models\User::class);

        // Chat paketinin user_model ayarını da güncelleyin
        $app['config']->set('chat.user_model', \TolgaTasci\Chat\Tests\Stubs\Models\User::class);

        // Veritabanı ayarlarını yapın
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => 'test.sqlite3',
            'prefix' => '',
        ]);
    }
}
