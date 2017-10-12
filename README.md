# the-fcm-channel
The Laravel FCM Notification Channel

[![Build Status](https://travis-ci.org/yusefarianpour/the-laravel-fcm-channel.svg?branch=master)](https://travis-ci.org/yusefarianpour/the-laravel-fcm-channel)

Use this package to send push notifications via Laravel to Firebase Cloud Messaging. Laravel 5.3+ required.

## Install

This package can be installed through Composer.

``` bash
composer require Yusef/TheFcmChannel
```

Add your Firebase API Key to services.

```php
'fcm' => [
    'key' => 'Your Firebase Cloud Messaging token',
],
```

## Example Usage

Use Artisan to create a notification:

```bash
php artisan make:notification SomeNotification
```

Return `[fcm]` in the `public function via($notifiable)` method of your notification:

```php
public function via($notifiable)
{
    return ['fcm'];
}
```

Add the method `public function toFcm($notifiable)` to your notification, and return an instance of `FirebaseMessage`:

```php
use Yusef\TheFcmChannel\FirebaseChannel;
use Yusef\TheFcmChannel\FirebaseMessage;

...

public function toFcm($notifiable)
{
    $message = new FirebaseMessage();
    $message->content([
        'title'        => 'Foo',
        'body'         => 'Bar',
        'sound'        => '', // Optional
        'icon'         => '', // Optional
        'click_action' => '' // Optional
    ])->data([
        'param1' => 'baz' // Optional
    ])->priority(FirebaseMessage::PRIORITY_HIGH); // Optional - Default is 'normal'.

    return $message;
}
```

When sending to specific device, make sure your notifiable entity has `routeNotificationForFcm` method defined:

```php
/**
 * Route notifications for the Firebase Cloud Messaging channel.
 *
 * @return string
 */
public function routeNotificationForFcm()
{
    return $this->device_token;
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
