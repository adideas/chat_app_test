<?php

namespace Adideas\ChatApp\Providers;

use Adideas\ChatApp\ChatApp\Channel\ChatAppChannel;
use Adideas\ChatApp\Console\Commands\ChatAppRefreshTokenCommand;
use Adideas\ChatApp\Helper\GetRootDirectory;
use Illuminate\Foundation\Application;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(GetRootDirectory::path('routes', 'web.php'));
        $this->loadRoutesFrom(GetRootDirectory::path('routes', 'api.php'));

        $this->app->make(ChannelManager::class)->extend('chatApp', function (Application $app) {
            return new ChatAppChannel(
                $this->app->make('events')
            );
        });

        if ($this->runningInConsole()) {
            // php artisan vendor:publish --tag=chat-app
            $this->publishes(
                [
                    GetRootDirectory::path(['migrations']) => $this->app->databasePath('migrations'),
                    GetRootDirectory::path(['config']) => $this->app->basePath('config')
                ], 'chat-app'
            );
        }
    }

    public function register(): void
    {
        $this->registerConfigs();
        $this->registerCommands();
    }

    protected function runningInConsole(): bool
    {
        return $this->app->runningInConsole();
    }

    /*
    |----------------------------------------------------------------------------------
    | Register Config Files
    |----------------------------------------------------------------------------------
    | Регистрация конфигурационных файлов
    |----------------------------------------------------------------------------------
     */
    private function registerConfigs(): void
    {
        $path = GetRootDirectory::path('config', 'chat_app.php');
        $this->mergeConfigFrom($path, 'chat_app');
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ChatAppRefreshTokenCommand::class
            ]);
        }
    }
}
