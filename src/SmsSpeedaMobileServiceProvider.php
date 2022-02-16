<?php

namespace NotificationChannels\SmsSpeedaMobile;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\SmsSpeedaMobile\Exceptions\CouldNotSendNotification;
use Spatie\LaravelPackageTools\Package;

use Spatie\LaravelPackageTools\PackageServiceProvider;

class SmsSpeedaMobileServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('speedaMobile', function ($app) {
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
