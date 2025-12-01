<?php

declare(strict_types=1);

namespace NotificationChannels\SmsSpeedaMobile;

use Spatie\LaravelPackageTools\Package;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use NotificationChannels\SmsSpeedaMobile\Exceptions\CouldNotSendNotification;

class SmsSpeedaMobileServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        Notification::resolved(function (ChannelManager $service): void {
            $service->extend('speedaMobile', function ($app): SmsSpeedaMobileChannel {
                $key = config('sms-speeda-mobile.api_key');
                $password = config('sms-speeda-mobile.api_secret');
                if (! $key || ! $password) {
                    throw CouldNotSendNotification::apiKeyNotProvided();
                }

                return new SmsSpeedaMobileChannel(new SmsSpeedaMobile(
                    apiKey: $key,
                    apiPassword: $password,
                    debug: config('sms-speeda-mobile.debug', false)
                ));
            });
        });
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('sms-speeda-mobile-laravel')
            ->hasConfigFile('sms-speeda-mobile');
    }
}
