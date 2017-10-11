# the-fcm-channel
The Laravel FCM Notification Channel

Use this package to send push notifications via Laravel to Firebase Cloud Messaging. Laravel 5.3+ required.

## Install

This package can be installed through Composer.

``` bash
composer require atio/the-fcm-channel
```

Once installed, add the service provider:

```php
// config/app.php
'providers' => [
    ...
    Atio\The-FCM-Channel\FcmNotificationServiceProvider::class,
    ...
];
```

Publish the config file:

``` bash
php artisan vendor:publish --provider="Atio\The-FCM-Channel\FcmNotificationServiceProvider"
```

The following config file will be published in `config/the-fcm-channel.php`. Add your Firebase API Key here.

```php
return [
    /*
     * Add the Firebase API key
     */
    'api_key' => ''
];
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

Add the method `public function toFcm($notifiable)` to your notification, and return an instance of `FcmMessage`:

```php
public function toFcm($notifiable)
{
    $message = new yusefarianpour\TheFcmChannel\FcmMessage();
    $message->content([
        'title'        => 'Foo',
        'body'         => 'Bar',
        'sound'        => '', // Optional
        'icon'         => '', // Optional
        'click_action' => '' // Optional
    ])->data([
        'param1' => 'baz' // Optional
    ])->priority(Atio\The-FCM-Channel\FcmMessage::PRIORITY_HIGH); // Optional - Default is 'normal'.

    return $message;
}
```

When sending to specific device, make sure your notifiable entity has `routeNotificationForFcm` method defined:

```php
/**
 * Route notifications for the FCM channel.
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
