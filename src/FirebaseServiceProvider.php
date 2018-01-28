<?php

namespace Yusef\Channels;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

/**
 * Class FcmNotificationServiceProvider
 * @package Yusef\Channels\Providers
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
