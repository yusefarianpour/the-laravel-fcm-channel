<?php

namespace Journalctl\Channels;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

/**
 * Class FirebaseServiceProvider
 * @package Journalctl\Channels
 */
class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register
     */
    public function register()
    {
        $app = $this->app;
        $this->app->make(ChannelManager::class)->extend('fcm', function() use ($app) {
            return $app->make(FirebaseChannel::class);
        });
    }
}
