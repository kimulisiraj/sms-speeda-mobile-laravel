# Send laravel notification using speeda mobile

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kimulisiraj/sms-speeda-mobile-laravel.svg?style=flat-square)](https://packagist.org/packages/kimulisiraj/sms-speeda-mobile-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/kimulisiraj/sms-speeda-mobile-laravel/run-tests?label=tests)](https://github.com/kimulisiraj/sms-speeda-mobile-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/kimulisiraj/sms-speeda-mobile-laravel/Check%20&%20fix%20styling?label=code%20style)](https://github.com/kimulisiraj/sms-speeda-mobile-laravel/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kimulisiraj/sms-speeda-mobile-laravel.svg?style=flat-square)](https://packagist.org/packages/kimulisiraj/sms-speeda-mobile-laravel)

Send SMS notifications using [Speeda Mobile](https://speedamobile.com/) with Laravel 9.x and above 

## Installation

You can install the package via composer:

```bash
composer require kimulisiraj/sms-speeda-mobile-laravel
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="sms-speeda-mobile-laravel-config"
```

These are the contents of the published config file:

```php
return [
    'api_key' => env('SPEEDA_MOBILE_API_KEY'),
    'api_secret' => env('SPEEDA_MOBILE_API_SECRET'),
    'debug' => false,   // set to true to see debug messages and not to send out message
];
```

## Usage

```php
$smsSpeedaMobile = new NotificationChannels\SmsSpeedaMobile();
echo $smsSpeedaMobile->echoPhrase('Hello, NotificationChannels!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Siraj Kimuli](https://github.com/kimulisiraj)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
