<?php

namespace Journalctl\Channels;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

/**
 * Class FirebaseChannel
 * @package Journalctl\Channels
 */
class FirebaseChannel
{
    /**
     * @const The API URL for Firebase
     */
    const API_URI = 'https://fcm.googleapis.com/fcm/send';

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param mixed $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var FcmMessage $message */
        $message = $notification->toFcm($notifiable);

        if (is_null($message->getTo())) {
            if (!$to = $notifiable->routeNotificationFor('fcm')) {
                return;
            }

            $message->to($to);
        }

        $this->client->request('post', self::API_URI, [
            'verify' => false,
            'headers' => [
                'Authorization' => 'key=' . $this->getApiKey(),
                'Content-Type'  => 'application/json',
            ],
            'body' => $message->formatData(),
        ]);
    }

    /**
     * @return string
     */
    private function getApiKey()
    {
        return config('services.fcm.key');
    }
}
