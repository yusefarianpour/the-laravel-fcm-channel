# The Laravel FCM Channel
The Laravel Firebase Cloud Messaging(FCM) Notification Channel

Use this package to send push notifications via Laravel to Firebase Cloud Messaging. Laravel 5.3+ required.

## Install

This package can be installed through Composer.

``` bash
composer require yusefarianpour/the-laravel-fcm-channel
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

Or :

```php
public function via($notifiable)
{
    return [FirebaseChannel::class];
}
```

Add the method `public function toFcm($notifiable)` to your notification, and return an instance of `FirebaseMessage`:

```php
use Yusef\TheLaravelFcmChannel\FirebaseChannel;
use Yusef\TheLaravelFcmChannel\FirebaseMessage;

...

public function toFcm($notifiable)
{
    $message = new FirebaseMessage();

    $message->title('Foo')->body('Bar');

    $message->content([
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
