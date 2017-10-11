<?php

namespace Atio\TheFcmChannel;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

/**
 * Class FcmNotificationServiceProvider
 * @package Atio\TheFcmChannel
 */
class FcmNotificationServiceProvider extends ServiceProvider
{

    /**
     * Register
     */
    public function register()
    {
        $app = $this->app;
        $this->app->make(ChannelManager::class)->extend('fcm', function() use ($app) {
            return $app->make(FcmChannel::class);
        });
    }
}
