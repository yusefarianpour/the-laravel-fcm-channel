# The Laravel FCM Channel
The Laravel Firebase Cloud Messaging(FCM) Notification Channel

Use this package to send push notifications via Laravel to Firebase Cloud Messaging. Laravel 5.3+ required.

## Install

This package can be installed through Composer.

``` bash
composer require journalctl/laravel-to-fcm
```

Add your Firebase API Key to `config/services.php`

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
use Journalctl\Channels\FirebaseChannel;

...

public function via($notifiable)
{
    return [FirebaseChannel::class];
}
```

Add the method `public function toFcm($notifiable)` to your notification, and return an instance of `FirebaseMessage`:

```php
use Journalctl\Channels\FirebaseChannel;
use Journalctl\Channels\FirebaseMessage;

...

public function toFcm($notifiable)
{
    $message = new FirebaseMessage();

    $message
        ->title('Foo')  // Required
        ->body('Bar')   // Required
        ->sound()   // Optional
        ->icon()   // Optional
        ->clickAction();    // Optional

    $message->data([
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

The "The Laravel FCM Channel" is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
